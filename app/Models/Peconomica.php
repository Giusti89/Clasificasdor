<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peconomica extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'npartida',
        'descripcion',
        'monto',
        'teconomica_id'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function teconomica()
    {
        return $this->belongsTo(Teconomica::class);
    }
}
