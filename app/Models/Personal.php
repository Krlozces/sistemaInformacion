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
        'grado_id',
        'certificado_id',
        'unidad_perteneciente',
        'area_perteneciente',
        'direccion',
        'telefono',
        'usuario',
        'password',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function registro(){
        return $this->hasMany(Registro::class);
    }

    public function grado(){
        return $this->belongsTo(Grado::class);
    }

    public function certificado(){
        return $this->belongsTo(Certificado::class,'certificado_id');
    }
}
