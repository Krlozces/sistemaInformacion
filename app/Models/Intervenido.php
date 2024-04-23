<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervenido extends Model
{
    use HasFactory;
    protected $table = 'intervenidos';
    protected $fillable = [
        'persona_id',
        'nacionalidad',
        'edad',
        'sexo'
    ];
    public function licencia() {
        return $this->hasMany(Licencia::class);
    }

    public function registro(){
        return $this->hasMany(Registro::class);
    }

    public function persona(){
        return $this->hasOne(Persona::class);
    }
}
