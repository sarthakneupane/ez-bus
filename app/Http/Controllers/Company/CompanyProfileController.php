<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $company = $user->busCompany;
        return view('company.profile', compact('user', 'company'));
    }

    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'user_phone' => 'required|string|max:20',

        'bc_name' => 'required|string|max:255',
        'no_of_buses' => 'required|integer|min:0',
    ]);

    $user = Auth::user();
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->user_phone,
    ]);

    $company = $user->busCompany;
    $company->update([
        'bc_name' => $request->bc_name,
        'no_of_bus' => $request->no_of_buses,
    ]);

    return redirect()->route('company.profile')->with('success', 'Profile updated successfully.');
}

}
