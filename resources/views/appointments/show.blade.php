@extends('layouts.app')

@section('page-title', 'Appointment Details')
@section('page-subtitle', 'Booking #{{ $appointment->id }}')

@section('header-action')
    <div style="display:flex;gap:8px">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back
        </a>
    </div>
@endsection

@section('content')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:860px">

        {{-- Customer Info --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:18px">
                <div>
                    <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Full Name</div>
                    <div style="font-size:0.9rem;font-weight:500">{{ $appointment->customer_name }}</div>
                </div>
                <div>
                    <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Contact</div>
                    <div style="font-size:0.88rem">{{ $appointment->customer_contact }}</div>
                </div>
                <div>
                    <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Email</div>
                    <div style="font-size:0.88rem">{{ $appointment->customer_email ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Booking Info --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Booking</h3>
                <span class="badge badge-{{ $appointment->booking_status }}">{{ $appointment->booking_status }}</span>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:18px">
                <div>
                    <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Service</div>
                    <div style="font-size:0.9rem;font-weight:500">{{ $appointment->salonService->service_name ?? '—' }}</div>
                    <div style="font-size:0.78rem;color:var(--gray-500);margin-top:2px">{{ $appointment->salonService->service_duration ?? '' }}</div>
                </div>
                <div>
                    <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Schedule</div>
                    <div style="font-size:0.88rem">{{ \Carbon\Carbon::parse($appointment->booking_date)->format('F d, Y') }}</div>
                    <div style="font-size:0.78rem;color:var(--gray-500);margin-top:2px">{{ \Carbon\Carbon::parse($appointment->booking_time)->format('h:i A') }}</div>
                </div>
                <div>
                    <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Total Price</div>
                    <div style="font-size:1.1rem;font-weight:600;font-family:'Geist Mono',monospace">₱{{ number_format($appointment->total_price, 2) }}</div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if($appointment->booking_notes)
            <div class="card">
                <div class="card-header"><h3 class="card-title">Notes</h3></div>
                <div class="card-body">
                    <p style="font-size:0.86rem;color:var(--gray-700);line-height:1.6">{{ $appointment->booking_notes }}</p>
                </div>
            </div>
        @endif

        {{-- Payment --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment</h3>
                @if($appointment->payment && $appointment->payment->payment_status === 'unpaid')
                    <form method="POST" action="{{ route('payments.process', $appointment) }}">
                        @csrf
                        <input type="hidden" name="payment_method" value="cash">
                        <button type="submit" class="btn btn-primary btn-sm">Mark as Paid</button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                @if($appointment->payment)
                    <div style="display:flex;flex-direction:column;gap:16px">
                        <div>
                            <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Status</div>
                            <span class="badge badge-{{ $appointment->payment->payment_status }}">{{ $appointment->payment->payment_status }}</span>
                        </div>
                        <div>
                            <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Method</div>
                            <div style="font-size:0.88rem">{{ ucfirst($appointment->payment->payment_method) }}</div>
                        </div>
                        @if($appointment->payment->payment_date)
                            <div>
                                <div style="font-size:0.68rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Paid On</div>
                                <div style="font-size:0.88rem">{{ \Carbon\Carbon::parse($appointment->payment->payment_date)->format('M d, Y h:i A') }}</div>
                            </div>
                        @endif
                    </div>
                @else
                    <p style="font-size:0.86rem;color:var(--gray-500)">No payment record found.</p>
                @endif
            </div>
        </div>

    </div>
@endsection