<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    public function index()
    {
        $imagenes = Imagen::all();
        $categorias = Categoria::all();
        return view('imagenes.index', compact('imagenes', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $ruta = $request->file('imagen')->store('imagenes', 'public');

        Imagen::create([
            'ruta' => $ruta,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('imagenes.index')->with('success', 'Imagen subida exitosamente');
    }
}
