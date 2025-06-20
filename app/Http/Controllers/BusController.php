<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class BusController extends Controller
{
    public function search(Request $request)
    {
        // Validate input
        $request->validate([
            'from_loc' => 'required',
            'to_loc' => 'required',
            'dep_date' => 'required|date',
        ]);

        // Extract date only from database datetime format
        $departureDate = $request->dep_date;

        // Query matching schedules
        $schedules = Schedule::whereDate('departure_date_time', $departureDate)
            ->where('source', $request->from_loc)
            ->where('destination', $request->to_loc)
            ->get();

        return view('buslist', compact('schedules'));
    }
}
