<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isPremium = fake()->boolean(70); // 70% premium, 30% free

        return [
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence(3),
            'published_year' => fake()->year(),
            'pages' => fake()->numberBetween(100, 600),
            'published' => true,
            'available' => true,
            'price' => $isPremium ? fake()->randomFloat(2, 10, 100) : 0,
            'listed_by_user_id' => User::where('role', 'admin')->first()?->id ?? User::factory()->create(['role' => 'admin'])->id,
        ];
    }
}
