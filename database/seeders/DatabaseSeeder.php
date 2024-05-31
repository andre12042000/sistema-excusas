<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $role =  Role::create(['name' => 'Coordinador']);
        $role->permissions()->attach([1,2,3,4]);

        $role = Role::create(['name' => 'Profesor']);
        $role->permissions()->attach([2]);

        $role = Role::create(['name' => 'Padre']);
        $role->permissions()->attach([]);

        $user = User::create([
            'name'                    => 'Wilmer Andres Sandoval Sandoval',
            'email'                   => 'andresandoval124@gmail.com',
            'password'                => bcrypt('123456789'),
            'telefono'                => '3134182778',
            'direccion'               => 'calle 5A #4-18',
            'numero_identificacion'   => '1006415417',
        ]);
        $user->assignRole('Coordinador');
    }
}
