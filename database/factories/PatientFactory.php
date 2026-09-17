<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Enums\Gender;
use App\Enums\BloodGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'user_id' => null,

            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),

            'phone' => fake()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),

            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(Gender::cases()),
            'blood_group' => fake()->randomElement(BloodGroup::cases()),
        ];
    }
}