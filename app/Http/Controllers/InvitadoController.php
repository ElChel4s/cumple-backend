<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitado;
use App\Models\Configuracion;
use App\Models\Color;
use Illuminate\Http\JsonResponse;

class InvitadoController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate(['codigo_acceso' => 'required|string']);

        $invitado = Invitado::where('codigo_acceso', $request->codigo_acceso)->first();

        if (! $invitado) {
            return response()->json(['message' => 'Código inválido'], 401);
        }

        return response()->json($invitado);
    }

    public function confirmarAsistencia(Request $request, $id): JsonResponse
    {
        $request->validate(['asistencia' => 'required|in:pendiente,confirmado,rechazado']);

        $invitado = Invitado::find($id);
        if (! $invitado) {
            return response()->json(['message' => 'Invitado no encontrado'], 404);
        }

        $invitado->asistencia = $request->asistencia;
        $invitado->save();

        return response()->json($invitado);
    }

    public function obtenerTodos(): JsonResponse
    {
        $invitados = Invitado::with('color')
                              ->orderBy('nombre')
                              ->get();

        return response()->json($invitados);
    }

    public function obtenerConfirmados(): JsonResponse
    {
        $invitados = Invitado::where('asistencia', 'confirmado')
                              ->with('color')
                              ->orderBy('nombre')
                              ->get();

        return response()->json($invitados);
    }

    public function obtenerResultado($id): JsonResponse
    {
        $config = Configuracion::first();
        if (! $config || ! $config->sorteo_activo) {
            return response()->json(['message' => 'Sorteo no activo'], 403);
        }

        $invitado = Invitado::with('color')->find($id);
        if (! $invitado) {
            return response()->json(['message' => 'Invitado no encontrado'], 404);
        }

        return response()->json(['color' => $invitado->color]);
    }

    public function asignarColor($id): JsonResponse
    {
        $config = Configuracion::first();
        if (! $config || ! $config->sorteo_activo) {
            return response()->json(['message' => 'El sorteo aún no ha comenzado'], 403);
        }

        $invitado = Invitado::find($id);
        if (! $invitado) {
            return response()->json(['message' => 'Invitado no encontrado'], 404);
        }

        // Si ya tiene color asignado, retornarlo
        if ($invitado->color_id) {
            return response()->json($invitado->load('color'));
        }

        // Contar cuántos invitados ya tienen color asignado
        $totalAsignados = Invitado::whereNotNull('color_id')->count();

        // Primera ronda (invitados 1-10): Usar todos los 10 colores sin repetir
        if ($totalAsignados < 10) {
            // Obtener IDs de colores ya asignados
            $coloresUsados = Invitado::whereNotNull('color_id')->pluck('color_id')->toArray();
            
            // Buscar un color disponible de los 10, excluyendo los ya usados
            $color = Color::whereNotIn('id', $coloresUsados)
                          ->inRandomOrder()
                          ->first();

            if (! $color) {
                return response()->json(['message' => 'No hay colores disponibles'], 400);
            }
        } 
        // Segunda ronda en adelante (invitados 11+): Solo colores con prioridad 1-5
        else {
            // Calcular en qué posición de la ronda estamos (0-4)
            // Para invitados 11-15 será posición 0-4, para 16-20 será 0-4, etc.
            $posicionEnRonda = ($totalAsignados - 10) % 5;
            
            // Obtener los colores ya usados en esta ronda específica
            $coloresUsadosEnRonda = [];
            if ($posicionEnRonda > 0) {
                // Obtener todos los invitados con color asignado, ordenados por ID
                $todosLosInvitadosConColor = Invitado::whereNotNull('color_id')
                    ->orderBy('id')
                    ->pluck('color_id')
                    ->toArray();
                
                // Obtener solo los colores de la ronda actual (los últimos $posicionEnRonda después de los primeros 10)
                $coloresUsadosEnRonda = array_slice($todosLosInvitadosConColor, 10 + (floor(($totalAsignados - 10) / 5) * 5), $posicionEnRonda);
            }
            
            // Buscar un color con prioridad 1-5 que no se haya usado en esta ronda
            $color = Color::whereBetween('prioridad', [1, 5])
                          ->whereNotIn('id', $coloresUsadosEnRonda)
                          ->inRandomOrder()
                          ->first();

            if (! $color) {
                return response()->json(['message' => 'No hay colores disponibles'], 400);
            }
        }

        // Asignar el color al invitado
        $invitado->color_id = $color->id;
        $invitado->save();

        return response()->json($invitado->load('color'));
    }
}
 
