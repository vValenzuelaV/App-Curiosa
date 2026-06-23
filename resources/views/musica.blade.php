@extends('layouts.app')

@section('styles')
    <style>
        /* ── ANIMACIÓN ENTRADA ── */
        .musica-container {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.9s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── HERO ── */
        .musica-hero {
            text-align: center;
            padding: 2.5rem 1rem 3rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 3.5rem;
        }

        .musica-hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            font-weight: 300;
            font-style: italic;
            color: var(--text-main);
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .musica-hero-subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .musica-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 1.25rem auto 0;
        }

        .musica-divider::before,
        .musica-divider::after {
            content: '';
            height: 1px;
            width: 50px;
            background-color: var(--accent-gold);
        }

        /* ── GRID ── */
        .canciones-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.75rem;
            margin-bottom: 4rem;
        }

        /* ── CARD ── */
        .cancion-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
            /* entrada escalonada */
            opacity: 0;
            transform: translateY(16px);
            animation: cardIn 0.6s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        .cancion-card:nth-child(1) {
            animation-delay: 0.10s;
        }

        .cancion-card:nth-child(2) {
            animation-delay: 0.18s;
        }

        .cancion-card:nth-child(3) {
            animation-delay: 0.26s;
        }

        .cancion-card:nth-child(4) {
            animation-delay: 0.34s;
        }

        .cancion-card:nth-child(5) {
            animation-delay: 0.42s;
        }

        .cancion-card:nth-child(6) {
            animation-delay: 0.50s;
        }

        .cancion-card:nth-child(n+7) {
            animation-delay: 0.55s;
        }

        @keyframes cardIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cancion-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow-hover);
            border-color: var(--accent-gold);
        }

        /* ── BARRA DE COLOR POR PLATAFORMA ── */
        .cancion-card.spotify {
            --plat-color: #5E8C6A;
        }

        .cancion-card.youtube {
            --plat-color: #B0857D;
        }

        .cancion-card::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--plat-color, var(--accent-gold)), var(--accent-gold));
            flex-shrink: 0;
        }

        /* ── CUERPO DE LA CARD ── */
        .cancion-body {
            padding: 1.6rem 1.75rem 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .cancion-plataforma-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--plat-color, var(--accent-gold));
            margin-bottom: 0.25rem;
        }

        .cancion-plataforma-badge svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        .cancion-titulo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-main);
            line-height: 1.25;
        }

        .cancion-artista {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-style: italic;
        }

        .cancion-descripcion {
            font-size: 0.84rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-top: 0.5rem;
            flex: 1;
        }

        .cancion-agregado-por {
            font-size: 0.75rem;
            color: var(--text-muted);
            opacity: 0.85;
            margin-top: 0.4rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-style: italic;
        }

        /* ── BOTÓN ESCUCHAR ── */
        .cancion-footer {
            padding: 0 1.75rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-escuchar {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.2rem;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: 1px solid var(--plat-color, var(--accent-gold));
            border-radius: 3px;
            background: transparent;
            color: var(--plat-color, var(--accent-gold));
            cursor: pointer;
            transition: var(--transition-smooth);
            font-family: 'Inter', sans-serif;
            width: fit-content;
        }

        .btn-escuchar:hover {
            background-color: var(--plat-color, var(--accent-gold));
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-escuchar svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .btn-escuchar.active svg {
            transform: rotate(180deg);
        }

        /* ── EMBED PLAYER ── */
        .player-wrapper {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.55s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.4s ease;
            opacity: 0;
            border-radius: 4px;
        }

        .player-wrapper.open {
            max-height: 400px;
            opacity: 1;
        }

        .player-wrapper.youtube-player.open {
            max-height: 400px;
        }

        .player-wrapper iframe {
            width: 100%;
            border: none;
            border-radius: 4px;
            display: block;
        }

        /* ── CONTROLES ADMIN ── */
        .admin-controls-inline {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            border-top: 1px dashed var(--border-color);
        }

        .btn-admin-small {
            padding: 0.35rem 0.75rem;
            font-size: 0.68rem;
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid var(--border-color);
            background-color: transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition-smooth);
            font-family: 'Inter', sans-serif;
        }

        .btn-admin-small:hover {
            border-color: var(--accent-gold);
            color: var(--text-main);
        }

        .btn-admin-delete {
            color: #B91C1C;
            border-color: #FECACA;
        }

        .btn-admin-delete:hover {
            background-color: #FEF2F2;
            border-color: #B91C1C;
        }

        /* ── ESTADO VACÍO ── */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text-muted);
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-state-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            font-style: italic;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .empty-state-text {
            font-size: 0.9rem;
        }

        /* ── MODAL ADMIN ── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(44, 38, 35, 0.45);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            animation: fadeIn 0.3s forwards;
        }

        .modal-card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 2.25rem;
            width: 100%;
            max-width: 520px;
            box-shadow: var(--card-shadow-hover);
            transform: translateY(20px);
            animation: slideUp 0.3s forwards;
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.4rem;
            line-height: 1;
            padding: 0.2rem;
            transition: var(--transition-smooth);
        }

        .modal-close:hover {
            color: var(--accent-rose);
        }

        .form-group {
            margin-bottom: 1.2rem;
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .form-group label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--bg-primary);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            font-size: 0.92rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-rose);
            background-color: #fff;
        }

        .form-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .form-error {
            font-size: 0.78rem;
            color: #B91C1C;
            margin-top: 0.25rem;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        /* ── FAB ADMIN ── */
        .fab-add {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem 1.5rem;
            background-color: var(--text-main);
            color: var(--bg-primary);
            border: none;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(44, 38, 35, 0.18);
            transition: var(--transition-smooth);
            z-index: 50;
        }

        .fab-add:hover {
            background-color: var(--accent-rose);
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(44, 38, 35, 0.22);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .canciones-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .musica-hero-title {
                font-size: 2.2rem;
            }

            .musica-hero {
                padding: 1.75rem 1rem 2rem;
                margin-bottom: 2.25rem;
            }

            .fab-add {
                bottom: 5.5rem;
                right: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="musica-container">

        {{-- HERO --}}
        <div class="musica-hero">
            <h1 class="musica-hero-title">Espacio Músical</h1>
            <p class="musica-hero-subtitle">Canciones que pueden traer recuerdos</p>
            <div class="musica-divider">
                <span style="color: var(--accent-rose); font-size: 1rem;">♫</span>
            </div>
        </div>

        {{-- ERRORES DE VALIDACIÓN --}}
        @if($errors->any())
            <div class="alert" style="background: #FEF2F2; border-left-color: #B91C1C; color: #7F1D1D; margin-bottom: 2rem;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- GRID DE CANCIONES --}}
        @if($canciones->count() > 0)
            <div class="canciones-grid">
                @foreach($canciones as $cancion)
                    <article class="cancion-card {{ $cancion->plataforma }}" id="card-{{ $cancion->id }}">

                        {{-- Cuerpo --}}
                        <div class="cancion-body">

                            {{-- Badge plataforma --}}
                            <div class="cancion-plataforma-badge">
                                @if($cancion->plataforma === 'spotify')
                                    {{-- Spotify icon --}}
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z" />
                                    </svg>
                                    Spotify
                                @elseif($cancion->plataforma === 'youtube')
                                    {{-- YouTube icon --}}
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                    YouTube
                                @elseif($cancion->plataforma === 'local_audio')
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                    </svg>
                                    Archivo (Audio)
                                @elseif($cancion->plataforma === 'local_video')
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                                    </svg>
                                    Archivo (Video)
                                @endif
                            </div>

                            <h2 class="cancion-titulo" id="cancion-titulo-{{ $cancion->id }}">{{ $cancion->titulo }}</h2>

                            @if($cancion->artista)
                                <p class="cancion-artista" id="cancion-artista-{{ $cancion->id }}">{{ $cancion->artista }}</p>
                            @endif

                            @if($cancion->descripcion)
                                <p class="cancion-descripcion" id="cancion-desc-{{ $cancion->id }}">{{ $cancion->descripcion }}</p>
                            @endif

                            @if($cancion->agregado_por)
                                <p class="cancion-agregado-por">
                                    <span style="color: var(--accent-gold); font-size: 0.8rem;">♥</span>
                                    Compartida por {{ $cancion->agregado_por }}
                                </p>
                            @endif
                        </div>

                        {{-- Footer: botón + player --}}
                        <div class="cancion-footer">
                            <button class="btn-escuchar" id="btn-{{ $cancion->id }}"
                                onclick="togglePlayer({{ $cancion->id }}, '{{ $cancion->plataforma }}')" aria-expanded="false">
                                {{-- Play icon --}}
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none" />
                                </svg>
                                Escuchar
                                {{-- Chevron --}}
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" style="margin-left: auto;">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            {{-- Player embed --}}
                            <div class="player-wrapper {{ $cancion->plataforma === 'youtube' ? 'youtube-player' : '' }}"
                                id="player-{{ $cancion->id }}" data-embed="{{ $cancion->embed_url }}"
                                data-archivo="{{ $cancion->archivo_path ? asset('music/' . $cancion->archivo_path) : '' }}"
                                data-plataforma="{{ $cancion->plataforma }}">
                            </div>
                        </div>

                        {{-- Admin controls --}}
                        @auth
                            <div class="admin-controls-inline">
                                <button class="btn-admin-small" onclick="openEditModal({{ $cancion->id }})">Editar</button>
                                <form action="{{ route('admin.canciones.destroy', $cancion->id) }}" method="POST"
                                    style="display:inline;" onsubmit="return confirm('¿Eliminar esta canción?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-small btn-admin-delete">Eliminar</button>
                                </form>
                            </div>
                        @endauth

                    </article>
                @endforeach
            </div>

        @else
            {{-- Estado vacío --}}
            <div class="empty-state">
                <div class="empty-state-icon">♫</div>
                <p class="empty-state-title">Aún no hay canciones aquí</p>
                <p class="empty-state-text">Pronto habrá música para compartir contigo.</p>
            </div>
        @endif

    </div>

    {{-- ── FAB ADMIN ── --}}
    <button class="fab-add" onclick="openAddModal()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Agregar canción
    </button>

    {{-- ── MODAL ADMIN ── --}}
    <div class="modal-overlay" id="cancion-modal" style="display:none;">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Agregar Canción</h3>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>

            <form id="cancion-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="form-method-container"></div>

                <div class="form-group">
                    <label for="cancion-titulo">Título de la canción *</label>
                    <input type="text" id="cancion-titulo" name="titulo" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="cancion-artista">Artista</label>
                    <input type="text" id="cancion-artista" name="artista" class="form-control">
                </div>

                <div class="form-group">
                    <label for="cancion-descripcion">Nota personal <span
                            style="text-transform: none; font-weight: 400;">(opcional)</span></label>
                    <textarea id="cancion-descripcion" name="descripcion" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label for="cancion-url">Link de Spotify o YouTube <span style="text-transform: none; font-weight: 400;">(opcional si subes archivo)</span></label>
                    <input type="text" id="cancion-url" name="url_original" class="form-control"
                        placeholder="https://open.spotify.com/track/... o https://youtu.be/...">
                    <span class="form-hint">Pega el link directo de una canción, playlist o video de YouTube.</span>
                </div>

                <div class="form-group">
                    <label for="cancion-archivo">O sube un archivo de música/video</label>
                    <input type="file" id="cancion-archivo" name="archivo_musica" class="form-control"
                        accept="audio/*,video/mp4,video/webm">
                    <span class="form-hint">Sube un archivo .mp3, .wav, .mp4. Máx 15MB.</span>
                </div>

                @auth
                    <div class="form-group">
                        <label for="cancion-orden">Orden <span style="text-transform: none; font-weight: 400;">(menor = aparece
                                primero)</span></label>
                        <input type="number" id="cancion-orden" name="orden" class="form-control" value="0" min="0">
                    </div>
                @endauth

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()"
                        style="padding: 0.65rem 1.4rem; font-size: 0.82rem;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" style="padding: 0.65rem 1.4rem; font-size: 0.82rem;">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // ─── PLAYER TOGGLE ─────────────────────────────────────────────────────
        const openPlayers = new Set();

        function togglePlayer(id, plataforma) {
            const wrapper = document.getElementById('player-' + id);
            const btn = document.getElementById('btn-' + id);
            const isOpen = openPlayers.has(id);

            if (isOpen) {
                // Cerrar
                wrapper.classList.remove('open');
                btn.classList.remove('active');
                btn.setAttribute('aria-expanded', 'false');
                // Pequeño delay antes de limpiar el iframe para que la animación termine
                setTimeout(() => { wrapper.innerHTML = ''; }, 500);
                openPlayers.delete(id);
            } else {
                // Abrir: insertar iframe o video/audio
                const embedUrl = wrapper.dataset.embed;
                const archivoUrl = wrapper.dataset.archivo;
                
                if (plataforma === 'local_audio') {
                    wrapper.innerHTML = `<audio controls style="width:100%; margin-top: 10px;" autoplay>
                                            <source src="${archivoUrl}" type="audio/mpeg">
                                            Tu navegador no soporta el elemento de audio.
                                        </audio>`;
                } else if (plataforma === 'local_video') {
                    wrapper.innerHTML = `<video controls style="width:100%; max-height:300px; border-radius:4px; margin-top:10px;" autoplay>
                                            <source src="${archivoUrl}" type="video/mp4">
                                            Tu navegador no soporta el elemento de video.
                                        </video>`;
                } else {
                    let height = plataforma === 'spotify' ? '352' : '200';
                    if (plataforma === 'youtube') {
                        wrapper.classList.add('youtube-player');
                    }
                    wrapper.innerHTML = `<iframe
                                            src="${embedUrl}"
                                            height="${height}"
                                            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                            loading="lazy"
                                            allowfullscreen>
                                        </iframe>`;
                }

                // Forzar reflow antes de agregar la clase
                wrapper.getBoundingClientRect();
                wrapper.classList.add('open');
                btn.classList.add('active');
                btn.setAttribute('aria-expanded', 'true');
                openPlayers.add(id);
            }
        }

        // ─── MODAL CANCIONES ───────────────────────────────────────────────────
        const modal = document.getElementById('cancion-modal');
        const form = document.getElementById('cancion-form');
        const modalTitle = document.getElementById('modal-title');
        const inputTitulo = document.getElementById('cancion-titulo');
        const inputArtista = document.getElementById('cancion-artista');
        const inputDesc = document.getElementById('cancion-descripcion');
        const inputUrl = document.getElementById('cancion-url');
        const inputOrden = document.getElementById('cancion-orden');
        const methodContainer = document.getElementById('form-method-container');

        function openAddModal() {
            modalTitle.innerText = 'Agregar Canción';
            @auth
                form.action = "{{ route('admin.canciones.store') }}";
            @else
                form.action = "{{ route('canciones.visitor.store') }}";
            @endauth
            methodContainer.innerHTML = '';
            inputTitulo.value = '';
            inputArtista.value = '';
            inputDesc.value = '';
            inputUrl.value = '';
            document.getElementById('cancion-archivo').value = '';
            if (inputOrden) inputOrden.value = '0';
            modal.style.display = 'flex';
        }

        @auth
            function openEditModal(id) {
                modalTitle.innerText = 'Editar Canción';
                form.action = `/admin/canciones/${id}`;
                methodContainer.innerHTML = '@method("PUT")';

                // Recuperar datos del DOM
                inputTitulo.value = document.getElementById('cancion-titulo-' + id)?.innerText ?? '';
                inputArtista.value = document.getElementById('cancion-artista-' + id)?.innerText ?? '';
                inputDesc.value = document.getElementById('cancion-desc-' + id)?.innerText ?? '';
                // La URL original no está en el DOM; dejarla vacía para que el usuario la reingrese
                inputUrl.value = '';
                document.getElementById('cancion-archivo').value = '';
                if (inputOrden) inputOrden.value = '0';

                // Añadir una nota informativa al campo URL
                document.getElementById('cancion-url').placeholder = 'Ingresa nuevamente el link de Spotify o YouTube';

                modal.style.display = 'flex';
            }
        @endauth

        function closeModal() {
            modal.style.display = 'none';
        }

        window.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });

        // Validación de tamaño de archivo antes de enviar
        form.addEventListener('submit', function (e) {
            const archivoInput = document.getElementById('cancion-archivo');
            if (archivoInput && archivoInput.files.length > 0) {
                const fileSize = archivoInput.files[0].size;
                const maxSize = 15 * 1024 * 1024; // 15MB
                
                if (fileSize > maxSize) {
                    e.preventDefault();
                    alert('El archivo que intentas subir es demasiado grande. Por favor, asegúrate de que pese menos de 15MB.');
                }
            }
        });
    </script>
@endsection