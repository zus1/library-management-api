<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    protected static int $_id = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => ++self::$_id,
            'name' => fake()->name(),
            'dob' => fake()->date(),
            'nationality' => fake()->country()
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Author $author) {
            /** @var BookFactory $factory */
            $factory = ElasticAwareFactoryGenerator::instance(Book::class);
            $factory->setOwner($author)->count(10)
                ->for($author)
                ->create();
        });
    }
}
