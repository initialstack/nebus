<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * List of seeders to be executed.
     *
     * @var array<string>
     */
    private array $seeders = [
        UserSeeder::class,
        BuildingSeeder::class,
        ActivitySeeder::class,
        OrganizationSeeder::class,
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            class: $this->seeders
        );
    }
}
