<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
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
        return [
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->sentence(3),
            'author_id' => Author::factory(),
            'publisher' => fake()->company(),
            'year' => fake()->numberBetween(1950, 2024),
            'cover' => 'book-covers/default-book-cover.jpg',
            // 'cover' => 'https://via.placeholder.com/300x400.png?text=Book+Cover',
            'pdf_file' => fake()->boolean(30) ? 'book-pdfs/sample.pdf' : null,
            'status' => fake()->randomElement(['available', 'borrowed']),
            'desc' => fake()->paragraph(3, true),
        ];
    }
}
