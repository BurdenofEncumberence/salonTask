<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\SalonService;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServices = SalonService::count();
        $totalBookings = Booking::count();
        $totalPaidPayments = Payment::where('payment_status', 'paid')->count();
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount_paid');
        $recentBookings = Booking::with(['salonService', 'payment'])->latest()->take(5)->get();
        $pendingBookings = Booking::where('booking_status', 'pending')->count();

        return view('dashboard', compact(
            'totalServices',
            'totalBookings',
            'totalPaidPayments',
            'totalRevenue',
            'recentBookings',
            'pendingBookings'
        ));
    }
}
