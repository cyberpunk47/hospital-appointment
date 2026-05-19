@extends('layouts.app')

@section('title', 'Edit Doctor - Hospital Appointment System')

@section('content')
<div class="page-header">
    <h1>Edit Doctor</h1>
    <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Back to Doctors</a>
</div>

<div class="form-card">
    <form action="{{ route('doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $doctor->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $doctor->phone) }}" required>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization</label>
                <input type="text" name="specialization" id="specialization" class="form-control" value="{{ old('specialization', $doctor->specialization) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="availability">Availability</label>
            <select name="availability" id="availability" class="form-control">
                <option value="Available" {{ old('availability', $doctor->availability) === 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Unavailable" {{ old('availability', $doctor->availability) === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control">{{ old('address', $doctor->address) }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Doctor</button>
            <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
