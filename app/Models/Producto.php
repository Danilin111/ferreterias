<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'valor_neto', 
        'precio_venta', 
        'porcentaje_ganancia', 
        'cantidad_en_stock'
    ];
        
    public function ganancia()

    {
        return $this->precio_venta - $this->valor_neto;
    }

    public function ventas()
    
    {
        return $this->hasMany(Venta::class);
    }
}
