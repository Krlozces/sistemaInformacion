<?php

namespace App\Models;

use App\Models\Clase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Licencia extends Model
{
    use HasFactory;
    protected $table = 'licencias';

    protected $fillable = [
        'placa',
        'vehiculo',
        'categoria',
        'licencia',
        'intervenido_id',
        'clase_id',
    ];
    public function clase() {
        return $this->belongsTo(Clase::class);
    }

    public function intervenido(){
        return $this->belongsTo(Intervenido::class);
    }
}
