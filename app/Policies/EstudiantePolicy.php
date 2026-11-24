<?php

namespace App\Policies;

use App\Models\Estudiante;
use App\Models\User;

class EstudiantePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('estudiantes.ver');
    }

    public function view(User $user, Estudiante $estudiante): bool
    {
        if (!$user->can('estudiantes.ver')) {
            return false;
        }

        // El administrador puede consultar cualquier registro.
        if ($user->hasRole('administrador')) {
            return true;
        }

        // El estudiante solo puede consultar su propio registro.
        if ($user->hasRole('estudiante')) {
            if (!$estudiante->activo && $estudiante->user_id !== $user->id) {
                return false;
            }

            return $estudiante->user_id === $user->id;
        }

        // Profesores y coordinadores consultan su misma carrera.
        if ($user->hasAnyRole(['profesor', 'coordinador'])) {
            return $user->carrera_id !== null
                && $user->carrera_id === $estudiante->carrera_id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->can('estudiantes.crear');
    }

    public function update(User $user, Estudiante $estudiante): bool
    {
        if (!$user->can('estudiantes.editar')) {
            return false;
        }

        // El administrador puede modificar cualquier estudiante.
        if ($user->hasRole('administrador')) {
            return true;
        }

        // ABAC: misma carrera y misma sede.
        if ($user->hasAnyRole(['profesor', 'coordinador'])) {
            return $user->carrera_id !== null
                && $user->carrera_id === $estudiante->carrera_id
                && $user->sede_id !== null
                && $user->sede_id === $estudiante->usuario?->sede_id;
        }

        return false;
    }

    public function delete(User $user, Estudiante $estudiante): bool
    {
        return $user->can('estudiantes.eliminar');
    }
}
