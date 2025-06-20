<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeatFormat;

class SeatFormatController extends Controller
{
    public function index()
    {
        $formats = SeatFormat::all();
        return view('admin.seat_formats.index', compact('formats'));
    }

    public function create()
    {
        return view('admin.seat_formats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'column_left' => 'required|integer|min:0',
            'column_right' => 'required|integer|min:0',
            'rows' => 'required|integer|min:1',
        ]);

        SeatFormat::create($request->all());

        return redirect()->route('admin.seat_formats.index')->with('success', 'Seat format created successfully.');
    }

    public function seatLayoutPartial(SeatFormat $format)
{
    $columnLeft = $format->column_left;
    $columnRight = $format->column_right;
    $rows = $format->rows;

    $seats = [];
    $aCount = 1;
    $bCount = 1;

    for ($r = 0; $r < $rows; $r++) {
        $row = [];

        for ($c = 0; $c < $columnLeft; $c++) {
            $row[] = [
                'number' => 'A' . $aCount++,
                'booked' => false,
            ];
        }

        $row[] = null;

        for ($c = 0; $c < $columnRight; $c++) {
            $row[] = [
                'number' => 'B' . $bCount++,
                'booked' => false,
            ];
        }

        $seats[] = $row;
    }

    return view('admin.seat_formats.seat-format', compact('seats'));
}

}
