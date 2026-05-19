@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="page-header">
    <h1>Appointment Details</h1>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-secondary">Edit</a>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="detail-card">
    <div class="detail-header">
        <h2>Appointment #{{ $appointment->id }}</h2>
        <span class="badge badge-{{ strtolower($appointment->status) }}">{{ $appointment->status }}</span>
    </div>
    <div class="detail-body">
        <div class="detail-grid">
            <div class="detail-item">
                <label>Doctor</label>
                <p>{{ $appointment->doctor->name }}</p>
            </div>
            <div class="detail-item">
                <label>Specialization</label>
                <p>{{ $appointment->doctor->specialization }}</p>
            </div>
            <div class="detail-item">
                <label>Patient</label>
                <p>{{ $appointment->patient->name }}</p>
            </div>
            <div class="detail-item">
                <label>Patient Email</label>
                <p>{{ $appointment->patient->email }}</p>
            </div>
            <div class="detail-item">
                <label>Date</label>
                <p>{{ $appointment->appointment_date->format('d M Y') }}</p>
            </div>
            <div class="detail-item">
                <label>Time</label>
                <p>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
            </div>
            <div class="detail-item">
                <label>Notes</label>
                <p>{{ $appointment->notes ?? '—' }}</p>
            </div>
            <div class="detail-item">
                <label>Created At</label>
                <p>{{ $appointment->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
