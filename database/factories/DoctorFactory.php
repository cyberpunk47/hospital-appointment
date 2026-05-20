<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        // 1. Load the exact array from your new config file
        $locations = config('indian_cities');

        // 2. Pick a random state from the array keys (e.g., "Maharashtra")
        $state = $this->faker->randomElement(array_keys($locations));
        
        // 3. Pick a random city from that specific state's list (e.g., "Pune")
        $city = $this->faker->randomElement($locations[$state]);

        return [
            // Use Faker for personal details
            'name' => 'Dr. ' . $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'specialization' => $this->faker->randomElement(['Cardiology', 'Orthopedics', 'Dermatology', 'Neurology', 'General Physician', 'Gynecology', 'Pediatrics', 'Ophthalmology', 'ENT']),
            'license_number' => 'MCI-' . $this->faker->unique()->numberBetween(10000, 99999),
            
            'state' => $state,
            'city' => $city,
            
            'availability' => 'Available',
            'start_time' => $this->faker->randomElement(['09:00:00', '10:00:00']),
            'end_time' => $this->faker->randomElement(['17:00:00', '18:00:00']),
            'daily_limit' => $this->faker->numberBetween(10, 20),
            'address' => $this->faker->streetAddress() . ', ' . $city,
        ];
    }
}