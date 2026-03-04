<?php

/**
 * Script de prueba para verificar la lógica de asignación de colores
 * 
 * Simula la asignación de colores a 20 invitados para verificar:
 * - Primeros 10: reciben los 10 colores sin repetirse
 * - Siguientes 5 (11-15): reciben colores de prioridad 1-5 sin repetirse
 * - Siguientes 5 (16-20): reciben colores de prioridad 1-5 sin repetirse
 */

// Simulación de la lógica
$coloresPrioridad15 = [1, 2, 3, 4, 5]; // IDs de colores con prioridad 1-5
$todoColores = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; // Todos los colores
$asignaciones = [];

echo "=== SIMULACIÓN DE ASIGNACIÓN DE COLORES ===\n\n";

// Simular asignación para 20 invitados
for ($invitadoNum = 1; $invitadoNum <= 20; $invitadoNum++) {
    $totalAsignados = count($asignaciones);
    
    echo "Invitado #$invitadoNum (Total asignados antes: $totalAsignados):\n";
    
    // Primera ronda (invitados 1-10)
    if ($totalAsignados < 10) {
        echo "  -> PRIMERA RONDA (usando todos los 10 colores)\n";
        
        // Obtener colores ya usados
        $coloresUsados = $asignaciones;
        
        // Obtener colores disponibles
        $coloresDisponibles = array_diff($todoColores, $coloresUsados);
        
        if (empty($coloresDisponibles)) {
            echo "  ERROR: No hay colores disponibles!\n";
            break;
        }
        
        // Asignar color aleatorio de los disponibles
        $colorAsignado = $coloresDisponibles[array_rand($coloresDisponibles)];
        $asignaciones[] = $colorAsignado;
        
        echo "  ✓ Color asignado: $colorAsignado\n";
        echo "  ✓ Colores usados en esta ronda: " . implode(', ', $asignaciones) . "\n";
    } 
    // Segunda ronda en adelante (invitados 11+)
    else {
        echo "  -> RONDAS SIGUIENTES (solo colores prioridad 1-5)\n";
        
        // Calcular posición en la ronda (0-4)
        $posicionEnRonda = ($totalAsignados - 10) % 5;
        $numeroRonda = floor(($totalAsignados - 10) / 5) + 2;
        
        echo "  -> Ronda #$numeroRonda, posición: $posicionEnRonda\n";
        
        // Obtener colores usados en esta ronda específica
        $coloresUsadosEnRonda = [];
        if ($posicionEnRonda > 0) {
            $inicioRonda = 10 + (floor(($totalAsignados - 10) / 5) * 5);
            $coloresUsadosEnRonda = array_slice($asignaciones, $inicioRonda, $posicionEnRonda);
        }
        
        // Obtener colores disponibles (prioridad 1-5 que no estén usados en esta ronda)
        $coloresDisponibles = array_diff($coloresPrioridad15, $coloresUsadosEnRonda);
        
        if (empty($coloresDisponibles)) {
            echo "  ERROR: No hay colores disponibles!\n";
            break;
        }
        
        // Asignar color aleatorio de los disponibles
        $colorAsignado = $coloresDisponibles[array_rand($coloresDisponibles)];
        $asignaciones[] = $colorAsignado;
        
        echo "  ✓ Color asignado: $colorAsignado\n";
        echo "  ✓ Colores usados en esta ronda: " . implode(', ', $coloresUsadosEnRonda) . " + $colorAsignado\n";
    }
    
    echo "\n";
}

echo "\n=== RESUMEN FINAL ===\n\n";
echo "Total de invitados procesados: " . count($asignaciones) . "\n\n";

echo "Primera ronda (invitados 1-10):\n";
for ($i = 0; $i < 10 && $i < count($asignaciones); $i++) {
    echo "  Invitado " . ($i + 1) . ": Color " . $asignaciones[$i] . "\n";
}

$coloresUnicos = array_unique(array_slice($asignaciones, 0, 10));
echo "  -> Colores únicos usados: " . count($coloresUnicos) . "/10\n";
echo "  -> ✓ " . (count($coloresUnicos) == 10 ? "CORRECTO: Se usaron todos los colores sin repetir" : "ERROR: No se usaron todos los colores") . "\n\n";

if (count($asignaciones) > 10) {
    echo "Segunda ronda (invitados 11-15):\n";
    for ($i = 10; $i < 15 && $i < count($asignaciones); $i++) {
        echo "  Invitado " . ($i + 1) . ": Color " . $asignaciones[$i] . "\n";
    }
    $coloresUnicos = array_unique(array_slice($asignaciones, 10, 5));
    echo "  -> Colores únicos usados: " . count($coloresUnicos) . "/5\n";
    
    // Verificar que solo se usaron colores de prioridad 1-5
    $coloresRonda2 = array_slice($asignaciones, 10, 5);
    $todosEnRango = true;
    foreach ($coloresRonda2 as $color) {
        if (!in_array($color, $coloresPrioridad15)) {
            $todosEnRango = false;
            break;
        }
    }
    echo "  -> ✓ " . ($todosEnRango && count($coloresUnicos) == 5 ? "CORRECTO: Se usaron solo colores 1-5 sin repetir" : "ERROR: Problemas con los colores") . "\n\n";
}

if (count($asignaciones) > 15) {
    echo "Tercera ronda (invitados 16-20):\n";
    for ($i = 15; $i < 20 && $i < count($asignaciones); $i++) {
        echo "  Invitado " . ($i + 1) . ": Color " . $asignaciones[$i] . "\n";
    }
    $coloresUnicos = array_unique(array_slice($asignaciones, 15, 5));
    echo "  -> Colores únicos usados: " . count($coloresUnicos) . "/5\n";
    
    // Verificar que solo se usaron colores de prioridad 1-5
    $coloresRonda3 = array_slice($asignaciones, 15, 5);
    $todosEnRango = true;
    foreach ($coloresRonda3 as $color) {
        if (!in_array($color, $coloresPrioridad15)) {
            $todosEnRango = false;
            break;
        }
    }
    echo "  -> ✓ " . ($todosEnRango && count($coloresUnicos) == 5 ? "CORRECTO: Se usaron solo colores 1-5 sin repetir" : "ERROR: Problemas con los colores") . "\n\n";
}

echo "\nAll invitados asignaciones: " . implode(', ', $asignaciones) . "\n";
