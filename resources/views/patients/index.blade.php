@extends('layouts.app')

@section('title', 'Patients - Hospital Appointment System')

@section('content')
<div class="page-header">
    <h1>Patients</h1>
    <a href="{{ route('patients.create') }}" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Add Patient
    </a>
</div>

<div class="table-wrapper">
    @if($patients->count())
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->id }}</td>
                <td style="font-weight:500;">{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->phone }}</td>
                <td>{{ $patient->gender }}</td>
                <td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') : '—' }}</td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary btn-sm">View</a>
                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Delete this patient?')">
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
        <p>No patients found.</p>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Add your first patient</a>
    </div>
    @endif
</div>
@endsection
