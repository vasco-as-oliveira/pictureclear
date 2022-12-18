<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     
    
    public function definition()
    {
        return [
            'owner_id' => User::factory(),
            'language' => fake()->languageCode(),
            'title' => fake()->realTextBetween(5,15),
            'description' => fake()->text(),
            'rating' => fake()->numberBetween(1,5),
            'has_certificate' => fake()->boolean(),
            'total_hours' => fake()->randomNumber(),
        ];
    }
}
