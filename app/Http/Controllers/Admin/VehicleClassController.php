<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleClass;

class VehicleClassController extends Controller
{
    // Display all locations
    public function index()
    {
        $vehicle_classes = VehicleClass::all();
        return view('admin.vehicle_class.vehicle_class', compact('vehicle_classes'));
    }

    // Show the form to add a new location
    public function create()
    {
        return view('admin.vehicle_class.vehicle_class_add');  // This will return the location_add view
    }

    // Store a new location
    public function store(Request $request)
    {

        VehicleClass::create(['name' => $request->name]);

        return redirect()->route('admin.vehicle_class')->with('success', 'Vehicle type added successfully.');
    }

    // Show the form to edit a location
    public function edit($id)
    {
        $vehicle_class = VehicleClass::findOrFail($id);
        return view('admin.vehicle_class.vehicle_class_edit', compact('vehicle_class'));
    }

    // Update an existing location
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        // ]);

        $vehicle_class = VehicleClass::findOrFail($id);
        $vehicle_class->update(['name' => $request->name]);

        return redirect()->route('admin.vehicle_class')->with('success', 'Location updated successfully.');
    }

    // Delete a location
    public function destroy($id)
    {
        $vehicle_class = VehicleClass::findOrFail($id);
        $vehicle_class->delete();

        return redirect()->route('admin.vehicle_class')->with('success', 'Location deleted successfully.');
    }
}
