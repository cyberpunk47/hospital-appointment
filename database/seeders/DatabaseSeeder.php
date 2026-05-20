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
        // $doctors = [
        //     [
        //         'name' => 'Dr. Priya Sharma',
        //         'email' => 'priya.sharma@hospital.com',
        //         'phone' => '9876543210',
        //         'specialization' => 'Cardiology',
        //         'state' => 'Maharashtra',
        //         'city' => 'Mumbai',
        //         'availability' => 'Available',
        //         'start_time' => '09:00:00',
        //         'end_time' => '17:00:00',
        //         'daily_limit' => 15,
        //         'address' => 'Room 101, Building A, Lilavati Hospital, Bandra West, Mumbai',
        //     ],
        //     [
        //         'name' => 'Dr. Rajesh Kumar',
        //         'email' => 'rajesh.kumar@hospital.com',
        //         'phone' => '9876543211',
        //         'specialization' => 'Orthopedics',
        //         'state' => 'Maharashtra',
        //         'city' => 'Pune',
        //         'availability' => 'Available',
        //         'start_time' => '10:00:00',
        //         'end_time' => '18:00:00',
        //         'daily_limit' => 12,
        //         'address' => 'Room 205, Building B, Ruby Hall Clinic, Dhole Patil Road, Pune',
        //     ],
        //     [
        //         'name' => 'Dr. Anita Verma',
        //         'email' => 'anita.verma@hospital.com',
        //         'phone' => '9876543212',
        //         'specialization' => 'Dermatology',
        //         'state' => 'Karnataka',
        //         'city' => 'Bengaluru',
        //         'availability' => 'Available',
        //         'start_time' => '09:00:00',
        //         'end_time' => '13:00:00',
        //         'daily_limit' => 10,
        //         'address' => 'Room 310, Building A, Manipal Hospital, HAL Road, Bengaluru',
        //     ],
        //     [
        //         'name' => 'Dr. Sanjay Patel',
        //         'email' => 'sanjay.patel@hospital.com',
        //         'phone' => '9876543213',
        //         'specialization' => 'Neurology',
        //         'state' => 'Karnataka',
        //         'city' => 'Mysuru',
        //         'availability' => 'Available',
        //         'start_time' => '14:00:00',
        //         'end_time' => '20:00:00',
        //         'daily_limit' => 15,
        //         'address' => 'Room 402, Building C, Apollo BGS Hospital, Kuvempunagar, Mysuru',
        //     ],
        //     [
        //         'name' => 'Dr. Vikram Malhotra',
        //         'email' => 'vikram.malhotra@hospital.com',
        //         'phone' => '9876543214',
        //         'specialization' => 'Cardiology',
        //         'state' => 'Delhi',
        //         'city' => 'New Delhi',
        //         'availability' => 'Available',
        //         'start_time' => '08:30:00',
        //         'end_time' => '16:30:00',
        //         'daily_limit' => 20,
        //         'address' => 'Cardiology Wing, Fortis Escorts Heart Institute, Okhla, New Delhi',
        //     ],
        //     [
        //         'name' => 'Dr. Sunita Rao',
        //         'email' => 'sunita.rao@hospital.com',
        //         'phone' => '9876543215',
        //         'specialization' => 'Pediatrics',
        //         'state' => 'Delhi',
        //         'city' => 'New Delhi',
        //         'availability' => 'Available',
        //         'start_time' => '10:00:00',
        //         'end_time' => '17:00:00',
        //         'daily_limit' => 18,
        //         'address' => 'Max Super Speciality Hospital, Saket, New Delhi',
        //     ],
        //     [
        //         'name' => 'Dr. R. K. Swamy',
        //         'email' => 'rk.swamy@hospital.com',
        //         'phone' => '9876543216',
        //         'specialization' => 'General Medicine',
        //         'state' => 'Tamil Nadu',
        //         'city' => 'Chennai',
        //         'availability' => 'Available',
        //         'start_time' => '09:00:00',
        //         'end_time' => '17:00:00',
        //         'daily_limit' => 20,
        //         'address' => 'Apollo Hospitals, Greams Road, Chennai',
        //     ],
        //     [
        //         'name' => 'Dr. Meera Krishnan',
        //         'email' => 'meera.krishnan@hospital.com',
        //         'phone' => '9876543217',
        //         'specialization' => 'Dermatology',
        //         'state' => 'Tamil Nadu',
        //         'city' => 'Coimbatore',
        //         'availability' => 'Available',
        //         'start_time' => '11:00:00',
        //         'end_time' => '19:00:00',
        //         'daily_limit' => 12,
        //         'address' => 'KMCH Hospital, Avinashi Road, Coimbatore',
        //     ],
        //     [
        //         'name' => 'Dr. Arjun Reddy',
        //         'email' => 'arjun.reddy@hospital.com',
        //         'phone' => '9876543218',
        //         'specialization' => 'Orthopedics',
        //         'state' => 'Telangana',
        //         'city' => 'Hyderabad',
        //         'availability' => 'Available',
        //         'start_time' => '09:00:00',
        //         'end_time' => '15:00:00',
        //         'daily_limit' => 15,
        //         'address' => 'Yashoda Hospitals, Somajiguda, Hyderabad',
        //     ],
        //     [
        //         'name' => 'Dr. Kavitha Rao',
        //         'email' => 'kavitha.rao@hospital.com',
        //         'phone' => '9876543219',
        //         'specialization' => 'Pediatrics',
        //         'state' => 'Telangana',
        //         'city' => 'Hyderabad',
        //         'availability' => 'Available',
        //         'start_time' => '10:00:00',
        //         'end_time' => '18:00:00',
        //         'daily_limit' => 16,
        //         'address' => 'Continental Hospitals, Gachibowli, Hyderabad',
        //     ],
        //     [
        //         'name' => 'Dr. Hiren Shah',
        //         'email' => 'hiren.shah@hospital.com',
        //         'phone' => '9876543220',
        //         'specialization' => 'Cardiology',
        //         'state' => 'Gujarat',
        //         'city' => 'Ahmedabad',
        //         'availability' => 'Available',
        //         'start_time' => '09:30:00',
        //         'end_time' => '17:30:00',
        //         'daily_limit' => 15,
        //         'address' => 'Zydus Hospital, SG Highway, Ahmedabad',
        //     ],
        //     [
        //         'name' => 'Dr. Sneha Joshi',
        //         'email' => 'sneha.joshi@hospital.com',
        //         'phone' => '9876543221',
        //         'specialization' => 'General Medicine',
        //         'state' => 'Gujarat',
        //         'city' => 'Ahmedabad',
        //         'availability' => 'Available',
        //         'start_time' => '08:00:00',
        //         'end_time' => '14:00:00',
        //         'daily_limit' => 15,
        //         'address' => 'Apollo Hospitals, Bhat GIDC, Ahmedabad',
        //     ],
        // ];

        // foreach ($doctors as $doctor) {
        //     Doctor::create($doctor);
        // }

        // // Seed Patients
        // $patients = [
        //     [
        //         'name' => 'Amit Singh',
        //         'email' => 'amit.singh@email.com',
        //         'phone' => '9988776655',
        //         'date_of_birth' => '1990-05-15',
        //         'gender' => 'Male',
        //         'address' => '12, MG Road, Delhi',
        //     ],
        //     [
        //         'name' => 'Neha Gupta',
        //         'email' => 'neha.gupta@email.com',
        //         'phone' => '9988776656',
        //         'date_of_birth' => '1985-08-22',
        //         'gender' => 'Female',
        //         'address' => '45, Park Street, Mumbai',
        //     ],
        //     [
        //         'name' => 'Vikram Reddy',
        //         'email' => 'vikram.reddy@email.com',
        //         'phone' => '9988776657',
        //         'date_of_birth' => '1995-02-10',
        //         'gender' => 'Male',
        //         'address' => '78, Brigade Road, Bangalore',
        //     ],
        // ];

        // foreach ($patients as $patient) {
        //     Patient::create($patient);
        // }

        // // Seed Appointments
        // $appointments = [
        //     [
        //         'doctor_id' => 1,
        //         'patient_id' => 1,
        //         'appointment_date' => now()->toDateString(),
        //         'appointment_time' => '10:00',
        //         'status' => 'Scheduled',
        //         'notes' => 'Regular checkup',
        //     ],
        //     [
        //         'doctor_id' => 2,
        //         'patient_id' => 2,
        //         'appointment_date' => now()->addDay()->toDateString(),
        //         'appointment_time' => '14:30',
        //         'status' => 'Scheduled',
        //         'notes' => 'Knee pain consultation',
        //     ],
        //     [
        //         'doctor_id' => 1,
        //         'patient_id' => 3,
        //         'appointment_date' => now()->subDays(2)->toDateString(),
        //         'appointment_time' => '11:00',
        //         'status' => 'Completed',
        //         'notes' => 'Follow-up visit',
        //     ],
        // ];
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Appointment::truncate();
        Doctor::truncate();
        Patient::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Seed 100 Doctors
        $doctors = Doctor::factory()->count(100)->create();

        // Seed 200 Patients
        $patients = Patient::factory()->count(200)->create();

        // Seed random appointments linking them
        $statuses = ['Scheduled', 'Completed', 'Cancelled'];
        foreach ($patients as $patient) {
            $numAppointments = rand(1, 3);
            for ($i = 0; $i < $numAppointments; $i++) {
                $doctor = $doctors->random();
                $date = now()->addDays(rand(0, 15))->toDateString();
                
                $startHour = (int) substr($doctor->start_time, 0, 2);
                $endHour = (int) substr($doctor->end_time, 0, 2);
                if ($startHour >= $endHour || $startHour == 0) {
                    $startHour = 9;
                    $endHour = 17;
                }
                $hour = rand($startHour, $endHour - 1);
                $minute = rand(0, 1) ? '00' : '30';
                $time = sprintf('%02d:%s:00', $hour, $minute);

                Appointment::create([
                    'doctor_id' => $doctor->id,
                    'patient_id' => $patient->id,
                    'appointment_date' => $date,
                    'appointment_time' => $time,
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => 'Patient scheduled consultation regarding ' . $doctor->specialization,
                ]);
            }
        }
    }
}
