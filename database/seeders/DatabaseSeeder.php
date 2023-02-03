<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Colony;
use App\Models\Township;
use App\Models\Workplace;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            WorkplaceSeeder::class,
            StateSeeder::class,
            TownshipSeeder::class,
            ColonySeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            CodigosPostalesSeeder::class
        ]);
    }
}
