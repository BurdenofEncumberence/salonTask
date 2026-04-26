@extends('layouts.app')

@section('page-title', 'Appointments')
@section('page-subtitle', 'All customer bookings and appointments')

@section('header-action')
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Appointment
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="table-wrap">
            @if($allBookings->isEmpty())
                <div class="empty-state">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <p>No appointments yet. Create the first booking!</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Schedule</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allBookings as $eachBooking)
                            <tr>
                                <td style="color:var(--gray-500);font-size:0.75rem;font-family:'Geist Mono',monospace">{{ $eachBooking->id }}</td>
                                <td>
                                    <div style="font-weight:500;font-size:0.85rem">{{ $eachBooking->customer_name }}</div>
                                    <div style="font-size:0.75rem;color:var(--gray-500);margin-top:1px">{{ $eachBooking->customer_contact }}</div>
                                </td>
                                <td style="font-size:0.84rem">{{ $eachBooking->salonService->service_name ?? '—' }}</td>
                                <td>
                                    <div style="font-size:0.84rem">{{ \Carbon\Carbon::parse($eachBooking->booking_date)->format('M d, Y') }}</div>
                                    <div style="font-size:0.75rem;color:var(--gray-500);margin-top:1px">{{ \Carbon\Carbon::parse($eachBooking->booking_time)->format('h:i A') }}</div>
                                </td>
                                <td style="font-family:'Geist Mono',monospace;font-size:0.84rem">₱{{ number_format($eachBooking->total_price, 2) }}</td>
                                <td><span class="badge badge-{{ $eachBooking->booking_status }}">{{ $eachBooking->booking_status }}</span></td>
                                <td>
                                    @if($eachBooking->payment)
                                        <span class="badge badge-{{ $eachBooking->payment->payment_status }}">{{ $eachBooking->payment->payment_status }}</span>
                                    @else
                                        <span class="badge badge-unpaid">unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('appointments.show', $eachBooking) }}" class="btn btn-outline btn-sm">View</a>
                                        <a href="{{ route('appointments.edit', $eachBooking) }}" class="btn btn-outline btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('appointments.destroy', $eachBooking) }}" onsubmit="return confirm('Delete this appointment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding:14px 16px;border-top:1px solid var(--border)">
                    {{ $allBookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection