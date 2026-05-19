@extends('layouts.app')

@section('title', 'Edit Appointment - Hospital Appointment System')

@section('content')
<div class="page-header">
    <h1>Edit Appointment</h1>
    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back to Appointments</a>
</div>

<div class="form-card">
    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="doctor_id">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required>
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} — {{ $doctor->specialization }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="patient_id">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="appointment_date">Date</label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label for="appointment_time">Time</label>
                <input type="time" name="appointment_time" id="appointment_time" class="form-control" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Scheduled" {{ old('status', $appointment->status) === 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="Completed" {{ old('status', $appointment->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Cancelled" {{ old('status', $appointment->status) === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes', $appointment->notes) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
