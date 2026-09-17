<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'employee_id' => 'EMP' . fake()->unique()->numberBetween(100000, 999999),

            'role' => fake()->randomElement([
                Role::DOCTOR,
                Role::NURSE,
                Role::RECEPTIONIST,
            ]),

            'email_verified_at' => now(),

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

            'remember_token' => Str::random(10),
        ];
    }

    public function doctor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::DOCTOR,
        ]);
    }

    public function nurse(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::NURSE,
        ]);
    }

    public function receptionist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::RECEPTIONIST,
        ]);
    }

    public function patient(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::PATIENT,
            'employee_id' => null,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}