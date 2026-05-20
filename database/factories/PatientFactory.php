<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'date_of_birth' => $this->faker->date('Y-m-d', '-10 years'),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'address' => $this->faker->address(),
        ];
    }
}
