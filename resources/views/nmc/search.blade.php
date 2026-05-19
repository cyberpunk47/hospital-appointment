@extends('layouts.app')

@section('title', 'Find Doctors in India - NMC Registry')

@section('content')
<div class="page-header">
    <div>
        <h1>Find Registered Doctors</h1>
        <p style="color:var(--gray-500);font-size:0.85rem;margin-top:4px;">
            Search the National Medical Commission (NMC) Indian Medical Register — 1.4M+ verified doctors
        </p>
    </div>
</div>

{{-- Search Form --}}
<div class="form-card" style="max-width:100%;margin-bottom:24px;">
    <form action="{{ route('nmc.search') }}" method="GET">
        <input type="hidden" name="search" value="1">
        <div class="form-row">
            <div class="form-group" style="margin-bottom:0;">
                <label for="name">Doctor Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ $name }}" placeholder="e.g. Sharma, Patel, Kumar...">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label for="smc">State Medical Council</label>
                <select name="smc" id="smc" class="form-control">
                    <option value="">All States</option>
                    @foreach($smcList as $id => $smcName)
                        <option value="{{ $id }}" {{ $smc == $id ? 'selected' : '' }}>{{ $smcName }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions" style="border-top:none;margin-top:16px;padding-top:0;">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Search Registry
            </button>
            @if($searching)
            <a href="{{ route('nmc.search') }}" class="btn btn-secondary">Clear</a>
            @endif
        </div>
    </form>
</div>

{{-- Status Messages --}}
@if($usingFallback)
<div class="alert alert-error" style="border-color:#f0c6a8;background:#fff8f0;color:#a0522d;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    <div>
        <p style="font-weight:600;margin-bottom:2px;">NMC API is currently unreachable</p>
        <p style="font-weight:400;">Showing doctors from the local hospital directory as a fallback.</p>
    </div>
</div>
@endif

{{-- Results --}}
@if($searching)
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
    <p style="font-size:0.85rem;color:var(--gray-500);">
        @if(!$usingFallback && $total > 0)
            Showing page {{ $page }} &mdash; {{ number_format($total) }} total registered doctors
        @elseif($usingFallback)
            {{ count($doctors) }} doctor(s) from local directory
        @endif
    </p>
    @if(!$usingFallback && $total > 0)
    <p style="font-size:0.75rem;color:var(--gray-400);">
        Source: NMC Indian Medical Register &middot; Cached 30 min
    </p>
    @endif
</div>

<div class="table-wrapper">
    @if(count($doctors) > 0)
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Reg. Number</th>
                <th>State Medical Council</th>
                <th>Year</th>
                @if($usingFallback)
                <th>Specialization</th>
                <th>Status</th>
                @endif
                <th>Profile</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doc)
            <tr>
                <td>{{ $doc['row_num'] }}</td>
                <td style="font-weight:500;">{{ $doc['name'] }}</td>
                <td><code style="font-size:0.8rem;background:var(--gray-100);padding:2px 6px;border-radius:3px;">{{ $doc['registration_number'] }}</code></td>
                <td>{{ $doc['state_medical_council'] }}</td>
                <td>{{ $doc['year'] }}</td>
                @if($usingFallback)
                <td>{{ $doc['specialization'] ?? '—' }}</td>
                <td>
                    <span class="badge {{ ($doc['availability'] ?? '') === 'Available' ? 'badge-available' : 'badge-unavailable' }}">
                        {{ $doc['availability'] ?? '—' }}
                    </span>
                </td>
                @endif
                <td>
                    @if(!empty($doc['profile_url']))
                    <a href="{{ $doc['profile_url'] }}" target="_blank" class="btn btn-secondary btn-sm" rel="noopener">
                        NMC Profile
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                    @elseif($usingFallback)
                    <a href="{{ route('doctors.show', $doc['row_num']) }}" class="btn btn-secondary btn-sm">View</a>
                    @else
                    <span style="color:var(--gray-400);font-size:0.8rem;">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <p>No doctors found matching your criteria.</p>
        <p style="font-size:0.8rem;color:var(--gray-400);margin-top:4px;">
            Try a different name or state, or browse without filters.
        </p>
    </div>
    @endif
</div>

{{-- Pagination --}}
@if(!$usingFallback && $total > $perPage)
<div class="pagination-bar">
    @if($page > 1)
    <a href="{{ route('nmc.search', array_merge(request()->query(), ['page' => $page - 1])) }}" class="btn btn-secondary btn-sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        Previous
    </a>
    @else
    <span></span>
    @endif

    <span class="pagination-info">Page {{ $page }} of {{ number_format($totalPages) }}</span>

    @if($page < $totalPages)
    <a href="{{ route('nmc.search', array_merge(request()->query(), ['page' => $page + 1])) }}" class="btn btn-secondary btn-sm">
        Next
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    @else
    <span></span>
    @endif
</div>
@endif

@else
{{-- Initial state — no search yet --}}
<div class="nmc-intro">
    <div class="intro-grid">
        <div class="intro-card">
            <div class="intro-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3>1.4M+ Doctors</h3>
            <p>Access the complete Indian Medical Register maintained by NMC</p>
        </div>
        <div class="intro-card">
            <div class="intro-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3>Verified Registry</h3>
            <p>Government-authorized data from the National Medical Commission</p>
        </div>
        <div class="intro-card">
            <div class="intro-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <h3>State-wise Search</h3>
            <p>Filter by any State Medical Council across India</p>
        </div>
    </div>
    <p style="text-align:center;color:var(--gray-400);font-size:0.8rem;margin-top:24px;">
        Data sourced from NMC Indian Medical Register (nmc.org.in). If the live API is unavailable, local hospital directory data is shown.
    </p>
</div>
@endif
@endsection
