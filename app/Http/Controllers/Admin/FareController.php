<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fare;
use App\Models\Route;
use App\Models\VehicleTypeClass;

class FareController extends Controller
{
    // public function index()
    // {
    //     $fares = Fare::with('vehicleTypeClass.vehicleType', 'vehicleTypeClass.vehicleClass', 'route')->get();
    //     return view('admin.fare.index', compact('fares'));
    // }

    // public function create()
    // {
    //     $vehicleTypeClasses = VehicleTypeClass::with('vehicleType', 'vehicleClass')->get();
    //     $routes = Route::all();
    //     return view('admin.fare.create', compact('vehicleTypeClasses', 'routes'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'vehicle_type_class_id' => 'required|exists:vehicle_type_class,id',
    //         'route_id' => 'required|exists:routes,id',
    //         'amount' => 'required|numeric|min:0',
    //     ]);

    //     Fare::create([
    //         'vehicle_type_class_id' => $request->vehicle_type_class_id,
    //         'route_id'=> $request->route_id,
    //         'fare_amount' => $request->amount,
    //     ]);

    //     return redirect()->route('admin.fare.index')->with('success', 'Fare added successfully!');
    // }

    // public function edit($id)
    // {
    //     $fare = Fare::findOrFail($id);
    //     $vehicleTypeClasses = VehicleTypeClass::with('vehicleType', 'vehicleClass')->get();
    //     $routes = Route::all();
    //     return view('admin.fare.edit', compact('fare', 'vehicleTypeClasses', 'routes'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $fare = Fare::findOrFail($id);
    //     $fare->update($request->all());

    //     return redirect()->route('admin.fare.index')->with('success', 'Fare updated successfully!');
    // }

    // public function destroy($id)
    // {
    //     Fare::destroy($id);
    //     return redirect()->route('admin.fare.index')->with('success', 'Fare deleted successfully!');
    // }
}
