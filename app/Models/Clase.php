<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clase extends Model
{
    use HasFactory;
    protected $table = 'clases';
    protected $fillable = [
        'clase',
    ];
    public function licencia(){
        return $this->hasMany(Licencia::class);
    }
}
