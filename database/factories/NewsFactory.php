<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'image_card' => $this->faker->imageUrl,
            'image_header' => $this->faker->imageUrl,
            'is_public' => true,
        ];
    }
}
