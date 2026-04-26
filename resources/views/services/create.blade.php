@extends('layouts.app')

@section('page-title', 'Add New Service')
@section('page-subtitle', 'Create a new salon or nail service')

@section('header-action')
    <a href="{{ route('services.index') }}" class="btn btn-outline">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Services
    </a>
@endsection

@section('content')
    <div class="card" style="max-width:680px">
        <div class="card-header">
            <h3 class="card-title">Service Details</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('services.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="service_name">Service Name</label>
                    <input type="text" id="service_name" name="service_name" class="form-control" value="{{ old('service_name') }}" placeholder="e.g. Manicure, Pedicure, Gel Polish" required>
                    @error('service_name')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="service_price">Price (₱)</label>
                        <input type="number" id="service_price" name="service_price" class="form-control" value="{{ old('service_price') }}" placeholder="0.00" step="0.01" min="0" required>
                        @error('service_price')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="service_duration">Duration</label>
                        <input type="text" id="service_duration" name="service_duration" class="form-control" value="{{ old('service_duration') }}" placeholder="e.g. 30 mins, 1 hour" required>
                        @error('service_duration')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="service_description">Description (Optional)</label>
                    <textarea id="service_description" name="service_description" class="form-control" placeholder="Brief description of the service...">{{ old('service_description') }}</textarea>
                    @error('service_description')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">Save Service</button>
                    <a href="{{ route('services.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
