@extends('layouts.app')

@section('page-title', 'Payments')
@section('page-subtitle', 'Payment history and transaction records')

@section('content')
    <div class="card">
        <div class="table-wrap">
            @if($allPayments->isEmpty())
                <div class="empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    <p>No payment records found.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allPayments as $eachPayment)
                            <tr>
                                <td style="color:var(--muted);font-size:0.8rem">{{ $eachPayment->id }}</td>
                                <td>
                                    <strong>{{ $eachPayment->booking->customer_name ?? '—' }}</strong><br>
                                    <small style="color:var(--muted)">{{ $eachPayment->booking->customer_contact ?? '' }}</small>
                                </td>
                                <td>{{ $eachPayment->booking->salonService->service_name ?? '—' }}</td>
                                <td style="font-family:'Cormorant Garamond',serif;font-size:1.05rem;color:var(--rose)">
                                    ₱{{ number_format($eachPayment->amount_paid, 2) }}
                                </td>
                                <td>{{ ucfirst(str_replace('_', ' ', $eachPayment->payment_method)) }}</td>
                                <td><span class="badge badge-{{ $eachPayment->payment_status }}">{{ $eachPayment->payment_status }}</span></td>
                                <td>
                                    @if($eachPayment->payment_date)
                                        {{ \Carbon\Carbon::parse($eachPayment->payment_date)->format('M d, Y') }}<br>
                                        <small style="color:var(--muted)">{{ \Carbon\Carbon::parse($eachPayment->payment_date)->format('h:i A') }}</small>
                                    @else
                                        <span style="color:var(--muted)">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        @if($eachPayment->payment_status === 'unpaid')
                                            <form method="POST" action="{{ route('payments.process', $eachPayment->booking) }}">
                                                @csrf
                                                <input type="hidden" name="payment_method" value="cash">
                                                <button type="submit" class="btn btn-success btn-sm">Mark Paid</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('payments.edit', $eachPayment) }}" class="btn btn-outline btn-sm">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="padding:16px 18px">
                    {{ $allPayments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
