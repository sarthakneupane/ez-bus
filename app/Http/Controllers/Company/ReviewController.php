<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\BusCompany;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('bus');
    }

    public function index()
    {
        $company = BusCompany::where('user_id', auth()->id())->firstOrFail();
        
        $reviews = Review::with(['booking.schedule.vehicleHasRoutes.vehicle'])
            ->whereHas('booking.schedule.vehicleHasRoutes.vehicle', function($query) use ($company) {
                $query->where('bus_company_id', $company->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $company = BusCompany::where('user_id', auth()->id())->firstOrFail();
        
        // Verify the review belongs to this company
        if ($review->booking->schedule->vehicleHasRoutes->vehicle->bus_company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('company.reviews.show', compact('review'));
    }
}