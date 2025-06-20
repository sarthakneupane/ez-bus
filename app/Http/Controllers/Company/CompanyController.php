<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusCompany;

class CompanyController extends Controller
{
    // Show the form to add a new company
    public function create()
    {
        return view('company.add-company'); // create.blade.php view
    }

    // Store the new company in the database
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        BusCompany::create([
            'bc_name' => $request->name,
            'no_of_bus' =>$request->no_of_bus,
            'user_id' => auth()->id(),         // Store the logged-in user's ID
        ]);

        // Redirect to a page with success message
        return redirect()->route('welcome')->with('status', 'Company added successfully!');
    }
}

