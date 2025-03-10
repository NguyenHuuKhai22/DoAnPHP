<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChuyenBay;
use App\Models\NguoiDung;
use App\Models\VeMayBay;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show the selected flight for booking
     */
    public function selectFlight($id)
    {
        // Get the flight details
        $flight = ChuyenBay::with('hangBay')->findOrFail($id);

        // Get search parameters from session
        $searchParams = session('search_params', []);
        $soHanhKhach = $searchParams['so_hanh_khach'] ?? 1;

        // Available seat types and their prices (factor multipliers)
        $seatTypes = [
            'pho_thong' => [
                'name' => 'Phổ thông',
                'price_factor' => 1.0 // Base price
            ],
            'pho_thong_dac_biet' => [
                'name' => 'Phổ thông đặc biệt',
                'price_factor' => 1.4 // 40% more expensive
            ],
            'thuong_gia' => [
                'name' => 'Thương gia',
                'price_factor' => 2.2 // 120% more expensive
            ]
        ];

        return view('booking.select-flight', compact('flight', 'seatTypes', 'soHanhKhach'));
    }

    /**
     * Collect passenger information
     */
    public function passengerInfo(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:Chuyen_Bay,id_chuyen_bay',
            'seat_type' => 'required|string',
            'num_passengers' => 'required|integer|min:1'
        ]);

        $flight = ChuyenBay::findOrFail($request->flight_id);
        $seatType = $request->seat_type;
        $numPassengers = $request->num_passengers;

        // Calculate price based on seat type
        $priceFactor = 1.0; // Default for economy class
        if ($seatType == 'pho_thong_dac_biet') {
            $priceFactor = 1.4;
        } else if ($seatType == 'thuong_gia') {
            $priceFactor = 2.2;
        }

        $totalPrice = $flight->gia_ve_co_ban * $priceFactor * $numPassengers;

        // Store booking details in session
        session([
            'booking_details' => [
                'flight_id' => $flight->id_chuyen_bay,
                'seat_type' => $seatType,
                'num_passengers' => $numPassengers,
                'price_per_seat' => $flight->gia_ve_co_ban * $priceFactor,
                'total_price' => $totalPrice
            ]
        ]);

        return view('booking.passenger-info', compact('flight', 'numPassengers', 'seatType', 'totalPrice'));
    }

    /**
     * Review booking details before payment
     */
    public function reviewBooking(Request $request)
    {
        // Validate passenger information
        $request->validate([
            'passenger_name.*' => 'required|string|max:100',
            'passenger_email.*' => 'required|email',
            'passenger_phone.*' => 'required|string|max:15',
        ]);

        // Get booking details from session
        $bookingDetails = session('booking_details');
        if (!$bookingDetails) {
            return redirect()->route('flights.search')
                ->with('error', 'Booking session expired. Please start again.');
        }

        $flight = ChuyenBay::with('hangBay')->findOrFail($bookingDetails['flight_id']);

        // Collect passenger details
        $passengers = [];
        for ($i = 0; $i < count($request->passenger_name); $i++) {
            $passengers[] = [
                'name' => $request->passenger_name[$i],
                'email' => $request->passenger_email[$i],
                'phone' => $request->passenger_phone[$i]
            ];
        }

        // Update booking details with passenger information
        $bookingDetails['passengers'] = $passengers;
        session(['booking_details' => $bookingDetails]);

        // Prepare payment methods
        $paymentMethods = [
            'visa' => 'Thẻ Visa',
            'mastercard' => 'Thẻ MasterCard',
            'jcb' => 'Thẻ JCB',
            'momo' => 'Ví MoMo',
            'vnpay' => 'VNPay',
            'zalopay' => 'ZaloPay'
        ];

        return view('booking.review', compact('flight', 'bookingDetails', 'paymentMethods'));
    }
}
