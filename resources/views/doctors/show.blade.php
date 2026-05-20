@extends('layouts.app')

@section('title', $doctor->name . ' - Doctor Details')

@section('content')
<style>
    .show-container {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .detail-card-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
        overflow: hidden;
        margin-top: 20px;
    }

    .card-header-premium {
        background: linear-gradient(135deg, #111111 0%, #1f2937 100%);
        padding: 32px;
        color: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .card-body-premium {
        padding: 32px;
    }

    .grid-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .info-item {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .info-item label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.5px;
    }

    .info-item p {
        font-size: 0.95rem;
        font-weight: 700;
        color: #111111;
        margin: 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111111;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e7eb;
    }
</style>

<div class="show-container">
    <div class="page-header">
        <div>
            <h1 style="display:flex; align-items:center; gap:8px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color:#2563eb;"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Doctor Profile
            </h1>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-primary" style="height:40px; border-radius:10px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/></svg>
                Edit Profile
            </a>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary" style="height:40px; border-radius:10px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" x2="5" y1="12" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to Directory
            </a>
        </div>
    </div>

    <div class="detail-card-premium">
        {{-- Header --}}
        <div class="card-header-premium">
            <div>
                <h2 style="font-size:1.75rem; font-weight:800; margin:0; letter-spacing:-0.5px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    {{ $doctor->name }}
                    <span style="font-size:0.8rem; font-family:monospace; background-color:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2); color:#ffffff; padding:4px 10px; border-radius:6px; font-weight:700;">
                        {{ $doctor->license_number ?? 'No License' }}
                    </span>
                </h2>
                <p style="color:#d1d5db; margin:6px 0 0; font-size:0.95rem; font-weight:500;">
                    Specialist: <strong>{{ $doctor->specialization }}</strong>
                </p>
            </div>
            <span class="badge {{ $doctor->availability === 'Available' ? 'badge-available' : 'badge-unavailable' }}" style="padding: 8px 16px; font-size:0.85rem; font-weight:700; border-radius:9999px;">
                {{ $doctor->availability }}
            </span>
        </div>

        {{-- Body --}}
        <div class="card-body-premium">
            
            {{-- Contact & Timings Grid --}}
            <div class="section-title">Clinical & Contact Details</div>
            <div class="grid-info">
                {{-- Email --}}
                <div class="info-item">
                    <label>Email Address</label>
                    <p>{{ $doctor->email }}</p>
                </div>
                {{-- Phone --}}
                <div class="info-item">
                    <label>Phone Number</label>
                    <p>{{ $doctor->phone }}</p>
                </div>
                {{-- Location --}}
                <div class="info-item">
                    <label>State & City</label>
                    <p>{{ $doctor->city }}, {{ $doctor->state }}</p>
                </div>
                {{-- Shift Timings --}}
                <div class="info-item">
                    <label>Clinical Timetable</label>
                    @php
                        $start = $doctor->start_time;
                        $end = $doctor->end_time;
                        try {
                            $start = \Carbon\Carbon::createFromFormat('H:i:s', $doctor->start_time)->format('h:i A');
                        } catch (\Exception $e) {
                            try {
                                $start = \Carbon\Carbon::createFromFormat('H:i', $doctor->start_time)->format('h:i A');
                            } catch (\Exception $ex) {}
                        }
                        try {
                            $end = \Carbon\Carbon::createFromFormat('H:i:s', $doctor->end_time)->format('h:i A');
                        } catch (\Exception $e) {
                            try {
                                $end = \Carbon\Carbon::createFromFormat('H:i', $doctor->end_time)->format('h:i A');
                            } catch (\Exception $ex) {}
                        }
                    @endphp
                    <p>{{ $start }} - {{ $end }}</p>
                </div>
                {{-- Capacity --}}
                <div class="info-item">
                    <label>Daily Slots Capacity</label>
                    <p>{{ $doctor->daily_limit }} patients / day</p>
                </div>
            </div>

            {{-- Address Box --}}
            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:40px;">
                <h4 style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:#6b7280; letter-spacing:0.5px; margin:0 0 8px;">Clinic / Chamber Address</h4>
                <p style="font-size:0.95rem; color:#111111; margin:0; line-height:1.5; font-weight:600;">
                    {{ $doctor->address ?? 'No address registered.' }}
                </p>
            </div>

            {{-- Active Appointments --}}
            <div class="section-title">Registered Appointments ({{ $doctor->appointments->count() }})</div>
            @if($doctor->appointments->count())
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Contact</th>
                                <th>Appointment Date</th>
                                <th>Scheduled Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctor->appointments as $appt)
                                <tr>
                                    <td style="font-weight:700; color:#111111;">{{ $appt->patient->name }}</td>
                                    <td style="color:#6b7280;">{{ $appt->patient->phone }}</td>
                                    <td style="font-weight:500;">
                                        {{ $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') : '—' }}
                                    </td>
                                    <td style="font-weight:600; color:#2563eb;">
                                        {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ strtolower($appt->status) }}">
                                            {{ $appt->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align:center; padding:32px 16px; background-color:#fafafa; border:1px dashed #e5e7eb; border-radius:12px; color:#6b7280;">
                    <p style="margin:0; font-size:0.9rem;">No appointments booked with this doctor yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
