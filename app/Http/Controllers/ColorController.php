<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use Illuminate\Http\JsonResponse;

class ColorController extends Controller
{
    public function index(): JsonResponse
    {
        $colors = Color::orderBy('prioridad', 'desc')->get();
        return response()->json($colors);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string',
            'hex' => 'nullable|string',
            'prioridad' => 'nullable|integer',
        ]);

        $color = Color::create($request->only(['nombre','hex','prioridad']));
        return response()->json($color, 201);
    }
}
