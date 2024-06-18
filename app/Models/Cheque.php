<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    use HasFactory;

    protected $fillable = ['ncheque', 'monto', 'estado', 'item_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
