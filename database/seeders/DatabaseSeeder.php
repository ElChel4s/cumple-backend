<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Configuracion;
use App\Models\Invitado;
use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password')
            ]
        );

        // Crear configuración inicial con sorteo desactivado
        Configuracion::firstOrCreate(
            ['id' => 1],
            ['sorteo_activo' => false]
        );

        // Crear colores
        $colores = [
            ['nombre' => 'Rojo', 'hex' => '#FF0000', 'prioridad' => 1],
            ['nombre' => 'Amarillo', 'hex' => '#FFFF00', 'prioridad' => 2],
            ['nombre' => 'Blanco', 'hex' => '#FFFFFF', 'prioridad' => 3],
            ['nombre' => 'Verde', 'hex' => '#00FF00', 'prioridad' => 4],
            ['nombre' => 'Naranja', 'hex' => '#FFA500', 'prioridad' => 5],
            ['nombre' => 'Café', 'hex' => '#8B4513', 'prioridad' => 6],
            ['nombre' => 'Morado', 'hex' => '#800080', 'prioridad' => 7],
            ['nombre' => 'Azul', 'hex' => '#0000FF', 'prioridad' => 8],
            ['nombre' => 'Rosa', 'hex' => '#FFC0CB', 'prioridad' => 9],
            ['nombre' => 'Negro', 'hex' => '#000000', 'prioridad' => 10],
        ];

        foreach ($colores as $color) {
            Color::firstOrCreate(
                ['nombre' => $color['nombre']],
                ['hex' => $color['hex'], 'prioridad' => $color['prioridad']]
            );
        }

        // Crear invitados
        $invitados = [
            ['nombre' => 'Marcelo (Yo)', 'codigo_acceso' => 'MAR721', 'asistencia' => 'confirmado'],
            ['nombre' => 'Edely', 'codigo_acceso' => 'EDE452', 'asistencia' => 'pendiente'],
            ['nombre' => 'Grover', 'codigo_acceso' => 'GRO129', 'asistencia' => 'pendiente'],
            ['nombre' => 'Pablo', 'codigo_acceso' => 'PAB883', 'asistencia' => 'pendiente'],
            ['nombre' => 'Leandro', 'codigo_acceso' => 'LEA347', 'asistencia' => 'pendiente'],
            ['nombre' => 'Camila', 'codigo_acceso' => 'CAM912', 'asistencia' => 'pendiente'],
            ['nombre' => 'Diana', 'codigo_acceso' => 'DIA556', 'asistencia' => 'pendiente'],
            ['nombre' => 'Carlos', 'codigo_acceso' => 'CAR204', 'asistencia' => 'pendiente'],
            ['nombre' => 'Edgar', 'codigo_acceso' => 'EDG678', 'asistencia' => 'pendiente'],
            ['nombre' => 'Maya', 'codigo_acceso' => 'MAY331', 'asistencia' => 'pendiente'],
            ['nombre' => 'Masiel', 'codigo_acceso' => 'MAS890', 'asistencia' => 'pendiente'],
            ['nombre' => 'Jordy', 'codigo_acceso' => 'JOR442', 'asistencia' => 'pendiente'],
            ['nombre' => 'Aren', 'codigo_acceso' => 'ARE115', 'asistencia' => 'pendiente'],
            ['nombre' => 'Brian', 'codigo_acceso' => 'BRI903', 'asistencia' => 'pendiente'],
            ['nombre' => 'Neytan', 'codigo_acceso' => 'NEY227', 'asistencia' => 'pendiente'],
            ['nombre' => 'Luis', 'codigo_acceso' => 'LUI518', 'asistencia' => 'pendiente'],
            ['nombre' => 'Mariana', 'codigo_acceso' => 'MAR664', 'asistencia' => 'pendiente'],
            ['nombre' => 'Cristian', 'codigo_acceso' => 'CRI739', 'asistencia' => 'pendiente'],
            ['nombre' => 'Sam', 'codigo_acceso' => 'SAM102', 'asistencia' => 'pendiente'],
        ];

        foreach ($invitados as $invitado) {
            Invitado::firstOrCreate(
                ['codigo_acceso' => $invitado['codigo_acceso']],
                [
                    'nombre' => $invitado['nombre'],
                    'asistencia' => $invitado['asistencia'],
                    'color_id' => null,
                ]
            );
        }
    }
}
