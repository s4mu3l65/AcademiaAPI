<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';        // Persona 2: login, registro, me, logout, dashboard
require __DIR__.'/estudiantes.php'; // Persona 5: CRUD de estudiantes

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
