<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChuyenBay;
use Carbon\Carbon;

class FlightController extends Controller
{
    /**
     * Show the flight search form
     */
    public function showSearchForm()
    {
        // Get distinct locations for dropdown menus
        $diemDi = ChuyenBay::distinct()->pluck('diem_di');
        $diemDen = ChuyenBay::distinct()->pluck('diem_den');

        return view('flights.search', compact('diemDi', 'diemDen'));
    }

    /**
     * Search for flights based on criteria
     */
    public function searchFlights(Request $request)
    {
        $request->validate([
            'diem_di' => 'required|string',
            'diem_den' => 'required|string',
            'ngay_di' => 'required|date',
            'so_hanh_khach' => 'required|integer|min:1'
        ]);

        // Parse the date to make sure it's in the correct format
        $ngayDi = Carbon::parse($request->ngay_di)->toDateString();

        // Query flights based on criteria
        $flights = ChuyenBay::where('diem_di', $request->diem_di)
            ->where('diem_den', $request->diem_den)
            ->whereDate('ngay_gio_khoi_hanh', $ngayDi)
            ->where('so_ghe_trong', '>=', $request->so_hanh_khach)
            ->with('hangBay')
            ->get();

        // Store search parameters in session for later use
        session([
            'search_params' => [
                'diem_di' => $request->diem_di,
                'diem_den' => $request->diem_den,
                'ngay_di' => $ngayDi,
                'so_hanh_khach' => $request->so_hanh_khach
            ]
        ]);

        return view('flights.results', compact('flights'));
    }
}
