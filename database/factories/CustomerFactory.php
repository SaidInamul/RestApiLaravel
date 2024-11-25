<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $type = fake()->randomElement(['I', 'B']); //I is individual and B is business
        $name = $type == 'I' ? fake()->name() : fake()->company();

        return [
            //
            'name' => $name,
            'type' => $type,
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->city(),
            'postal_code' => fake()->postCode(),
        ];
    }
}
