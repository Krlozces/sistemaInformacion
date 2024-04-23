<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    protected $table = 'unidades';
    protected $fillable = [
        'persona',
        'procedencia_id',
    ];

    public function comisaria(){
        return $this->belongsTo(Comisaria::class);
    }

    public function persona(){
        return $this->belongsTo(Persona::class);
    }
}
