<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class);
    }
    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'carrera_id');
    }
}
