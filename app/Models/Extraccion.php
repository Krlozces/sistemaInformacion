<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extraccion extends Model
{
    use HasFactory;
    protected $table = 'extraccion';
    protected $fillable = [
        'persona_id',
        'grado_id',
    ];

    public function registro(){
        return $this->hasMany(Registro::class);
    }
}
