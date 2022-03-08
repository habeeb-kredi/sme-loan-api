<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title"=>$this->faker->word(),
            "description"=>$this->faker->text(200),
            "customer_kyc_id"=>5,
            "status"=>0,
        ];
    }
}
