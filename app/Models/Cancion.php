<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancion extends Model
{
    protected $table = 'canciones';

    protected $fillable = [
        'titulo',
        'artista',
        'descripcion',
        'url_original',
        'embed_url',
        'plataforma',
        'agregado_por',
        'orden',
    ];

    /**
     * Parsea una URL/URI de Spotify o YouTube y retorna un array con
     * ['embed_url' => '...', 'plataforma' => 'spotify'|'youtube']
     * Retorna null si la URL no es reconocida.
     *
     * Formatos Spotify soportados:
     *   https://open.spotify.com/track/ID
     *   https://open.spotify.com/track/ID?si=...
     *   https://spotify.link/XXXX  (links cortos)
     *   spotify:track:ID           (URI de la app movil)
     *   spotify:playlist:ID
     *
     * Formatos YouTube soportados:
     *   https://youtu.be/ID
     *   https://youtu.be/ID?si=...
     *   https://www.youtube.com/watch?v=ID
     *   https://youtube.com/watch?v=ID&t=...
     *   https://www.youtube.com/embed/ID
     *   https://music.youtube.com/watch?v=ID
     */
    public static function parseUrl(string $url): ?array
    {
        $url = trim($url);

        // Spotify URI (app movil): spotify:track:ID
        if (preg_match('#^spotify:(track|playlist|album|artist|episode):([A-Za-z0-9]+)#i', $url, $m)) {
            $type = strtolower($m[1]);
            $id   = $m[2];
            return [
                'embed_url'  => "https://open.spotify.com/embed/{$type}/{$id}?utm_source=generator&theme=0",
                'plataforma' => 'spotify',
            ];
        }

        // Spotify web / open.spotify.com / spotify.link
        if (str_contains($url, 'spotify.com') || str_contains($url, 'spotify.link')) {
            // Si es un link acortado de spotify.link, intentamos resolver la redirección
            if (str_contains($url, 'spotify.link')) {
                try {
                    $headers = @get_headers($url, 1);
                    if ($headers) {
                        $location = $headers['Location'] ?? $headers['location'] ?? null;
                        if ($location) {
                            $resolvedUrl = is_array($location) ? end($location) : $location;
                            if ($resolvedUrl) {
                                $url = $resolvedUrl;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Continuar con la URL original
                }
            }

            // Formato: /track/ID, /playlist/ID, /album/ID, /artist/ID, /episode/ID
            if (preg_match('#(track|playlist|album|artist|episode)/([A-Za-z0-9]+)#i', $url, $m)) {
                $type = strtolower($m[1]);
                $id   = $m[2];
                return [
                    'embed_url'  => "https://open.spotify.com/embed/{$type}/{$id}?utm_source=generator&theme=0",
                    'plataforma' => 'spotify',
                ];
            }
            return null;
        }

        // YouTube
        if (
            str_contains($url, 'youtube.com') ||
            str_contains($url, 'youtu.be')    ||
            str_contains($url, 'music.youtube.com')
        ) {
            $videoId = null;

            // youtu.be/ID
            if (preg_match('#youtu\.be/([A-Za-z0-9_\-]{11})#', $url, $m)) {
                $videoId = $m[1];
            }
            // youtube.com/watch?v=ID
            elseif (preg_match('#[?&]v=([A-Za-z0-9_\-]{11})#', $url, $m)) {
                $videoId = $m[1];
            }
            // youtube.com/embed/ID
            elseif (preg_match('#/embed/([A-Za-z0-9_\-]{11})#', $url, $m)) {
                $videoId = $m[1];
            }
            // youtube.com/shorts/ID
            elseif (preg_match('#/shorts/([A-Za-z0-9_\-]{11})#', $url, $m)) {
                $videoId = $m[1];
            }

            if ($videoId) {
                return [
                    'embed_url'  => "https://www.youtube.com/embed/{$videoId}?rel=0&modestbranding=1",
                    'plataforma' => 'youtube',
                ];
            }
            return null;
        }

        return null;
    }
}
