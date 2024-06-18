<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion', 'costo', 'puntaje', 'cantidad', 'imagen_url', 'requerimiento_id', 'peconomica_id'];

    public function requerimiento()
    {
        return $this->belongsTo(Requerimiento::class);
    }

    public function peconomica()
    {
        return $this->belongsTo(Peconomica::class);
    }

    public function cheques()
    {
        return $this->hasMany(Cheque::class);
    }
}
