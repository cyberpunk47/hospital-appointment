@extends('layouts.app')

@section('title', 'Dashboard - Hospital Appointment Management')

@section('content')
<style>
    /* Styling for the premium Welcome Dashboard */
    .welcome-container {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Elegant high-end landing banner */
    .welcome-hero {
        background: linear-gradient(135deg, #111111 0%, #1e3a8a 100%);
        border-radius: 20px;
        padding: 56px 40px;
        color: #ffffff;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .welcome-hero::before {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.2) 0%, transparent 60%);
        border-radius: 50%;
        pointer-events: none;
    }

    .welcome-hero h1 {
        font-size: 2.75rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 12px;
        line-height: 1.15;
    }

    .welcome-hero p {
        color: #bfdbfe;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 28px;
        font-weight: 400;
        line-height: 1.6;
    }

    /* Premium Grid of Stat Cards */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }

    .stat-card-premium:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #d1d5db;
    }

    .stat-icon-premium {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.2s;
    }

    .stat-card-premium:hover .stat-icon-premium {
        transform: scale(1.05);
    }

    /* Individual Card Color Theme */
    .icon-doctors { background-color: #eff6ff; color: #2563eb; }
    .icon-patients { background-color: #f0fdf4; color: #16a34a; }
    .icon-total { background-color: #faf5ff; color: #9333ea; }
    .icon-today { background-color: #fffbeb; color: #d97706; }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111111;
        letter-spacing: -0.5px;
        line-height: 1.1;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.5px;
    }

    /* Styled Dashboard Actions Section */
    .action-panel {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.01);
    }

    .action-panel-header {
        margin-bottom: 24px;
        text-align: center;
    }

    .action-panel-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111111;
        letter-spacing: -0.3px;
        margin-bottom: 4px;
    }

    .action-panel-header p {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        justify-content: center;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }

    .btn-find-now {
        background: linear-gradient(to right, #111111, #2563eb);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.2);
    }

    .btn-find-now:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-action-outline {
        background: #ffffff;
        color: #111111;
        border: 1px solid #d1d5db;
    }

    .btn-action-outline:hover {
        background: #f9fafb;
        border-color: #9ca3af;
        transform: translateY(-1px);
    }
</style>

<div class="welcome-container">
    {{-- High-End Hero Section --}}
    <div class="welcome-hero">
        <h1>Smart Hospital Availability</h1>
        <p>A unified portal to register patients, track clinical timetables, check active availability, and instantly book waitlist-free appointments.</p>
        
        <div style="display:flex; justify-content:center;">
            <a href="{{ route('nmc.search') }}" class="action-btn btn-find-now" style="padding: 16px 32px; font-size:1rem; border-radius:14px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Find Doctors & Book Slot
            </a>
        </div>
    </div>

    {{-- Dashboard Stats Grid --}}
    <div class="dashboard-stats">
        {{-- Doctors --}}
        <div class="stat-card-premium">
            <div class="stat-icon-premium icon-doctors">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <div class="stat-number">{{ $doctorCount }}</div>
                <div class="stat-label">Doctors</div>
            </div>
        </div>

        {{-- Patients --}}
        <div class="stat-card-premium">
            <div class="stat-icon-premium icon-patients">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="stat-number">{{ $patientCount }}</div>
                <div class="stat-label">Patients</div>
            </div>
        </div>

        {{-- Total Appointments --}}
        <div class="stat-card-premium">
            <div class="stat-icon-premium icon-total">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <div>
                <div class="stat-number">{{ $appointmentCount }}</div>
                <div class="stat-label">Total Bookings</div>
            </div>
        </div>

        {{-- Today's Appointments --}}
        <div class="stat-card-premium">
            <div class="stat-icon-premium icon-today">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <div class="stat-number">{{ $todayAppointments }}</div>
                <div class="stat-label">Today's Slots</div>
            </div>
        </div>
    </div>

    {{-- Quick Action Panel --}}
    <div class="action-panel">
        <div class="action-panel-header">
            <h2>Administrative Quick Actions</h2>
            <p>Perform key system operations instantly below</p>
        </div>
        
        <div class="action-grid">
            <a href="{{ route('doctors.create') }}" class="action-btn btn-action-outline">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                Add New Doctor
            </a>
            
            <a href="{{ route('patients.create') }}" class="action-btn btn-action-outline">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                Register Patient
            </a>

            <a href="{{ route('appointments.index') }}" class="action-btn btn-action-outline">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                View Bookings
            </a>
        </div>
    </div>
</div>
@endsection
