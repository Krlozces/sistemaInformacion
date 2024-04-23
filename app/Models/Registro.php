<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $table = 'registros';
    protected $fillable = [
        'recepcion_doc_referencia',
        'fecha_hora_infraccion',
        'fecha_hora_extraccion',
        'fecha',
        'hora',
        'motivo',
        'muestra_id',
        'intervenido_id',
        'comisaria_id',
        'extraccion_id',
        'usuario_id',
        'extractor',
        'procesador',
        'conclusiones'
    ];
    public function intervenido(){
        return $this->belongsTo(Intervenido::class);
    }

    public function extraccion(){
        return $this->belongsTo(Extraccion::class);
    }

    public function comisaria(){
        return $this->belongsTo(Comisaria::class);
    }

    public function muestra(){
        return $this->hasOne(Muestra::class, 'id');
    }

    public function persona(){
        return $this->belongsTo(Personal::class);
    }
}
