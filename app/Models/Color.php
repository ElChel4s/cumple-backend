<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'nombre',
        'hex',
        'prioridad',
    ];

    public function invitados(): HasMany
    {
        return $this->hasMany(Invitado::class);
    }
}
