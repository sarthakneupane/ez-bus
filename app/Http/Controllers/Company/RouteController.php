<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\VehicleHasRoute;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // Show all vehicles with their assigned routes
    public function index()
{
    $vehicles = Vehicle::with(['routes.fromLocation', 'routes.toLocation'])
               ->where('bus_company_id', auth()->user()->busCompany->id)
               ->get();

    return view('company.routes.index', compact('vehicles'));
}


    // Show form to pick a vehicle and assign routes to it
    public function create()
    {
        $vehicles = Vehicle::where('bus_company_id', auth()->user()->busCompany->id)->get();
        $routes = Route::with('fromLocation','toLocation')->get();

        return view('company.routes.create', compact('vehicles', 'routes'));
    }

    // Persist the selected routes for a vehicle
    public function store(Request $request)
{
    $data = $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'route_ids'  => 'required|array|min:1',
        'route_ids.*'=> 'exists:routes,id',
    ]);

    $vehicle = Vehicle::findOrFail($data['vehicle_id']);

    // Sync routes without detaching existing soft-deleted ones
    foreach ($data['route_ids'] as $routeId) {
        // Try to restore if soft-deleted
        VehicleHasRoute::withTrashed()
            ->updateOrCreate(
                [
                    'vehicle_id' => $vehicle->id,
                    'route_id' => $routeId,
                ],
                [
                    'deleted_at' => null,
                    'updated_at' => now(),
                ]
            );
    }

    return redirect()
        ->route('company.routes.index')
        ->with('success', 'Routes assigned successfully.');
}



    // Show form to edit an existing vehicle’s routes
    public function edit($vehicleId)
    {
        $vehicle  = Vehicle::with('routes')
                           ->where('bus_company_id', auth()->user()->busCompany->id)
                           ->findOrFail($vehicleId);
        $vehicles = Vehicle::where('bus_company_id', auth()->user()->busCompany->id)->get();
        $routes = Route::with('fromLocation','toLocation')->get();
        $assigned = $vehicle->routes->pluck('id')->toArray();

        return view('company.routes.edit', compact('vehicle','vehicles','routes','assigned'));
    }

    // Update the pivot with new route selections
    public function update(Request $request, $vehicleId)
{
    $data = $request->validate([
        'route_ids'   => 'required|array|min:1',
        'route_ids.*' => 'exists:routes,id',
    ]);

    $vehicle = Vehicle::findOrFail($vehicleId);

    // Soft delete unselected
    $vehicle->routes()->whereNotIn('route_id', $data['route_ids'])->update(['deleted_at' => now()]);

    // Restore or insert selected
    foreach ($data['route_ids'] as $routeId) {
        $vehicle->routes()->updateOrInsert(
            ['route_id' => $routeId],
            ['deleted_at' => null, 'updated_at' => now()]
        );
    }

    return redirect()
        ->route('company.routes.index')
        ->with('success', 'Routes updated successfully.');
}


public function destroy($vehicleId)
{
    VehicleHasRoute::where('vehicle_id', $vehicleId)->update([
        'deleted_at' => now()
    ]);

    return redirect()
        ->route('company.routes.index')
        ->with('success', 'All routes soft deleted from vehicle.');
}

}

