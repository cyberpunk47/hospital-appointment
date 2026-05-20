@extends('layouts.app')

@section('title', 'Edit Doctor - Hospital Appointment Management')

@section('content')
<style>
    .edit-container {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-card-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        margin-top: 20px;
    }

    .section-title {
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #2563eb;
        letter-spacing: 1px;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #4b5563;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        transition: all 0.2s;
        background-color: #f9fafb;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #ffffff;
    }

    .btn-save {
        background: linear-gradient(to right, #111111, #1f2937);
        color: #ffffff;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }
</style>

<div class="edit-container">
    <div class="page-header">
        <div>
            <h1>Edit Doctor Profile</h1>
            <p style="color:#6b7280; font-size:0.9rem; margin-top:4px;">Modify details, location filters, shift timetables, and capacity settings for <strong>{{ $doctor->name }}</strong>.</p>
        </div>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary" style="height:40px; border-radius:10px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Directory
        </a>
    </div>

    @if ($errors->any())
        <div style="background-color:#fef2f2; color:#b91c1c; border: 1px solid #fca5a5; padding: 16px; border-radius: 12px; margin-bottom: 24px;">
            <ul style="margin:0; padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card-premium">
        <form action="{{ route('doctors.update', $doctor) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Part 1: Personal Details --}}
            <div class="section-title">Personal & Professional Info</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Doctor Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="license_number">License Registration Number</label>
                    <input type="text" name="license_number" id="license_number" class="form-control" value="{{ old('license_number', $doctor->license_number) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}" required>
                </div>
            </div>

            <div class="form-row" style="margin-bottom: 32px;">
                <div class="form-group" style="grid-column: span 2;">
                    <label for="specialization">Medical Specialization</label>
                    <input type="text" name="specialization" id="specialization" class="form-control" value="{{ old('specialization', $doctor->specialization) }}" required>
                </div>
            </div>

            {{-- Part 2: Location Details --}}
            <div class="section-title">Location & Clinic Address</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="state">Indian State</label>
                    <select name="state" id="state" class="form-control" required style="cursor:pointer;">
                        <option value="">-- Select State --</option>
                        @foreach($states as $st)
                            <option value="{{ $st }}" {{ old('state', $doctor->state) == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" id="city" class="form-control" required style="cursor:pointer;">
                        <option value="">-- Choose City --</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 32px; margin-top: 20px;">
                <label for="address">Full Clinic Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" placeholder="Room no, Building name, Clinic lane, etc.">{{ old('address', $doctor->address) }}</textarea>
            </div>

            {{-- Part 3: Timings & Capacity --}}
            <div class="section-title">Clinical Timetable & Limits</div>
            <div class="form-row" style="margin-bottom: 32px;">
                <div class="form-group">
                    <label for="start_time">Shift Start Time (24h format)</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', substr($doctor->start_time, 0, 5)) }}" required>
                </div>
                <div class="form-group">
                    <label for="end_time">Shift End Time (24h format)</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', substr($doctor->end_time, 0, 5)) }}" required>
                </div>
                <div class="form-group">
                    <label for="daily_limit">Max Daily Slots Limit</label>
                    <input type="number" name="daily_limit" id="daily_limit" class="form-control" value="{{ old('daily_limit', $doctor->daily_limit) }}" min="1" max="100" required>
                </div>
                <div class="form-group">
                    <label for="availability">Status</label>
                    <select name="availability" id="availability" class="form-control">
                        <option value="Available" {{ old('availability', $doctor->availability) === 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Unavailable" {{ old('availability', $doctor->availability) === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
            </div>

            {{-- Submission --}}
            <div style="display:flex; justify-content:flex-end; gap:12px; padding-top:20px; border-top:1px solid #f3f4f6;">
                <a href="{{ route('doctors.index') }}" class="btn btn-secondary" style="height:46px; border-radius:10px; display:inline-flex; align-items:center; font-weight:600;">Cancel</a>
                <button type="submit" class="btn-save" style="height:46px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Client-side dynamic state/city dropdown configuration
    const statesAndCities = @json($indianCities);
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    const currentState = "{{ old('state', $doctor->state) }}";
    const currentCity = "{{ old('city', $doctor->city) }}";

    function populateCities(state, activeCity = '') {
        citySelect.innerHTML = '<option value="">-- Choose City --</option>';
        if (state && statesAndCities[state]) {
            statesAndCities[state].forEach(city => {
                const opt = document.createElement('option');
                opt.value = city;
                opt.textContent = city;
                if (city === activeCity) {
                    opt.selected = true;
                }
                citySelect.appendChild(opt);
            });
        }
    }

    stateSelect.addEventListener('change', function() {
        populateCities(this.value);
    });

    // Populate on initial render
    if (currentState) {
        populateCities(currentState, currentCity);
    }
</script>
@endsection
