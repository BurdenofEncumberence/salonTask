@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your salon business')

@section('header-action')
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Appointment
    </a>
@endsection

@section('content')
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9826a" stroke-width="1.8"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <div class="stat-value">{{ $totalServices }}</div>
            <div class="stat-label">Total Services</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9826a" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-label">Total Bookings</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9826a" stroke-width="1.8"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div class="stat-value">{{ $pendingBookings }}</div>
            <div class="stat-label">Pending Appointments</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c9826a" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="stat-value">₱{{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Appointments</h3>
            <a href="{{ route('appointments.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            @if($recentBookings->isEmpty())
                <div class="empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <p>No appointments yet.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $singleBooking)
                            <tr>
                                <td>
                                    <strong>{{ $singleBooking->customer_name }}</strong><br>
                                    <small style="color:var(--muted)">{{ $singleBooking->customer_contact }}</small>
                                </td>
                                <td>{{ $singleBooking->salonService->service_name ?? '—' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($singleBooking->booking_date)->format('M d, Y') }}<br>
                                    <small style="color:var(--muted)">{{ \Carbon\Carbon::parse($singleBooking->booking_time)->format('h:i A') }}</small>
                                </td>
                                <td>₱{{ number_format($singleBooking->total_price, 2) }}</td>
                                <td><span class="badge badge-{{ $singleBooking->booking_status }}">{{ $singleBooking->booking_status }}</span></td>
                                <td>
                                    @if($singleBooking->payment)
                                        <span class="badge badge-{{ $singleBooking->payment->payment_status }}">{{ $singleBooking->payment->payment_status }}</span>
                                    @else
                                        <span class="badge badge-unpaid">unpaid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
