<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Doctors
        $doctors = [
            [
                'name' => 'Dr. Priya Sharma',
                'email' => 'priya.sharma@hospital.com',
                'phone' => '9876543210',
                'specialization' => 'Cardiology',
                'availability' => 'Available',
                'address' => 'Room 101, Building A',
            ],
            [
                'name' => 'Dr. Rajesh Kumar',
                'email' => 'rajesh.kumar@hospital.com',
                'phone' => '9876543211',
                'specialization' => 'Orthopedics',
                'availability' => 'Available',
                'address' => 'Room 205, Building B',
            ],
            [
                'name' => 'Dr. Anita Verma',
                'email' => 'anita.verma@hospital.com',
                'phone' => '9876543212',
                'specialization' => 'Dermatology',
                'availability' => 'Unavailable',
                'address' => 'Room 310, Building A',
            ],
            [
                'name' => 'Dr. Sanjay Patel',
                'email' => 'sanjay.patel@hospital.com',
                'phone' => '9876543213',
                'specialization' => 'Neurology',
                'availability' => 'Available',
                'address' => 'Room 402, Building C',
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }

        // Seed Patients
        $patients = [
            [
                'name' => 'Amit Singh',
                'email' => 'amit.singh@email.com',
                'phone' => '9988776655',
                'date_of_birth' => '1990-05-15',
                'gender' => 'Male',
                'address' => '12, MG Road, Delhi',
            ],
            [
                'name' => 'Neha Gupta',
                'email' => 'neha.gupta@email.com',
                'phone' => '9988776656',
                'date_of_birth' => '1985-08-22',
                'gender' => 'Female',
                'address' => '45, Park Street, Mumbai',
            ],
            [
                'name' => 'Vikram Reddy',
                'email' => 'vikram.reddy@email.com',
                'phone' => '9988776657',
                'date_of_birth' => '1995-02-10',
                'gender' => 'Male',
                'address' => '78, Brigade Road, Bangalore',
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }

        // Seed Appointments
        $appointments = [
            [
                'doctor_id' => 1,
                'patient_id' => 1,
                'appointment_date' => now()->toDateString(),
                'appointment_time' => '10:00',
                'status' => 'Scheduled',
                'notes' => 'Regular checkup',
            ],
            [
                'doctor_id' => 2,
                'patient_id' => 2,
                'appointment_date' => now()->addDay()->toDateString(),
                'appointment_time' => '14:30',
                'status' => 'Scheduled',
                'notes' => 'Knee pain consultation',
            ],
            [
                'doctor_id' => 1,
                'patient_id' => 3,
                'appointment_date' => now()->subDays(2)->toDateString(),
                'appointment_time' => '11:00',
                'status' => 'Completed',
                'notes' => 'Follow-up visit',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
