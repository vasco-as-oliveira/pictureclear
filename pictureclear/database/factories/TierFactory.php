<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'course_id' => Course::factory(),
            'price' => fake()->numberBetween(5,20),
            'hasscheduleperk' => fake()->boolean(),
            'haschatperk' => fake()->boolean(),
            'created_at' => now(),
        ];
    }
}
