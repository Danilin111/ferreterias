<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto',
        'cantidad',
        'precio',
        'total',
        'fecha_estimada_pago',
    ];
}
