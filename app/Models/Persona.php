<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'personas';
    protected $fillable = [
        'dni',
        'nombre',
        'apellido_paterno',
        'apellido_materno'
    ];
    public function intervenido(){
        return $this->belongsTo(Intervenido::class);
    }

    public function unidad(){
        return $this->hasOne(Unidad::class);
    }

    public function personal()
    {
        return $this->hasOne(Personal::class);
    }
}
