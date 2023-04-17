<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Colony;
use App\Models\Township;
use App\Models\Workplace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        DB::table('users')->insert(['curp' => 'GOPE011110HNEMNRA8', 'name' => 'ERICK JOSUE', 'paternal_surname' => 'GOMEZ', 'maternal_surname' => 'PINEDA', 'email' => 'ashgomez4@gmail.com', 'email_verified_at' => '2023-03-14 04:50:32', 'password' => Hash::make('Password'), 'colony_id' => '1', 'workplace_id' => '2',]);

        $this->call([
            RoleSeeder::class,
            WorkplaceSeeder::class,
            StateSeeder::class,
            TownshipSeeder::class,
            ColonySeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            ProposalStatesSeeder::class,
            AreasKnowledgeSeeder::class
            /*             CodigosPostalesSeeder::class
 */
        ]);

        User::find(1)->assignRole('Admin');
    }
}
