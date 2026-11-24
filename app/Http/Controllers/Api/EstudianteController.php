<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class EstudianteController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Estudiante::class);

        return Estudiante::with(['carrera', 'usuario'])
            ->paginate(10);
    }

    public function show(Estudiante $estudiante)
    {
        Gate::authorize('view', $estudiante);

        return $estudiante->load(['carrera', 'usuario']);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Estudiante::class);

        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'unique:estudiantes,user_id'],
            'carrera_id' => ['required', 'exists:carreras,id'],
            'cedula' => ['required', 'string', 'max:30', 'unique:estudiantes,cedula'],
            'nombre' => ['required', 'string', 'max:120'],
            'apellido' => ['required', 'string', 'max:120'],
            'correo_institucional' => ['required', 'email', 'max:150', 'unique:estudiantes,correo_institucional'],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $estudiante = Estudiante::create($data);

        return response()->json($estudiante, 201);
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        Gate::authorize('update', $estudiante);

        $data = $request->validate([
            'carrera_id' => ['sometimes', 'exists:carreras,id'],
            'cedula' => [
                'sometimes',
                'string',
                'max:30',
                Rule::unique('estudiantes', 'cedula')->ignore($estudiante->id),
            ],
            'nombre' => ['sometimes', 'string', 'max:120'],
            'apellido' => ['sometimes', 'string', 'max:120'],
            'correo_institucional' => [
                'sometimes',
                'email',
                'max:150',
                Rule::unique('estudiantes', 'correo_institucional')->ignore($estudiante->id),
            ],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $estudiante->update($data);

        return response()->json($estudiante);
    }

    public function destroy(Estudiante $estudiante)
    {
        Gate::authorize('delete', $estudiante);

        $estudiante->delete();

        return response()->json([
            'message' => 'Estudiante eliminado correctamente',
        ]);
    }
}
