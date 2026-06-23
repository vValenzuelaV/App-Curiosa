<?php

namespace App\Http\Controllers;

use App\Models\Cartas;
use App\Models\Momentos;
use App\Models\valores_compartidos;
use App\Models\Cancion;
use App\Models\respuestas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // ==========================================
    // GESTIÓN DE CARTAS
    // ==========================================

    /**
     * Guarda una nueva carta.
     */
    public function storeCarta(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha' => 'required|date',
        ]);

        Cartas::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha' => $request->fecha,
            'leida' => false,
        ]);

        return redirect()->route('cartas')->with('success', 'Carta guardada con éxito.');
    }

    /**
     * Actualiza una carta existente.
     */
    public function updateCarta(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha' => 'required|date',
        ]);

        $carta = Cartas::findOrFail($id);
        $carta->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('cartas')->with('success', 'Carta actualizada con éxito.');
    }

    /**
     * Elimina una carta.
     */
    public function destroyCarta($id)
    {
        $carta = Cartas::findOrFail($id);
        
        // Primero eliminar las respuestas asociadas para evitar errores de integridad
        $carta->respuestas()->delete();
        $carta->delete();

        return redirect()->route('cartas')->with('success', 'Carta eliminada con éxito.');
    }


    // ==========================================
    // GESTIÓN DE MOMENTOS
    // ==========================================

    /**
     * Guarda un nuevo momento especial.
     */
    public function storeMomento(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120', // máx 5MB
        ]);

        $filename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            // Asegurar que la carpeta public/images exista
            if (!File::isDirectory(public_path('images'))) {
                File::makeDirectory(public_path('images'), 0755, true, true);
            }
            $file->move(public_path('images'), $filename);
        }

        Momentos::create([
            'titulo' => $request->titulo,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'foto' => $filename,
        ]);

        return redirect()->route('momentos')->with('success', 'Momento guardado con éxito.');
    }

    /**
     * Actualiza un momento existente.
     */
    public function updateMomento(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $momento = Momentos::findOrFail($id);
        $filename = $momento->foto;

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($momento->foto && File::exists(public_path('images/' . $momento->foto))) {
                File::delete(public_path('images/' . $momento->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            if (!File::isDirectory(public_path('images'))) {
                File::makeDirectory(public_path('images'), 0755, true, true);
            }
            $file->move(public_path('images'), $filename);
        }

        $momento->update([
            'titulo' => $request->titulo,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'foto' => $filename,
        ]);

        return redirect()->route('momentos')->with('success', 'Momento actualizado con éxito.');
    }

    /**
     * Elimina un momento.
     */
    public function destroyMomento($id)
    {
        $momento = Momentos::findOrFail($id);

        // Eliminar foto del almacenamiento
        if ($momento->foto && File::exists(public_path('images/' . $momento->foto))) {
            File::delete(public_path('images/' . $momento->foto));
        }

        $momento->delete();

        return redirect()->route('momentos')->with('success', 'Momento eliminado con éxito.');
    }


    // ==========================================
    // GESTIÓN DE COMPROMISOS (VALORES COMPARTIDOS)
    // ==========================================

    /**
     * Guarda un nuevo compromiso.
     */
    public function storeValor(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'icono'  => 'nullable|string|max:10',
            'descripcion' => 'required|string',
        ]);

        valores_compartidos::create([
            'titulo'      => $request->titulo,
            'icono'       => $request->icono ?: '✦',
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('home')->with('success', 'Compromiso agregado con éxito.');
    }

    /**
     * Actualiza un compromiso existente.
     */
    public function updateValor(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'icono'  => 'nullable|string|max:10',
            'descripcion' => 'required|string',
        ]);

        $valor = valores_compartidos::findOrFail($id);
        $valor->update([
            'titulo'      => $request->titulo,
            'icono'       => $request->icono ?: '✦',
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('home')->with('success', 'Compromiso actualizado con éxito.');
    }

    /**
     * Elimina un compromiso.
     */
    public function destroyValor($id)
    {
        $valor = valores_compartidos::findOrFail($id);
        $valor->delete();

        return redirect()->route('home')->with('success', 'Compromiso eliminado con éxito.');
    }

    // ==========================================
    // GESTIÓN DE CANCIONES
    // ==========================================

    /**
     * Guarda una nueva canción.
     */
    public function storeCancion(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|string|max:255',
            'artista'     => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'url_original' => 'required|string|max:1000',
            'orden'       => 'nullable|integer',
        ]);

        $parsed = Cancion::parseUrl($request->url_original);

        if (!$parsed) {
            return back()->withErrors(['url_original' => 'El link no es válido. Usa un link de Spotify o YouTube.'])->withInput();
        }

        Cancion::create([
            'titulo'       => $request->titulo,
            'artista'      => $request->artista,
            'descripcion'  => $request->descripcion,
            'url_original' => $request->url_original,
            'embed_url'    => $parsed['embed_url'],
            'plataforma'   => $parsed['plataforma'],
            'agregado_por' => 'Admin',
            'orden'        => $request->orden ?? 0,
        ]);

        return redirect()->route('musica')->with('success', 'Canción agregada con éxito.');
    }

    /**
     * Actualiza una canción existente.
     */
    public function updateCancion(Request $request, $id)
    {
        $request->validate([
            'titulo'      => 'required|string|max:255',
            'artista'     => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'url_original' => 'required|string|max:1000',
            'orden'       => 'nullable|integer',
        ]);

        $cancion = Cancion::findOrFail($id);
        $parsed = Cancion::parseUrl($request->url_original);

        if (!$parsed) {
            return back()->withErrors(['url_original' => 'El link no es válido. Usa un link de Spotify o YouTube.'])->withInput();
        }

        $cancion->update([
            'titulo'       => $request->titulo,
            'artista'      => $request->artista,
            'descripcion'  => $request->descripcion,
            'url_original' => $request->url_original,
            'embed_url'    => $parsed['embed_url'],
            'plataforma'   => $parsed['plataforma'],
            'agregado_por' => $cancion->agregado_por ?? 'Admin',
            'orden'        => $request->orden ?? 0,
        ]);

        return redirect()->route('musica')->with('success', 'Canción actualizada con éxito.');
    }

    /**
     * Elimina una canción.
     */
    public function destroyCancion($id)
    {
        $cancion = Cancion::findOrFail($id);
        $cancion->delete();

        return redirect()->route('musica')->with('success', 'Canción eliminada con éxito.');
    }


    // ==========================================
    // GESTIÓN DE RESPUESTAS (ADMIN)
    // ==========================================

    /**
     * Actualiza una respuesta.
     */
    public function updateRespuesta(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:1000',
        ]);

        $respuesta = respuestas::findOrFail($id);
        $respuesta->update([
            'comentario' => $request->comentario,
        ]);

        return redirect()->back()->with('success', 'Respuesta actualizada con éxito.');
    }

    /**
     * Elimina una respuesta.
     */
    public function destroyRespuesta($id)
    {
        $respuesta = respuestas::findOrFail($id);
        $respuesta->delete();

        return redirect()->back()->with('success', 'Respuesta eliminada con éxito.');
    }
}
