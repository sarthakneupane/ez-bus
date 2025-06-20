<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusCompany;
use App\Models\Schedule;
use App\Models\Review;
use App\Models\User;

class BusCompanyController extends Controller
{
    // Display all bus companies
    public function index()
    {
        $buses = BusCompany::all(); // Fetch all bus companies
        return view('admin.bus_company.bus_company', compact('buses')); // Pass the data to the view
    }
    public function show($id)
{
    $company = BusCompany::with(['user', 'vehicles.reviews'])->findOrFail($id);
    $vehicleCount = $company->vehicles->count();

    // Company-wide average rating
    $avgRating = Review::whereHas('booking.schedule.vehicleHasRoute.vehicle', function ($query) use ($id) {
        $query->where('bus_company_id', $id);
    })->avg('stars');

    // Company-wide reviews (messages)
    $companyReviews = Review::with('user') // optional: eager load user info
        ->whereHas('booking.schedule.vehicleHasRoute.vehicle', function ($query) use ($id) {
            $query->where('bus_company_id', $id);
        })
        ->latest()
        ->get();

    return view('admin.bus_company.company-details', compact('company', 'avgRating', 'companyReviews', 'vehicleCount'));
}

public function approveCompany($id)
    {
        $busCompany = BusCompany::find($id);
    
        if ($busCompany) {
            $busCompany->status = '1'; // Ensure correct ENUM value
            $saved = $busCompany->save();
    
            if ($saved) {
                // Update user role when company is approved
                $user = User::find($busCompany->user_id); // Assuming bus_company has user_id
                if ($user) {
                    $user->role = '1'; // Change role
                    $user->save(); // Save the change
                }
    
                return redirect()->back()->with('success', 'Company approved successfully!');
            }
    
            return redirect()->back()->with('error', 'Failed to update status.');
        }
    
        return redirect()->back()->with('error', 'Company not found.');
    }
public function rejectCompany($id)
{
    $company = BusCompany::findOrFail($id);
    $company->status = '2'; // or any specific 'rejected' status code if you use a different one
    $company->save();

    return redirect()->back()->with('success', 'Company has been rejected.');
}

public function toggleStatus($id)
{
    $company = BusCompany::findOrFail($id);
    $company->status = $company->status == '1' ? '0' : '1';
    $company->save();

    return redirect()->back()->with('success', 'Company status updated successfully.');
}

    public function schedule($companyId)
{
    $company = BusCompany::findOrFail($companyId);
    
    $schedules = Schedule::with([
            'vehicleHasRoute.vehicle', 
            'vehicleHasRoute.route',
            'bookedSeats'
        ])
        ->whereHas('vehicleHasRoute.vehicle', function($query) use ($companyId) {
            $query->where('bus_company_id', $companyId);
        })
        ->where('status', '1')
        ->get();
        
    return view('admin.bus_company.schedules', compact('schedules', 'company'));
}


}
