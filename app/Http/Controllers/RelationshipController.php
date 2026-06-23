<?php

namespace App\Http\Controllers;

use App\Models\Cartas;
use App\Models\Momentos;
use App\Models\valores_compartidos;
use App\Models\Cancion;
use App\Models\respuestas;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    /**
     * Muestra la página de inicio/bienvenida con resumen de secciones.
     */
    public function index()
    {
        $totalCartas = Cartas::count();
        $totalMomentos = Momentos::count();
        $valores = valores_compartidos::all();
        $totalCanciones = Cancion::count();
        
        return view('welcome', compact('totalCartas', 'totalMomentos', 'valores', 'totalCanciones'));
    }

    /**
     * Muestra la sección de música.
     */
    public function musica()
    {
        $canciones = Cancion::orderBy('orden')->orderBy('created_at', 'desc')->get();
        return view('musica', compact('canciones'));
    }

    /**
     * Muestra el listado de cartas.
     */
    public function cartas()
    {
        // Traemos las cartas ordenadas por fecha descendente con sus respuestas
        $cartas = Cartas::with('respuestas')->orderBy('fecha', 'desc')->get();
        return view('cartas', compact('cartas'));
    }

    /**
     * Muestra la línea de tiempo de momentos especiales.
     */
    public function momentos()
    {
        $momentos = Momentos::orderBy('fecha', 'asc')->get();
        return view('momentos', compact('momentos'));
    }

    /**
     * Muestra un resumen de todas las respuestas.
     */
    public function respuestas()
    {
        $respuestas = respuestas::with('cartas')->orderBy('fecha', 'desc')->get();
        return view('respuestas', compact('respuestas'));
    }

    /**
     * Guarda una respuesta a una carta.
     */
    public function storeRespuesta(Request $request, $cartaId)
    {
        $hasSessionName = session()->has('visitor_name');

        $rules = [
            'comentario' => 'required|string|max:1000',
        ];

        if (!$hasSessionName) {
            $rules['nombre'] = 'required|string|max:100';
        }

        $request->validate($rules);

        $carta = Cartas::findOrFail($cartaId);

        if (!$hasSessionName) {
            session(['visitor_name' => $request->nombre]);
        }

        $nombre = session('visitor_name');

        respuestas::create([
            'carta_id' => $carta->id,
            'nombre' => $nombre,
            'comentario' => $request->comentario,
            'fecha' => now()->format('Y-m-d'),
        ]);

        // Marcar la carta como leída si recibe una respuesta
        if (!$carta->leida) {
            $carta->update(['leida' => true]);
        }

        return redirect()->route('cartas')->with('success', 'Tu respuesta ha sido guardada con cariño.');
    }

    /**
     * Marca una carta como leída por AJAX.
     */
    public function marcarLeida($id)
    {
        $carta = Cartas::findOrFail($id);
        if (!$carta->leida) {
            $carta->update(['leida' => true]);
            return response()->json(['success' => true, 'message' => 'Carta marcada como leída.']);
        }
        return response()->json(['success' => true, 'already_read' => true]);
    }

    /**
     * Guarda una canción agregada por un visitante.
     */
    public function storeCancion(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|string|max:255',
            'artista'      => 'nullable|string|max:255',
            'descripcion'  => 'nullable|string|max:500',
            'url_original' => 'required|string|max:1000',
        ]);

        $parsed = Cancion::parseUrl($request->url_original);

        if (!$parsed) {
            return back()->withErrors(['url_original' => 'El link no es válido. Usa un link de Spotify o YouTube.'])->withInput();
        }

        $nombre = session('visitor_name') ?? 'Visitante';

        Cancion::create([
            'titulo'       => $request->titulo,
            'artista'      => $request->artista,
            'descripcion'  => $request->descripcion,
            'url_original' => $request->url_original,
            'embed_url'    => $parsed['embed_url'],
            'plataforma'   => $parsed['plataforma'],
            'agregado_por' => $nombre,
            'orden'        => 0,
        ]);

        return redirect()->route('musica')->with('success', '¡Canción agregada con éxito!');
    }
}
