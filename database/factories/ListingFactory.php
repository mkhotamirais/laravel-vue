<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement([1, 2, 3, 4, 5, 6]),
            'title' => fake()->sentence(10),
            'description' => fake()->paragraph(10),
            'email' => fake()->email(),
            'link' => fake()->url(),
            'tags' => fake()->randomElement(['html,css,js', 'laravel,php', 'wordpress,php', 'angular,vue,react,js']),
            'approved' => 1
        ];
    }
}
