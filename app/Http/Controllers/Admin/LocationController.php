<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Exception;

class LocationController extends Controller
{
    // Display all active (non-deleted) locations
    public function index()
    {
        $locations = Location::all(); // Only non-deleted by default
        return view('admin.location.location', compact('locations'));
    }

    // Show the form to add a new location
    public function create()
    {
        return view('admin.location.location_add');
    }

    // Store a new location
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
            'stay' => 'nullable'
        ]);

        Location::create(['name' => $request->name]);

        return isset($request->stay) && $request->stay == 'on'
            ? redirect()->back()->with('status', [
                'title' => 'Success',
                'message' => 'Location added successfully.',
                'type' => 'success',
                'icon' => 'la la-check'
            ])
            : redirect()->route('admin.location')->with('status', [
                'title' => 'Success',
                'message' => 'Location added successfully.',
                'type' => 'success',
                'icon' => 'la la-check'
            ]);
    }

    // Show the form to edit a location
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.location.location_edit', compact('location'));
    }

    // Update an existing location
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update(['name' => $request->name]);

        return redirect()->route('admin.location')->with('success', 'Location updated successfully.');
    }

    // Soft delete a location
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        try {
            $location->delete(); // Soft delete
            return redirect()->route('admin.location')->with('success', 'Location deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('status', [
                'title' => 'Error',
                'message' => 'Error deleting ' . $location->name,
                'type' => 'error',
                'icon' => 'la la-times'
            ]);
        }
    }

    // View deleted locations (optional)
    public function trashed()
    {
        $locations = Location::onlyTrashed()->get();
        return view('admin.location.trashed', compact('locations'));
    }

    // Restore soft-deleted location
    public function restore($id)
    {
        $location = Location::onlyTrashed()->findOrFail($id);
        $location->restore();

        return redirect()->route('admin.location')->with('success', 'Location restored successfully.');
    }

    // Permanently delete a location (optional)
    public function forceDelete($id)
    {
        $location = Location::onlyTrashed()->findOrFail($id);
        $location->forceDelete();

        return redirect()->route('admin.location')->with('success', 'Location permanently deleted.');
    }
}
