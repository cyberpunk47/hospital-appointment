@extends('layouts.app')

@section('title', $doctor->name . ' - Doctor Details')

@section('content')
<div class="page-header">
    <h1>Doctor Details</h1>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-header">
        <h2>{{ $doctor->name }}</h2>
        <span class="badge {{ $doctor->availability === 'Available' ? 'badge-available' : 'badge-unavailable' }}">
            {{ $doctor->availability }}
        </span>
    </div>
    <div class="detail-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Email</label>
                <p>{{ $doctor->email }}</p>
            </div>
            <div class="detail-item">
                <label>Phone</label>
                <p>{{ $doctor->phone }}</p>
            </div>
            <div class="detail-item">
                <label>Specialization</label>
                <p>{{ $doctor->specialization }}</p>
            </div>
            <div class="detail-item">
                <label>Address</label>
                <p>{{ $doctor->address ?? '—' }}</p>
            </div>
        </div>

        @if($doctor->appointments->count())
        <div class="detail-section">
            <h3>Appointments ({{ $doctor->appointments->count() }})</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctor->appointments as $appt)
                        <tr>
                            <td>{{ $appt->patient->name }}</td>
                            <td>{{ $appt->appointment_date->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
