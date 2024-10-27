<?php

class Factura extends Model
{
    protected $fillable = ['fecha'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class)->withPivot('cantidad');
    }
}

