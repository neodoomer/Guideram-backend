<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expert>
 */
class ExpertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'expert_id'=> User::factory()->suspended(),
            'experience'=>$this->faker->paragraph(),
            'phone'=>$this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            'cost'=>45.99,
            'duration'=>1
        ];
    }
}
