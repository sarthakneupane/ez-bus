<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VehicleType;

// IMP
use Illuminate\Support\Str;

class VehicleTypeController extends Controller
{
    // Display all locations
    public function index()
    {
        $vehicle_types = VehicleType::orderBy('created_at', 'DESC')->get();
        return view('admin.vehicle_type.vehicle_type', compact('vehicle_types'));
    }

    // Show the form to add a new location
    public function create()
    {
        return view('admin.vehicle_type.vehicle_type_add');  // This will return the location_add view
    }

    // Store a new location
    public function store(Request $request)
    {
        $request['slug'] = Str::slug($request->name);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:vehicle_types',
        ]);

        $data = new VehicleType();
        $data->name = $request->name;
        $data->slug = $request->slug;

        if ($data->save()) {
            return redirect()->route('admin.vehicle_type.index')->with('success', 'Vehicle type added successfully.');
        }
    }

    // Show the form to edit a location

    // Show the form to edit a location
    public function edit($id)
    {
        $vehicle_type = VehicleType::findOrFail($id);  // Use findOrFail to fetch a single record
        return view('admin.vehicle_type.vehicle_type_edit', compact('vehicle_type'));
    }

    // public function edit($id)
    // {
    //     $vehicle_type = VehicleType::where('id', $id)->get();
    //     if ($vehicle_type) {
    //         return view('admin.vehicle_type.vehicle_type_edit', compact('vehicle_type'));
    //     } else {
    //         abort(404);
    //     }
    // }

    // Update an existing location
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        // ]);

        $vehicle_type = VehicleType::findOrFail($id);
        $vehicle_type->update(['name' => $request->name]);

        return redirect()->route('admin.vehicle_type.index')->with('success', 'Location updated successfully.');
    }

    // Delete a location
    public function destroy($id)
    {
        $vehicle_type = VehicleType::findOrFail($id);
        $vehicle_type->delete();

        return redirect()->route('admin.vehicle_type')->with('success', 'Location deleted successfully.');
    }
}
