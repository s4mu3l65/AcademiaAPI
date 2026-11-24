<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
    ];

    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
