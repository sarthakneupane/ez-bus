<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\BusCompany;
use App\Models\User;

use Illuminate\Support\Facades\Storage;


class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated
    }

    // Admin Dashboard
    public function dashboard()
    {
        return view('admin.dashboard'); // Create this view
    }

    
    // Admin Profile Page
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user')); // Create 'admin.profile' view
    }
    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'user_phone' => 'required|string|max:20',
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->user_phone,
    ]);
     return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
}

    // location count
    public function count(){
        $locationCount = Location::count();
        return view('admin.dashboard', compact('locationCount'));
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
    
}
