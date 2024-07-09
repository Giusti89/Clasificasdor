<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teconomica extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'npartida',
        'presupuesto',        
    ];
    
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }

    public function peconomicas()
    {
        return $this->hasMany(Peconomica::class);
    }
}
