<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Database\Seeder\AdminSeeder;
use App\Database\Seeder\TaskSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create();

        $this->call([
            AdminSeeder::class,
            TaskSeeder::Class,
        ]);
    }
}
