<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table ='personal';
    protected $fillable = [
        'persona_id',
        'genero',
        'grado',
        'unidad_perteneciente',
        'area_perteneciente',
        'direccion',
        'telefono',
        'usuario',
        'password',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function registro(){
        return $this->hasMany(Registro::class);
    }

}
