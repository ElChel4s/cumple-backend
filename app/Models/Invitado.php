<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitado extends Model
{
    protected $table = 'invitados';

    protected $fillable = [
        'nombre',
        'codigo_acceso',
        'asistencia',
        'color_id',
    ];

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}
