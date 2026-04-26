<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $allPayments = Payment::with('booking.salonService')->latest()->paginate(10);
        return view('payments.index', compact('allPayments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('booking.salonService');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $payment->load('booking.salonService');
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $req, Payment $payment)
    {
        $validatedData = $req->validate([
            'payment_method' => 'required|in:cash,gcash,card,bank_transfer',
            'payment_status' => 'required|in:paid,unpaid',
            'payment_notes' => 'nullable|string',
        ]);

        if ($req->payment_status === 'paid') {
            $validatedData['payment_date'] = now();
        } else {
            $validatedData['payment_date'] = null;
        }

        $payment->update($validatedData);

        if ($req->payment_status === 'paid') {
            $payment->booking->update(['booking_status' => 'completed']);
        }

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully!');
    }

    public function processPayment(Request $req, Booking $booking)
    {
        $existingPayment = $booking->payment;

        if ($existingPayment) {
            $existingPayment->update([
                'payment_status' => 'paid',
                'payment_method' => $req->payment_method ?? 'cash',
                'payment_date' => now(),
            ]);
        } else {
            Payment::create([
                'booking_id' => $booking->id,
                'amount_paid' => $booking->total_price,
                'payment_method' => $req->payment_method ?? 'cash',
                'payment_status' => 'paid',
                'payment_date' => now(),
            ]);
        }

        $booking->update(['booking_status' => 'completed']);

        return redirect()->route('payments.index')->with('success', 'Payment processed successfully!');
    }
}
