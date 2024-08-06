<?php

namespace Database\Factories;

use App\Const\BookCoverType;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends ElasticAwareFactory
{
    protected static int $_id = 0;
    private static Author $_owner;

    public function setOwner(Author $author): self
    {
        self::$_owner = $author;

        return $this;
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'id' => $id = ++self::$_id,
            'title' => fake()->sentence(3),
            'isbn' => fake()->isbn13(),
            'dimensions' => $this->fakeDimensions(),
            'num_of_pages' => fake()->numberBetween(50, 999),
            'cover_type' => $this->fake('cover_type'),
            'year_of_release' => fake()->date(),
            'edition' => fake()->numberBetween(1, 10),
            'genre' => $this->fake('genre'),
            'type' => $this->fake('type'),
        ];

        self::$_elasticSearch->add('book', $data, $id, nested:['author' => [self::$_owner->toArray()]]);

        return $data;
    }

    private function fake(string $type)
    {
        $source =  match ($type) {
            'cover_type' => BookCoverType::getValues(),
            'genre' => ['drama', 'horror', 'comedy', 'romance', 'science'],
            'type' => ['autobiography', 'proza', 'poetry', 'fiction', 'realism', 'popular science'],
        };

        return $source[array_rand($source)];
    }

    private function fakeDimensions(): string
    {
        return sprintf('%dx%d', fake()->numberBetween(10, 99), fake()->numberBetween(10, 99));
    }
}
