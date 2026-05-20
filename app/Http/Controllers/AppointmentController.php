<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->latest()->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::where('availability', 'Available')->get();
        $patients = Patient::all();
        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $autoAssign = !$request->filled('appointment_time');

        $rules = [
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ];

        if (!$autoAssign) {
            $rules['appointment_time'] = 'required';
        }

        $request->validate($rules);
        $data = $request->all();

        if ($autoAssign) {
            $doctor = Doctor::findOrFail($request->doctor_id);
            $date = $request->appointment_date;

            // Count existing active bookings for this doctor on this day
            $existingCount = Appointment::where('doctor_id', $doctor->id)
                ->where('appointment_date', $date)
                ->where('status', '!=', 'Cancelled')
                ->count();

            if ($existingCount >= $doctor->daily_limit) {
                return back()->withErrors(['appointment_date' => 'This doctor has reached their daily limit of ' . $doctor->daily_limit . ' appointments for the selected date. Please choose a different date.'])->withInput();
            }

            // Calculate slot time (30 mins per appointment)
            try {
                $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $doctor->start_time);
            } catch (\Exception $e) {
                $startTime = \Carbon\Carbon::createFromFormat('H:i', $doctor->start_time);
            }
            
            $slotTime = $startTime->copy()->addMinutes($existingCount * 30);

            // Check if it exceeds end_time
            try {
                $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $doctor->end_time);
            } catch (\Exception $e) {
                $endTime = \Carbon\Carbon::createFromFormat('H:i', $doctor->end_time);
            }

            if ($slotTime->greaterThanOrEqualTo($endTime)) {
                return back()->withErrors(['appointment_date' => 'All booking slots for this doctor are fully occupied on this date. Please choose a different date.'])->withInput();
            }

            $data['appointment_time'] = $slotTime->format('H:i:s');
        }

        Appointment::create($data);

        if ($request->has('from_search')) {
            $formattedTime = \Carbon\Carbon::createFromFormat('H:i:s', $data['appointment_time'])->format('h:i A');
            return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully! Your assigned slot is ' . $formattedTime . ' on ' . $request->appointment_date . '.');
        }

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor', 'patient']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::where('availability', 'Available')->get();
        $patients = Patient::all();
        return view('appointments.edit', compact('appointment', 'doctors', 'patients'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
