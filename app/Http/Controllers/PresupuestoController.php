<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    public function reiniciarPresupuesto()
    {
        $presupuesto = Presupuesto::first();
        if ($presupuesto) {
            $presupuesto->monto = 0;
            $presupuesto->save();
        } else {
            Presupuesto::create(['monto' => 0]);
        }

        return redirect()->back()->with('status', 'Presupuesto reiniciado a 0');
    }

    public static function getPresupuesto()
    {
        return Presupuesto::first()->monto ?? 0;
    }
}
