<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfil = Role::where('name', 'Admin')->first();
/*         $cap = Role::where('name', 'Captura')->first();
 */
        // Cobertura de visibilidad completa
        $perfil->givePermissionTo(Permission::where('module_key', 'modulo')->get());
        $perfil->givePermissionTo(Permission::where('module_key', 'cat')->get());

       /*  $cap->givePermissionTo(Permission::where('name', 'modulo.catalogos')->get());
        $cap->givePermissionTo(Permission::where('name', 'convocatoria.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'evento.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'calendario.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'modulo.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'permissions.index')->get()); */
    }
}
