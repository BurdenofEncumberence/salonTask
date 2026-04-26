@extends('layouts.app')

@section('page-title', 'Edit Payment')
@section('page-subtitle', 'Update payment record #{{ $payment->id }}')

@section('header-action')
    <a href="{{ route('payments.index') }}" class="btn btn-outline">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Payments
    </a>
@endsection

@section('content')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:900px">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Booking Summary</h3></div>
            <div class="card-body">
                <div style="margin-bottom:14px">
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Customer</div>
                    <div style="font-weight:500">{{ $payment->booking->customer_name ?? '—' }}</div>
                    <div style="font-size:0.82rem;color:var(--muted)">{{ $payment->booking->customer_contact ?? '' }}</div>
                </div>
                <div style="margin-bottom:14px">
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Service</div>
                    <div>{{ $payment->booking->salonService->service_name ?? '—' }}</div>
                </div>
                <div style="margin-bottom:14px">
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Schedule</div>
                    <div>{{ $payment->booking ? \Carbon\Carbon::parse($payment->booking->booking_date)->format('M d, Y') : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px">Amount Due</div>
                    <div style="font-size:1.4rem;font-family:'Cormorant Garamond',serif;color:var(--rose)">₱{{ number_format($payment->amount_paid, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Payment Details</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('payments.update', $payment) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="payment_status">Payment Status</label>
                        <select id="payment_status" name="payment_status" class="form-control" required>
                            <option value="unpaid" {{ old('payment_status', $payment->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ old('payment_status', $payment->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="payment_method">Payment Method</label>
                        <select id="payment_method" name="payment_method" class="form-control" required>
                            <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="gcash" {{ old('payment_method', $payment->payment_method) == 'gcash' ? 'selected' : '' }}>GCash</option>
                            <option value="card" {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                            <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                        @error('payment_method')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="payment_notes">Notes (Optional)</label>
                        <textarea id="payment_notes" name="payment_notes" class="form-control" style="min-height:80px">{{ old('payment_notes', $payment->payment_notes) }}</textarea>
                        @error('payment_notes')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%">Update Payment</button>
                </form>
            </div>
        </div>
    </div>
@endsection
