<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'last_name' => $this->faker->lastName(),
            'name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
