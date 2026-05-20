@extends('layouts.app')

@section('title', 'Find Doctors & Book Appointment - Availability System')

@section('content')
<style>
    /* Premium aesthetics for Doctor Booking Dashboard */
    .dashboard-container {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hero Banner with Sleek Dark Gradient */
    .hero-banner {
        background: linear-gradient(135deg, #111111 0%, #1f2937 100%);
        border-radius: 16px;
        padding: 40px;
        color: #ffffff;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-banner h1 {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.75px;
        margin-bottom: 8px;
        line-height: 1.2;
    }

    .hero-banner p {
        color: #9ca3af;
        font-size: 1rem;
        max-width: 600px;
    }

    /* Modern Glassmorphic Search Card */
    .search-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 32px;
    }

    .search-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: flex-end;
    }

    .search-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #4b5563;
        margin-bottom: 8px;
        display: block;
    }

    .search-input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background-color: #f9fafb;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #ffffff;
    }

    .btn-search {
        background: #111111;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        height: 48px;
        width: 100%;
    }

    .btn-search:hover {
        background: #1f2937;
    }

    .btn-search:active {
        transform: scale(0.98);
    }

    .btn-clear {
        background: #f3f4f6;
        color: #4b5563;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        transition: background 0.2s;
        height: 48px;
        width: 100%;
    }

    .btn-clear:hover {
        background: #e5e7eb;
    }

    /* Doctor Cards Grid */
    .doctors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
        margin-top: 16px;
    }

    .doctor-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
    }

    .doctor-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
        border-color: #d1d5db;
    }

    .doctor-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .doctor-info h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111111;
        margin-bottom: 4px;
    }

    /* Custom color scheme for specialties */
    .specialty-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .spec-cardiology { background-color: #fee2e2; color: #ef4444; }
    .spec-orthopedics { background-color: #ffedd5; color: #f97316; }
    .spec-dermatology { background-color: #f3e8ff; color: #a855f7; }
    .spec-neurology { background-color: #e0e7ff; color: #4f46e5; }
    .spec-pediatrics { background-color: #dcfce7; color: #22c55e; }
    .spec-general-medicine { background-color: #e0f2fe; color: #0284c7; }
    .spec-default { background-color: #f3f4f6; color: #4b5563; }

    .doctor-details {
        margin-top: 14px;
        font-size: 0.85rem;
        color: #4b5563;
        display: grid;
        gap: 8px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-row svg {
        color: #9ca3af;
        flex-shrink: 0;
    }

    /* Capacity and Booking Progress Indicator */
    .capacity-section {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px dashed #e5e7eb;
    }

    .capacity-label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .progress-bar-container {
        width: 100%;
        height: 6px;
        background-color: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 9999px;
        transition: width 0.4s ease;
    }

    .progress-available { background-color: #10b981; }
    .progress-warning { background-color: #f59e0b; }
    .progress-full { background-color: #ef4444; }

    .slots-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .pill-available { background-color: #ecfdf5; color: #059669; }
    .pill-warning { background-color: #fffbeb; color: #d97706; }
    .pill-full { background-color: #fef2f2; color: #dc2626; }

    /* Action Buttons in Doctor Card */
    .doctor-action {
        margin-top: 20px;
    }

    .btn-book {
        width: 100%;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-book-active {
        background-color: #111111;
        color: #ffffff;
    }

    .btn-book-active:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }

    .btn-book-disabled {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Elegant Booking Modal */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(17, 24, 39, 0.6);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .modal-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }

    .booking-modal {
        background: #ffffff;
        border-radius: 20px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 1px solid #e5e7eb;
    }

    .modal-backdrop.active .booking-modal {
        transform: scale(1);
    }

    .modal-header {
        background: linear-gradient(135deg, #111111 0%, #1f2937 100%);
        padding: 24px;
        color: #ffffff;
        position: relative;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .modal-subtitle {
        font-size: 0.85rem;
        color: #d1d5db;
    }

    .modal-close {
        position: absolute;
        top: 24px;
        right: 24px;
        background: none;
        border: none;
        color: #ffffff;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .modal-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-info-box {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
        font-size: 0.875rem;
    }

    .info-box-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .info-box-row:last-child {
        margin-bottom: 0;
    }

    .info-box-label {
        font-weight: 600;
        color: #4b5563;
    }

    .info-box-value {
        font-weight: 700;
        color: #111111;
    }

    .modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 24px;
    }

    /* Empty Search State Styling */
    .search-empty-state {
        text-align: center;
        padding: 64px 24px;
        background: #ffffff;
        border: 1px dashed #d1d5db;
        border-radius: 16px;
        color: #4b5563;
        margin-top: 16px;
    }

    .search-empty-state svg {
        color: #9ca3af;
        margin-bottom: 16px;
    }
</style>

<div class="dashboard-container">
    {{-- Hero Section --}}
    <div class="hero-banner">
        <h1>Find Available Doctors</h1>
        <p>Select a medical specialization, choose an Indian state and city, and book your instantly-allocated appointment slot today.</p>
    </div>

    {{-- Glassmorphic Search Form --}}
    <div class="search-card">
        <form action="{{ route('nmc.search') }}" method="GET" id="search-form">
            <input type="hidden" name="search" value="1">
            <div class="search-grid">
                {{-- Specialty --}}
                <div>
                    <label for="specialization" class="search-label">Specialist Required</label>
                    <select name="specialization" id="specialization" class="search-input">
                        <option value="">All Specialties</option>
                        @foreach($specializations as $spec)
                            <option value="{{ $spec }}" {{ $specialization == $spec ? 'selected' : '' }}>
                                {{ $spec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- State --}}
                <div>
                    <label for="state" class="search-label">State</label>
                    <select name="state" id="state" class="search-input">
                        <option value="">Select State</option>
                        @foreach(array_keys($statesAndCities) as $st)
                            <option value="{{ $st }}" {{ $state == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- City --}}
                <div>
                    <label for="city" class="search-label">City</label>
                    <select name="city" id="city" class="search-input">
                        <option value="">All Cities</option>
                    </select>
                </div>

                {{-- Date Selector --}}
                <div>
                    <label for="date" class="search-label">Appointment Date</label>
                    <input type="date" name="date" id="date" class="search-input" 
                           value="{{ $date }}" min="{{ \Carbon\Carbon::today()->toDateString() }}">
                </div>

                {{-- Buttons --}}
                <div style="display:flex;gap:10px;">
                    <button type="submit" class="btn-search">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Search
                    </button>
                    @if($searching)
                        <a href="{{ route('nmc.search') }}" class="btn-clear" title="Clear search filters">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Doctors List / Grid --}}
    @if($searching)
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:16px;">
            <div>
                <h2 style="font-size:1.25rem; font-weight:800; color:#111111; margin:0;">
                    Available Doctors on {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                </h2>
                <p style="color:#6b7280; font-size:0.85rem; margin-top:2px; font-weight:500;">
                    Found {{ $doctors->total() }} matching doctor(s)
                </p>
            </div>
            
            {{-- Sleek Sorting Dropdown Form --}}
            <form id="sortForm" action="{{ route('nmc.search') }}" method="GET" style="display:flex; align-items:center; gap:8px;">
                {{-- Keep existing search query params hidden --}}
                <input type="hidden" name="specialization" value="{{ $specialization }}">
                <input type="hidden" name="state" value="{{ $state }}">
                <input type="hidden" name="city" value="{{ $city }}">
                <input type="hidden" name="date" value="{{ $date }}">
                <input type="hidden" name="search" value="1">
                
                <span style="font-size:0.8rem; font-weight:700; color:#4b5563; text-transform:uppercase; letter-spacing:0.5px;">Sort by:</span>
                
                <select name="sort_by" onchange="document.getElementById('sortForm').submit()" style="padding:6px 12px; border-radius:8px; border:1px solid #d1d5db; font-size:0.85rem; font-weight:600; cursor:pointer; outline:none; background-color:#ffffff;">
                    <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Doctor Name</option>
                    <option value="specialization" {{ $sortBy === 'specialization' ? 'selected' : '' }}>Specialization</option>
                    <option value="city" {{ $sortBy === 'city' ? 'selected' : '' }}>City</option>
                    <option value="daily_limit" {{ $sortBy === 'daily_limit' ? 'selected' : '' }}>Limit</option>
                    <option value="start_time" {{ $sortBy === 'start_time' ? 'selected' : '' }}>Start Time</option>
                </select>

                <select name="sort_order" onchange="document.getElementById('sortForm').submit()" style="padding:6px 12px; border-radius:8px; border:1px solid #d1d5db; font-size:0.85rem; font-weight:600; cursor:pointer; outline:none; background-color:#ffffff;">
                    <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </form>
        </div>

        @if(count($doctors) > 0)
            <div class="doctors-grid">
                @foreach($doctors as $doc)
                    @php
                        $percentageBooked = ($doc->booked_count / $doc->daily_limit) * 100;
                        $pillClass = 'pill-available';
                        $progressBarClass = 'progress-available';
                        
                        if ($doc->slots_remaining == 0) {
                            $pillClass = 'pill-full';
                            $progressBarClass = 'progress-full';
                        } elseif ($doc->slots_remaining <= 3) {
                            $pillClass = 'pill-warning';
                            $progressBarClass = 'progress-warning';
                        }
                        
                        // Map class to specialty
                        $normalizedSpec = strtolower(str_replace(' ', '-', $doc->specialization));
                        $specClasses = ['cardiology', 'orthopedics', 'dermatology', 'neurology', 'pediatrics', 'general-medicine'];
                        $specClass = in_array($normalizedSpec, $specClasses) ? 'spec-' . $normalizedSpec : 'spec-default';
                    @endphp

                    <div class="doctor-card">
                        <div>
                            {{-- Header --}}
                            <div class="doctor-header">
                                <div class="doctor-info">
                                    <h3>{{ $doc->name }}</h3>
                                    <span class="specialty-badge {{ $specClass }}">{{ $doc->specialization }}</span>
                                </div>
                                <span class="slots-pill {{ $pillClass }}">
                                    @if($doc->slots_remaining == 0)
                                        Fully Booked
                                    @else
                                        {{ $doc->slots_remaining }} slots left
                                    @endif
                                </span>
                            </div>

                            {{-- Details --}}
                            <div class="doctor-details">
                                <div class="detail-row">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span>Timings: <strong>{{ $doc->formatted_timings }}</strong></span>
                                </div>
                                <div class="detail-row">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span>Location: <strong>{{ $doc->city }}, {{ $doc->state }}</strong></span>
                                </div>
                                @if($doc->address)
                                    <div class="detail-row" style="align-items: flex-start; margin-top: 4px;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-top:2px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                        <span style="font-size:0.8rem;color:#6b7280;line-height:1.4;">{{ $doc->address }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Progress & Booking Action --}}
                        <div class="capacity-section">
                            <div class="capacity-label-row">
                                <span style="color:#6b7280;">Daily slots capacity:</span>
                                <span style="color:#111111;">{{ $doc->booked_count }} / {{ $doc->daily_limit }} booked</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill {{ $progressBarClass }}" style="width: {{ $percentageBooked }}%;"></div>
                            </div>

                            <div class="doctor-action">
                                @if($doc->slots_remaining > 0)
                                    <button class="btn-book btn-book-active" 
                                            onclick="openBookingModal('{{ $doc->id }}', '{{ addslashes($doc->name) }}', '{{ $doc->specialization }}', '{{ $doc->formatted_timings }}')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                                        Book Slot
                                    </button>
                                @else
                                    <button class="btn-book btn-book-disabled" disabled>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                        Fully Booked
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper" style="margin-top:24px; display:flex; justify-content:center;">
                {{ $doctors->links() }}
            </div>
        @else
            <div class="search-empty-state">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:8px;color:#111111;">No Available Doctors Found</h3>
                <p style="font-size:0.875rem;max-width:400px;margin:0 auto;color:#6b7280;">No doctors match the selected specialization and location on this date. Try expanding your search filters or changing the date.</p>
            </div>
        @endif
    @else
        {{-- Intro State --}}
        <div class="search-empty-state" style="border-style: solid; padding: 48px; background-color: #fafafa;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #2563eb;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            <h3 style="font-size:1.25rem;font-weight:700;margin-bottom:8px;color:#111111;">Search the Doctor Directory</h3>
            <p style="font-size:0.9rem;max-width:500px;margin:0 auto;color:#6b7280;line-height:1.5;">Choose a specialization and location to explore local doctor availability. The system dynamically tracks daily limits and auto-calculates timing slots for a zero-wait patient experience.</p>
        </div>
    @endif
</div>

{{-- Elegant Backdrop-Blurred Booking Modal --}}
<div class="modal-backdrop" id="booking-modal-backdrop" onclick="closeBookingModal(event)">
    <div class="booking-modal" onclick="event.stopPropagation()">
        {{-- Modal Header --}}
        <div class="modal-header">
            <h2 class="modal-title">Confirm Appointment</h2>
            <p class="modal-subtitle">Secure your slot instantly below</p>
            <button class="modal-close" onclick="closeBookingModal()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body">
            <form action="{{ route('appointments.store') }}" method="POST" id="appointment-form">
                @csrf
                <input type="hidden" name="doctor_id" id="modal-doctor-id">
                <input type="hidden" name="appointment_date" value="{{ $date }}">
                <input type="hidden" name="status" value="Scheduled">
                <input type="hidden" name="from_search" value="1">

                {{-- Display summary --}}
                <div class="modal-info-box">
                    <div class="info-box-row">
                        <span class="info-box-label">Doctor Name:</span>
                        <span class="info-box-value" id="modal-doc-name"></span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-box-label">Specialization:</span>
                        <span class="info-box-value" id="modal-doc-spec"></span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-box-label">Date:</span>
                        <span class="info-box-value">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</span>
                    </div>
                    <div class="info-box-row">
                        <span class="info-box-label">Available Hours:</span>
                        <span class="info-box-value" id="modal-doc-timings"></span>
                    </div>
                </div>

                {{-- Patient Dropdown --}}
                <div class="form-group">
                    <label for="patient_id" style="font-size:0.75rem;font-weight:700;color:#4b5563;text-transform:uppercase;margin-bottom:6px;display:block;">Select Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control" required style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:10px;">
                        <option value="">-- Choose Patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->phone }})</option>
                        @endforeach
                    </select>
                    <div style="margin-top:6px;text-align:right;">
                        <a href="{{ route('patients.create') }}" target="_blank" style="font-size:0.75rem;color:#2563eb;font-weight:600;display:inline-flex;align-items:center;gap:4px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Add New Patient
                        </a>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="form-group" style="margin-top:14px;">
                    <label for="notes" style="font-size:0.75rem;font-weight:700;color:#4b5563;text-transform:uppercase;margin-bottom:6px;display:block;">Symptoms / Notes</label>
                    <textarea name="notes" id="notes" class="form-control" placeholder="e.g. Mild headache, follow-up consult, regular checkup..." style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:10px;resize:vertical;min-height:80px;"></textarea>
                </div>

                {{-- Timing auto-allocation notification --}}
                <div style="background-color:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;padding:12px;border-radius:8px;font-size:0.8rem;margin-top:16px;display:flex;gap:8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span><strong>Auto Slot Allocation:</strong> Your exact appointment time will be auto-calculated starting at the next available slot within the doctor's hours.</span>
                </div>

                {{-- Actions --}}
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeBookingModal()" style="height:46px;border-radius:10px;font-weight:600;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="height:46px;border-radius:10px;font-weight:600;background-color:#111111;">Book Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // State to City dynamic mapping
    const statesAndCities = @json($statesAndCities);
    const selectedState = "{{ $state }}";
    const selectedCity = "{{ $city }}";

    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    function populateCities(state, currentCity = '') {
        citySelect.innerHTML = '<option value="">All Cities</option>';
        if (state && statesAndCities[state]) {
            statesAndCities[state].forEach(city => {
                const opt = document.createElement('option');
                opt.value = city;
                opt.textContent = city;
                if (city === currentCity) {
                    opt.selected = true;
                }
                citySelect.appendChild(opt);
            });
        }
    }

    stateSelect.addEventListener('change', function() {
        populateCities(this.value);
    });

    // Initialize dropdown on load
    if (selectedState) {
        populateCities(selectedState, selectedCity);
    }

    // Modal Operations
    const modalBackdrop = document.getElementById('booking-modal-backdrop');
    
    function openBookingModal(doctorId, name, specialization, timings) {
        document.getElementById('modal-doctor-id').value = doctorId;
        document.getElementById('modal-doc-name').textContent = name;
        document.getElementById('modal-doc-spec').textContent = specialization;
        document.getElementById('modal-doc-timings').textContent = timings;
        
        modalBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden'; // Disable scroll under modal
    }

    function closeBookingModal(event = null) {
        if (event && event.target !== modalBackdrop) return;
        modalBackdrop.classList.remove('active');
        document.body.style.overflow = ''; // Restore scroll
    }

    // Press Escape key to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeBookingModal();
        }
    });
</script>
@endsection
