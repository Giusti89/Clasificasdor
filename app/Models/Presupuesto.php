<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = ['monto', 'carrera_id'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
    
}
