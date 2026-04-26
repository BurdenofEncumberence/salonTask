@extends('layouts.app')

@section('page-title', 'New Appointment')
@section('page-subtitle', 'Book a new customer appointment')

@section('header-action')
    <a href="{{ route('appointments.index') }}" class="btn btn-outline">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back
    </a>
@endsection

@section('content')
    <div style="max-width:680px">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            {{-- Customer Information --}}
            <div class="form-section-label">Customer Information</div>
            <div class="form-section">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="customer_name">Full Name</label>
                        <input type="text" id="customer_name" name="customer_name" class="form-control"
                            value="{{ old('customer_name') }}" placeholder="Customer full name" required>
                        @error('customer_name')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="customer_contact">Contact Number</label>
                        <input type="text" id="customer_contact" name="customer_contact" class="form-control"
                            value="{{ old('customer_contact') }}" placeholder="09XX XXX XXXX" required>
                        @error('customer_contact')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="customer_email">Email Address <span style="color:var(--gray-400);font-weight:400">(optional)</span></label>
                    <input type="email" id="customer_email" name="customer_email" class="form-control"
                        value="{{ old('customer_email') }}" placeholder="customer@email.com">
                    @error('customer_email')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Appointment Details --}}
            <div class="form-section-label">Appointment Details</div>
            <div class="form-section">
                <div class="form-group">
                    <label class="form-label" for="service_id">Service</label>
                    <select id="service_id" name="service_id" class="form-control" required onchange="updatePrice(this)">
                        <option value="">— Choose a service —</option>
                        @foreach($serviceList as $singleService)
                            <option value="{{ $singleService->id }}"
                                data-price="{{ $singleService->service_price }}"
                                {{ old('service_id') == $singleService->id ? 'selected' : '' }}>
                                {{ $singleService->service_name }} — ₱{{ number_format($singleService->service_price, 2) }} ({{ $singleService->service_duration }})
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div id="price-preview" style="display:none;padding:10px 14px;background:var(--gray-100);border:1px solid var(--border);border-radius:6px;margin-bottom:16px;font-size:0.82rem;color:var(--gray-700);font-family:'Geist Mono',monospace">
                    Price: <strong id="price-value"></strong>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="booking_date">Date</label>
                        <input type="date" id="booking_date" name="booking_date" class="form-control"
                            value="{{ old('booking_date') }}" min="{{ date('Y-m-d') }}" required>
                        @error('booking_date')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="booking_time">Time</label>
                        <input type="time" id="booking_time" name="booking_time" class="form-control"
                            value="{{ old('booking_time') }}" required>
                        @error('booking_time')<p class="form-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label" for="booking_notes">Notes <span style="color:var(--gray-400);font-weight:400">(optional)</span></label>
                    <textarea id="booking_notes" name="booking_notes" class="form-control"
                        placeholder="Special requests or notes...">{{ old('booking_notes') }}</textarea>
                    @error('booking_notes')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary">Book Appointment</button>
                <a href="{{ route('appointments.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function updatePrice(selectEl) {
            var selectedOption = selectEl.options[selectEl.selectedIndex];
            var pricePreview = document.getElementById('price-preview');
            var priceValue = document.getElementById('price-value');
            if (selectedOption.value) {
                var rawPrice = parseFloat(selectedOption.getAttribute('data-price'));
                priceValue.textContent = '₱' + rawPrice.toFixed(2);
                pricePreview.style.display = 'block';
            } else {
                pricePreview.style.display = 'none';
            }
        }
    </script>
@endsection