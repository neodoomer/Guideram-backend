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
            'name'=> $this->faker->name(),
            'email'=>$this->faker->email(),
            'password'=>$this->faker->password(),
            'photo'=>'profile.img',
            'is_expert'=>false
        ];
    }
    public function suspended()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_expert' => true
            ];
        });
    }
}
