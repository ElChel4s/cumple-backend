<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use Illuminate\Http\JsonResponse;

class ConfiguracionController extends Controller
{
    public function show(): JsonResponse
    {
        $config = Configuracion::first();
        return response()->json($config);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate(['sorteo_activo' => 'required|boolean']);

        $config = Configuracion::first();
        if (! $config) {
            $config = Configuracion::create(['sorteo_activo' => $request->sorteo_activo]);
        } else {
            $config->sorteo_activo = $request->sorteo_activo;
            $config->save();
        }

        return response()->json($config);
    }
}
