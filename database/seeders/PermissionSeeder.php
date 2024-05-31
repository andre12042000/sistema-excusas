<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Autorización Excusas',
        ]);
        Permission::create([
            'name' => 'Excusas Aprovadas',
        ]);

        Permission::create([
            'name' => 'Administración Estudiantes',
        ]);
        Permission::create([
            'name' => 'Configuración Seguridad',
        ]);



    }
}
