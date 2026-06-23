<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitorAuthController extends Controller
{
    /**
     * Muestra el formulario para ingresar el nombre de visitante.
     */
    public function showIdentificar()
    {
        if (session()->has('visitor_name')) {
            return redirect()->route('home');
        }
        return view('auth.identificarse');
    }

    /**
     * Guarda el nombre del visitante en la sesión.
     */
    public function identificar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        session(['visitor_name' => $request->nombre]);

        return redirect()->route('home')
            ->with('success', "Bienvenido/a, {$request->nombre}. Este espacio se ha personalizado para ti.");
    }

    /**
     * Elimina el nombre del visitante de la sesión.
     */
    public function salir(Request $request)
    {
        session()->forget('visitor_name');

        return redirect()->route('identificar')
            ->with('success', 'Sesión de visitante finalizada.');
    }
}
