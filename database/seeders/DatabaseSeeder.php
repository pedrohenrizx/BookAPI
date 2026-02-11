<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ordem dos seeders é importante devido aos relacionamentos
        $this->call([
            PublisherSeeder::class,
            AuthorSeeder::class,
            ThemeSeeder::class,
            BookSeeder::class,
            UserSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}