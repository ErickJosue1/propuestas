<?php

namespace Database\Seeders;

use App\Models\Institutions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Institutions::create(['name' => 'modulo.catalogos', 'guard_name' => 'web', 'description' => 'Catálogos del Sistema', 'module_key' => 'modulo']);
    }
}
