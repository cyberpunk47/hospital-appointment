@extends('layouts.app')

@section('title', 'Doctors - Hospital Appointment System')

@section('content')
<div class="page-header">
    <h1>Doctors</h1>
    <a href="{{ route('doctors.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Add Doctor
    </a>
</div>

<div class="table-wrapper">
    @if($doctors->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
            <tr>
                <td>{{ $doctor->id }}</td>
                <td style="font-weight:500;">{{ $doctor->name }}</td>
                <td>{{ $doctor->email }}</td>
                <td>{{ $doctor->phone }}</td>
                <td>{{ $doctor->specialization }}</td>
                <td>
                    <span class="badge {{ $doctor->availability === 'Available' ? 'badge-available' : 'badge-unavailable' }}">
                        {{ $doctor->availability }}
                    </span>
                </td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-secondary btn-sm">View</a>
                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Delete this doctor?')">
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
        <p>No doctors found.</p>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add your first doctor</a>
    </div>
    @endif
</div>
@endsection
