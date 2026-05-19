<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NmcSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $doctorCount = \App\Models\Doctor::count();
    $patientCount = \App\Models\Patient::count();
    $appointmentCount = \App\Models\Appointment::count();
    $todayAppointments = \App\Models\Appointment::whereDate('appointment_date', today())->count();
    return view('welcome', compact('doctorCount', 'patientCount', 'appointmentCount', 'todayAppointments'));
});

Route::resource('doctors', DoctorController::class);
Route::resource('patients', PatientController::class);
Route::resource('appointments', AppointmentController::class);

Route::get('/find-doctors', [NmcSearchController::class, 'index'])->name('nmc.search');
