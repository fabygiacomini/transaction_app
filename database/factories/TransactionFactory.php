<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payer_id' => User::factory(), // preserve foreign key relationship
            'payee_id' => User::factory(),
            'value' => $this->faker->randomFloat(2, 1, 9999999),
        ];
    }
}
