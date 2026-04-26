@extends('layouts.app')

@section('page-title', 'Salon Services')
@section('page-subtitle', 'Manage all available nail and salon services')

@section('header-action')
    <a href="{{ route('services.create') }}" class="btn btn-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Service
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="table-wrap">
            @if($allServices->isEmpty())
                <div class="empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <p>No services found. Add your first service!</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allServices as $eachService)
                            <tr>
                                <td style="color:var(--muted);font-size:0.8rem">{{ $loop->iteration }}</td>
                                <td><strong>{{ $eachService->service_name }}</strong></td>
                                <td>₱{{ number_format($eachService->service_price, 2) }}</td>
                                <td>{{ $eachService->service_duration }}</td>
                                <td style="max-width:200px;color:var(--muted);font-size:0.85rem">
                                    {{ Str::limit($eachService->service_description, 60) ?? '—' }}
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ route('services.edit', $eachService) }}" class="btn btn-outline btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('services.destroy', $eachService) }}" onsubmit="return confirm('Delete this service?')">
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
                <div style="padding:16px 18px">
                    {{ $allServices->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
