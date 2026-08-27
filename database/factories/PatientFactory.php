<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Patient::class;
    public function definition(): array
    {
        return [
        "user_id" => UserFactory::factory()->create([
                "role" => "patient",
            ])->id,

            "phone" => fake()->phoneNumber(),
            "date_of_birth" => fake()->date(),
            "gender" => fake()->randomElement([
                "Male",
                "Female",
            ]),
        ];
    }
}
