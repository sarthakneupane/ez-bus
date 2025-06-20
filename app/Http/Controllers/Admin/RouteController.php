<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Location;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // Show active (non-deleted) routes
    public function index()
    {
        $routes = Route::with(['fromLocation', 'toLocation'])->whereNull('deleted_at')->get();
        return view('admin.route.route', compact('routes'));
    }

    // Show soft-deleted routes (trash)
    public function trash()
    {
        $routes = Route::onlyTrashed()->with(['fromLocation', 'toLocation'])->get();
        return view('admin.route.route_trash', compact('routes'));
    }

    public function create()
    {
        $locations = Location::all();

        if (request()->has('getlocation')) {
            $from = request('from');
            $loc = Location::where('id', '!=', $from)->get();
            return response()->json($loc);
        }

        return view('admin.route.route_add', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from' => 'required|exists:locations,id',
            'to' => 'required|exists:locations,id',
            'fare' => 'required|numeric|min:0',
        ]);

        Route::create($request->all());

        return redirect('/admin/route')->with('success', 'Route added successfully.');
    }

    public function edit($id)
    {
        $route = Route::findOrFail($id);
        $locations = Location::all();
        return view('admin.route.route_edit', compact('route', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'from' => 'required|exists:locations,id',
            'to' => 'required|exists:locations,id',
            'fare' => 'required|numeric|min:0',
        ]);

        $route = Route::findOrFail($id);
        $route->update($request->all());

        return redirect('/admin/route')->with('success', 'Route updated successfully.');
    }

    // Soft delete the route
    public function destroy($id)
    {
        $route = Route::findOrFail($id);
        $route->delete();

        return redirect('/admin/route')->with('success', 'Route moved to trash.');
    }

    // Restore a soft-deleted route
    public function restore($id)
    {
        $route = Route::onlyTrashed()->findOrFail($id);
        $route->restore();

        return redirect()->back()->with('success', 'Route restored successfully.');
    }

    // Permanently delete a soft-deleted route
    public function forceDelete($id)
    {
        $route = Route::onlyTrashed()->findOrFail($id);
        $route->forceDelete();

        return redirect()->back()->with('success', 'Route permanently deleted.');
    }
}
