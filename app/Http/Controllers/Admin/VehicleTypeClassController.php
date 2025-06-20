<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleTypeClass;
use App\Models\VehicleType;
use App\Models\VehicleClass;
use Illuminate\Http\Request;

class VehicleTypeClassController extends Controller
{
    public function index()
    {
        $vehicleTypeClasses = VehicleTypeClass::with(['vehicleType', 'vehicleClass'])->get();
        $vehicleTypes = VehicleType::all();
        $vehicleClasses = VehicleClass::all();

        $fares = [];
        foreach ($vehicleTypeClasses as $vehicleTypeClass) {
            $fares[] = [
                'id' => $vehicleTypeClass->id,
                'vehicle_type' => $vehicleTypeClass->vehicleType->name,
                'vehicle_class' => $vehicleTypeClass->vehicleClass->name,
                'fare_increment' => $vehicleTypeClass->fare_increment,
            ];
        }

        return view('admin.fare.index', compact('fares', 'vehicleTypes', 'vehicleClasses'));
    }

    public function create()
    {
        $vehicleTypes = VehicleType::all();
        $vehicleClasses = VehicleClass::all();
        return view('admin.fare.create', compact('vehicleTypes', 'vehicleClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vehicle_class_id' => 'required|exists:vehicle_classes,id',
            'fare_increment' => 'required|numeric|min:0',
        ]);

        // Check if combination already exists
        $exists = VehicleTypeClass::where('vehicle_type_id', $request->vehicle_type_id)
            ->where('vehicle_class_id', $request->vehicle_class_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This vehicle type-class combination already exists!');
        }

        VehicleTypeClass::create([
            'vehicle_type_id' => $request->vehicle_type_id,
            'vehicle_class_id' => $request->vehicle_class_id,
            'fare_increment' => $request->fare_increment,
        ]);

        return redirect()->route('admin.fare.index')->with('success', 'Fare increment added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fare_increment' => 'required|numeric|min:0',
        ]);

        $fare = VehicleTypeClass::findOrFail($id);
        $fare->fare_increment = $request->fare_increment;
        $fare->save();

        return back()->with('success', 'Fare increment updated successfully.');
    }

    public function destroy($id)
    {
        $fare = VehicleTypeClass::findOrFail($id);
        $fare->delete();

        return back()->with('success', 'Fare entry deleted successfully.');
    }
}