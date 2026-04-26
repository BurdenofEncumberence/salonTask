<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SalonService;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $allBookings = Booking::with(['salonService', 'payment'])->latest()->paginate(10);
        return view('appointments.index', compact('allBookings'));
    }

    public function create()
    {
        $serviceList = SalonService::all();
        return view('appointments.create', compact('serviceList'));
    }

    public function store(Request $req)
    {
        $validatedData = $req->validate([
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'service_id' => 'required|exists:salon_services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'booking_notes' => 'nullable|string',
        ]);

        $chosenService = SalonService::findOrFail($req->service_id);
        $validatedData['total_price'] = $chosenService->service_price;
        $validatedData['booking_status'] = 'pending';

        $newBooking = Booking::create($validatedData);

        Payment::create([
            'booking_id' => $newBooking->id,
            'amount_paid' => $chosenService->service_price,
            'payment_method' => 'cash',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }

    public function show(Booking $appointment)
    {
        $appointment->load(['salonService', 'payment']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Booking $appointment)
    {
        $serviceList = SalonService::all();
        return view('appointments.edit', compact('appointment', 'serviceList'));
    }

    public function update(Request $req, Booking $appointment)
    {
        $validatedData = $req->validate([
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'service_id' => 'required|exists:salon_services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
            'booking_status' => 'required|in:pending,confirmed,completed,cancelled',
            'booking_notes' => 'nullable|string',
        ]);

        $chosenService = SalonService::findOrFail($req->service_id);
        $validatedData['total_price'] = $chosenService->service_price;

        $appointment->update($validatedData);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully!');
    }

    public function destroy(Booking $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully!');
    }
}
