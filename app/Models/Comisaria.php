<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comisaria extends Model
{
    use HasFactory;
    protected $table = 'comisarias';
    protected $fillable = [
        'procedencia',
    ];
    public function unidades(){
        return $this->hasMany(Unidad::class);
    }

    public function registro(){
        return $this->hasMany(Registro::class);
    }
}
