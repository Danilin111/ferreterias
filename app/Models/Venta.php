<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'cantidad',
        'total',
    ];
    // Modelo Venta
    


    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
