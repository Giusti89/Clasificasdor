<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peconomica extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion', 'npartida', 'detalle', 'monto'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
