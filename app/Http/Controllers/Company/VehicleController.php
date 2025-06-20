<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\SeatFormat;
use App\Models\Route;
use App\Models\VehicleType;
use App\Models\VehicleClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['vehicleType', 'vehicleClass', 'seatFormat'])
            ->where('bus_company_id', Auth::user()->busCompany->id)
            ->get(); // Soft-deleted vehicles are excluded by default
        return view('company.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $vehicleTypes = VehicleType::all();
        $vehicleClasses = VehicleClass::all();
        $seatFormats = SeatFormat::all();

        return view('company.vehicles.create', compact('vehicleTypes', 'vehicleClasses', 'seatFormats'));
    }

    public function store(Request $request)
{
    // Validate the form input
    $validatedData = $request->validate([
        'vehicle_no' => 'required|string|unique:vehicles|max:255',
        'vehicle_type_id' => 'required|exists:vehicle_types,id',
        'vehicle_class_id' => 'required|exists:vehicle_classes,id',
        'seat_formats_id' => 'required|exists:seat_formats,id',
        'amenities' => 'nullable|string',
        'registration_pdf' => 'required|file|mimes:pdf|max:2048',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Store the uploaded PDF and image if present
    if ($request->hasFile('registration_pdf')) {
        $validatedData['registration_pdf'] = $request->file('registration_pdf')->store('vehicle_registrations', 'public');
    }

    if ($request->hasFile('image')) {
        $validatedData['image'] = $request->file('image')->store('vehicle_images', 'public');
    }

    // Assign the bus company ID of the logged-in user
    $validatedData['bus_company_id'] = Auth::user()->busCompany->id;

    // Create the vehicle record
    Vehicle::create($validatedData);

    // Redirect to vehicles list page with success message
    return redirect()->route('company.vehicles')->with('success', 'Vehicle added successfully!');
}


    public function edit(Vehicle $vehicle)
    {
        $vehicleTypes = VehicleType::all();
        $vehicleClasses = VehicleClass::all();
        $seatFormats = SeatFormat::all();

        return view('company.vehicles.edit', compact('vehicle', 'vehicleTypes', 'vehicleClasses', 'seatFormats'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validatedData = $request->validate([
            'vehicle_no' => 'required|string|max:255',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'vehicle_class_id' => 'required|exists:vehicle_classes,id',
            'seat_formats_id' => 'required|exists:seat_formats,id',
            'amenities' => 'nullable|string',
            'registration_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('registration_pdf')) {
            if ($vehicle->registration_pdf) {
                Storage::disk('public')->delete($vehicle->registration_pdf);
            }
            $validatedData['registration_pdf'] = $request->file('registration_pdf')->store('vehicle_registrations', 'public');
        }

        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $validatedData['image'] = $request->file('image')->store('vehicle_images', 'public');
        }

        $vehicle->update($validatedData);

        return redirect()->route('company.vehicles')->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Soft delete only (do not delete files unless permanently deleting)
        $vehicle->delete();

        return redirect()->route('company.vehicles')->with('success', 'Vehicle deleted (soft) successfully!');
    }

    public function vehicleRoutes()
    {
        $vehicles = Vehicle::where('bus_company_id', Auth::user()->busCompany->id)->get();
        return view('company.vehicles.routes', compact('vehicles'));
    }
}
