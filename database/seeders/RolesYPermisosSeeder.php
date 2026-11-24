<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesYPermisosSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permisos = [
            'estudiantes.ver',
            'estudiantes.crear',
            'estudiantes.editar',
            'estudiantes.eliminar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'administrador',
            'guard_name' => 'web',
        ]);

        $profesor = Role::firstOrCreate([
            'name' => 'profesor',
            'guard_name' => 'web',
        ]);

        $estudiante = Role::firstOrCreate([
            'name' => 'estudiante',
            'guard_name' => 'web',
        ]);

        $coordinador = Role::firstOrCreate([
            'name' => 'coordinador',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions($permisos);

        $profesor->syncPermissions([
            'estudiantes.ver',
            'estudiantes.editar',
        ]);

        $estudiante->syncPermissions([
            'estudiantes.ver',
        ]);

        $coordinador->syncPermissions([
            'estudiantes.ver',
            'estudiantes.editar',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
