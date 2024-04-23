<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    use HasFactory;
    protected $table = 'muestras';
    protected $fillable = [
        'fecha_muestra',
        'descripcion',
        'observaciones',
        'resultado_cualitativo', 
        'resultado_cuantitativo',
        'hora_muestra',
        'metodo_id'
    ];
    public function registro(){
        return $this->belongsTo(Registro::class, 'muestra_id');
    }

    public function metodos(){
        return $this->belongsTo(Metodo::class);
    }
}
