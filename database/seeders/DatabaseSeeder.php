<?php

namespace Database\Seeders;

use Zus1\Elasticsearch\ElasticSearch;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        private ElasticSearch $elasticSearch,
    ){
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->elasticSearch->createIndex(index: 'book');

        $this->call([
            AuthorSeeder::class,
        ]);
    }
}
