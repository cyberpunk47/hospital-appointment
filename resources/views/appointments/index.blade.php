@extends('layouts.app')

@section('title', 'Appointments - Hospital Appointment System')

@section('content')
<div class="page-header">
    <h1>Appointments</h1>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Book Appointment
    </a>
</div>

<div class="table-wrapper">
    @if($appointments->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td style="font-weight:500;">{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($appointment->status) }}">{{ $appointment->status }}</span>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-secondary btn-sm">View</a>
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment?')">
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
    @else
    <div class="empty-state">
        <p>No appointments found.</p>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Book your first appointment</a>
    </div>
    @endif
</div>
@endsection
