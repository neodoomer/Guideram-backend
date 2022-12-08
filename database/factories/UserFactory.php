<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email'=>fake()->email(),
            'password'=>fake()->password(),
            'name'=>fake()->name(),
            'photo'=>fake()->filePath(),
            'phone'=>fake()->phoneNumber(),
            'wallet'=>fake()->randomNumber(4),
        ];
    }
}
