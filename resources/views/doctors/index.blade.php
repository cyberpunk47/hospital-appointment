@extends('layouts.app')

@section('title', 'Doctor Directory - Hospital Appointment Management')

@section('content')
<style>
    .directory-container {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .directory-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .search-box {
        display: flex;
        gap: 8px;
        flex: 1;
        max-width: 450px;
        width: 100%;
    }

    .table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
    }

    .table-premium th {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #4b5563;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 2px solid #f3f4f6;
    }

    .table-premium th a {
        color: #4b5563;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.15s;
    }

    .table-premium th a:hover {
        color: #111111;
    }

    .table-premium td {
        padding: 16px;
        font-size: 0.9rem;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .doctor-name-cell {
        font-weight: 700;
        color: #111111;
    }

    .doctor-subtext {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 2px;
        font-weight: 400;
    }

    .action-link {
        font-weight: 700;
        font-size: 0.8rem;
        color: #2563eb;
        text-decoration: none;
        transition: color 0.15s;
    }

    .action-link:hover {
        color: #1d4ed8;
    }

    /* Custom CSS pagination wrapper styling */
    .pagination-wrapper {
        margin-top: 24px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper nav {
        display: inline-flex;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
</style>

@php
    function sortLink($field, $label, $currentSortBy, $currentSortOrder) {
        $order = ($currentSortBy === $field && $currentSortOrder === 'asc') ? 'desc' : 'asc';
        $url = route('doctors.index', array_merge(request()->query(), ['sort_by' => $field, 'sort_order' => $order]));
        
        $icon = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:2px; opacity:0.3;"><path d="m7 15 5 5 5-5M7 9l5-5 5 5"/></svg>';
        if ($currentSortBy === $field) {
            $icon = $currentSortOrder === 'asc' 
                ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-left:2px; color:#2563eb;"><path d="m18 15-6-6-6 6"/></svg>'
                : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-left:2px; color:#2563eb;"><path d="m6 9 6 6 6-6"/></svg>';
        }
        
        return '<a href="' . $url . '">' . e($label) . $icon . '</a>';
    }
@endphp

<div class="directory-container">
    <div class="page-header" style="margin-bottom: 16px;">
        <div>
            <h1>Doctors Directory</h1>
            <p style="color:#6b7280; font-size:0.9rem; margin-top:4px;">Manage all clinical staff records, unique licenses, active schedules, and daily patient capacities.</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary" style="height:40px; border-radius:10px; font-weight:600; display:inline-flex; align-items:center; gap:6px; background-color:#111111;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
            Add New Doctor
        </a>
    </div>

    @if(session('success'))
        <div style="background-color:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:12px 16px; border-radius:12px; margin-bottom:20px; font-size:0.9rem; font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Controls & Search Bar --}}
    <div class="directory-controls">
        <div class="search-box">
            <form action="{{ route('doctors.index') }}" method="GET" style="display:flex; width:100%; gap:8px;">
                <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                <input type="hidden" name="sort_order" value="{{ $sortOrder }}">
                
                <input type="text" name="search" class="form-control" placeholder="Search by name, spec, license, or location..." 
                       value="{{ $search }}" style="flex:1; border-radius:10px; padding:10px 14px; border-color:#d1d5db;">
                
                <button type="submit" class="btn btn-secondary" style="border-radius:10px; padding:10px 18px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
                @if($search)
                    <a href="{{ route('doctors.index', ['sort_by' => $sortBy, 'sort_order' => $sortOrder]) }}" class="btn btn-secondary" style="border-radius:10px; padding:10px 14px; display:inline-flex; align-items:center;">
                        Clear
                    </a>
                @endif
            </form>
        </div>
        <span style="font-size:0.85rem; color:#6b7280; font-weight:500;">
            Showing {{ $doctors->firstItem() ?? 0 }} to {{ $doctors->lastItem() ?? 0 }} of {{ $doctors->total() }} record(s)
        </span>
    </div>

    <div class="table-card">
        @if($doctors->count())
            <div class="table-wrapper">
                <table class="table-premium" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width: 8%; text-align: left;">{!! sortLink('id', 'ID', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 15%; text-align: left;">{!! sortLink('license_number', 'License', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 23%; text-align: left;">{!! sortLink('name', 'Doctor Profile', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 18%; text-align: left;">{!! sortLink('specialization', 'Specialization', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 16%; text-align: left;">{!! sortLink('city', 'Location', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 12%; text-align: center;">{!! sortLink('daily_limit', 'Daily Limit', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 10%; text-align: center;">{!! sortLink('availability', 'Status', $sortBy, $sortOrder) !!}</th>
                            <th style="width: 12%; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                            <tr>
                                <td style="color:#6b7280; font-weight:600;">#{{ $doctor->id }}</td>
                                <td>
                                    <span style="font-family: monospace; font-size: 0.85rem; background-color: #f3f4f6; color: #111111; padding: 4px 8px; border-radius: 6px; font-weight: 700; border: 1px solid #e5e7eb;">
                                        {{ $doctor->license_number ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="doctor-name-cell">{{ $doctor->name }}</div>
                                    <div class="doctor-subtext">{{ $doctor->email }} &bull; {{ $doctor->phone }}</div>
                                </td>
                                <td>
                                    <span style="font-weight:600; color:#111111;">{{ $doctor->specialization }}</span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#111111;">{{ $doctor->city }}</div>
                                    <div style="font-size:0.75rem; color:#6b7280;">{{ $doctor->state }}</div>
                                </td>
                                <td style="text-align: center; font-weight:700; color:#111111;">
                                    {{ $doctor->daily_limit }} slots
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge {{ $doctor->availability === 'Available' ? 'badge-available' : 'badge-unavailable' }}" style="font-size:0.75rem; font-weight:700; border-radius:6px; padding:4px 8px;">
                                        {{ $doctor->availability }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display:flex; gap:12px; justify-content:flex-end; align-items:center;">
                                        <a href="{{ route('doctors.show', $doctor) }}" class="action-link" title="View details and appointments">View</a>
                                        <a href="{{ route('doctors.edit', $doctor) }}" class="action-link" style="color:#059669;" title="Edit profile details">Edit</a>
                                        
                                        <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor? All scheduled appointments will remain intact.')" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background:none; border:none; color:#dc2626; font-weight:700; font-size:0.8rem; cursor:pointer; padding:0;" title="Delete doctor profile">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Render standard Laravel Bootstrap/Tailwind pagination links --}}
            <div class="pagination-wrapper">
                {{ $doctors->links() }}
            </div>
        @else
            <div class="empty-state" style="padding:48px 16px; text-align:center; color:#6b7280;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:16px; color:#9ca3af;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" y1="8" x2="22" y2="13"/><line x1="22" y1="8" x2="17" y2="13"/></svg>
                <h3>No Doctors Found</h3>
                <p style="margin:8px 0 16px; font-size:0.9rem;">No records match your filters. Try adjusting search criteria or registering a profile.</p>
                <a href="{{ route('doctors.create') }}" class="btn btn-primary" style="height:40px; border-radius:10px; font-weight:600; display:inline-flex; align-items:center; background-color:#111111;">Add Your First Doctor</a>
            </div>
        @endif
    </div>
</div>
@endsection
