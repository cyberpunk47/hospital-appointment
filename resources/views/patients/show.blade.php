@extends('layouts.app')

@section('title', $patient->name . ' - Patient Details')

@section('content')
<div class="page-header">
    <h1>Patient Details</h1>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-header">
        <h2>{{ $patient->name }}</h2>
    </div>
    <div class="detail-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Email</label>
                <p>{{ $patient->email }}</p>
            </div>
            <div class="detail-item">
                <label>Phone</label>
                <p>{{ $patient->phone }}</p>
            </div>
            <div class="detail-item">
                <label>Gender</label>
                <p>{{ $patient->gender }}</p>
            </div>
            <div class="detail-item">
                <label>Date of Birth</label>
                <p>{{ $patient->date_of_birth ? $patient->date_of_birth->format('d M Y') : '—' }}</p>
            </div>
            <div class="detail-item">
                <label>Address</label>
                <p>{{ $patient->address ?? '—' }}</p>
            </div>
        </div>

        @if($patient->appointments->count())
        <div class="detail-section">
            <h3>Appointments ({{ $patient->appointments->count() }})</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patient->appointments as $appt)
                        <tr>
                            <td>{{ $appt->doctor->name }}</td>
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
