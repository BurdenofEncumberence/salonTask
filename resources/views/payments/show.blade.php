@extends('layouts.app')

@section('page-title', 'Payment Record')
@section('page-subtitle', 'Payment #{{ $payment->id }} details')

@section('header-action')
    <div style="display:flex;gap:10px">
        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-outline">Edit</a>
        <a href="{{ route('payments.index') }}" class="btn btn-outline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back
        </a>
    </div>
@endsection

@section('content')
    <div class="card" style="max-width:560px">
        <div class="card-header">
            <h3 class="card-title">Receipt #{{ $payment->id }}</h3>
            <span class="badge badge-{{ $payment->payment_status }}">{{ $payment->payment_status }}</span>
        </div>
        <div class="card-body">
            <div style="border-bottom:1px solid rgba(43,26,20,0.07);padding-bottom:20px;margin-bottom:20px">
                <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Customer</div>
                <div style="font-weight:500;font-size:1.05rem">{{ $payment->booking->customer_name ?? '—' }}</div>
                <div style="font-size:0.85rem;color:var(--muted)">{{ $payment->booking->customer_contact ?? '' }}</div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;border-bottom:1px solid rgba(43,26,20,0.07);padding-bottom:20px">
                <div>
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Service</div>
                    <div>{{ $payment->booking->salonService->service_name ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Method</div>
                    <div>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Booking Date</div>
                    <div>{{ $payment->booking ? \Carbon\Carbon::parse($payment->booking->booking_date)->format('M d, Y') : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Paid On</div>
                    <div>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') : '—' }}</div>
                </div>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between">
                <div style="font-size:0.9rem;color:var(--muted)">Total Amount</div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;color:var(--rose)">₱{{ number_format($payment->amount_paid, 2) }}</div>
            </div>

            @if($payment->payment_notes)
                <div style="margin-top:20px;padding:14px;background:var(--cream);border-radius:8px;font-size:0.85rem;color:var(--muted)">
                    <strong style="color:var(--ink);display:block;margin-bottom:4px">Notes</strong>
                    {{ $payment->payment_notes }}
                </div>
            @endif
        </div>
    </div>
@endsection
