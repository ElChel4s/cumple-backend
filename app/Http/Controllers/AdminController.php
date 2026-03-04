<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Invitado;
use App\Models\Color;
use App\Models\Configuracion;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function crearInvitado(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string',
        ]);

        do {
            $letras = Str::upper(Str::random(3));
            $numeros = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $codigo = $letras . $numeros;
        } while (Invitado::where('codigo_acceso', $codigo)->exists());

        $invitado = Invitado::create([
            'nombre' => $request->nombre,
            'codigo_acceso' => $codigo,
            'asistencia' => 'pendiente',
        ]);

        return response()->json($invitado->load('color'), 201);
    }

    public function abrirSorteo(): JsonResponse
    {
        $config = Configuracion::first();
        if (! $config) {
            $config = Configuracion::create(['sorteo_activo' => true]);
        } else {
            $config->sorteo_activo = true;
            $config->save();
        }

        return response()->json(['message' => 'Botones habilitados para todos']);
    }
}
