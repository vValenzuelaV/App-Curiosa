@extends('layouts.app')

@section('styles')
<style>
    /* ── ANIMACIÓN ENTRADA ── */
    .dibujos-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem 2rem 6rem;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.9s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* ── HERO ── */
    .dibujos-hero {
        text-align: center;
        padding: 2.5rem 1rem 3rem;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 3.5rem;
    }

    /* Botón Crear Dibujo Principal */
    .btn-crear-dibujo-principal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.95rem 2.2rem;
        margin-top: 1.75rem;
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-rose) 100%);
        color: #FFFFFF !important;
        border: none;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(192, 160, 128, 0.35);
        transition: var(--transition-smooth);
        text-decoration: none;
        outline: none;
    }

    .btn-crear-dibujo-principal:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(176, 133, 125, 0.45);
        background: linear-gradient(135deg, var(--accent-rose) 0%, var(--accent-gold) 100%);
    }

    .btn-crear-dibujo-principal svg {
        transition: transform 0.3s ease;
    }

    .btn-crear-dibujo-principal:hover svg {
        transform: rotate(15deg) scale(1.1);
    }

    .dibujos-hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 300;
        font-style: italic;
        color: var(--text-main);
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }

    .dibujos-hero-subtitle {
        font-size: 0.88rem;
        color: var(--text-muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .dibujos-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin: 1.25rem auto 0;
    }

    .dibujos-divider::before,
    .dibujos-divider::after {
        content: '';
        height: 1px;
        width: 50px;
        background-color: var(--accent-gold);
    }

    /* ── GRID DE DIBUJOS ── */
    .dibujos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 4rem;
    }

    /* ── CARD DE DIBUJO ── */
    .dibujo-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        opacity: 0;
        transform: translateY(14px);
        animation: cardIn 0.55s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        position: relative;
    }

    .dibujo-card:nth-child(1) { animation-delay: 0.08s; }
    .dibujo-card:nth-child(2) { animation-delay: 0.16s; }
    .dibujo-card:nth-child(3) { animation-delay: 0.24s; }
    .dibujo-card:nth-child(4) { animation-delay: 0.32s; }
    .dibujo-card:nth-child(5) { animation-delay: 0.40s; }
    .dibujo-card:nth-child(n+6) { animation-delay: 0.45s; }

    @keyframes cardIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .dibujo-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-gold);
    }

    .dibujo-card::before {
        content: '';
        display: block;
        height: 3px;
        background: linear-gradient(90deg, var(--accent-gold), var(--accent-rose));
        flex-shrink: 0;
    }

    .dibujo-img {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: contain;
        background: #FDFAF5;
        display: block;
        cursor: zoom-in;
        transition: opacity 0.3s ease;
    }

    .dibujo-img:hover {
        opacity: 0.9;
    }

    .dibujo-info {
        padding: 0.85rem 1rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .dibujo-titulo {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-main);
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dibujo-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .dibujo-creador {
        font-size: 0.74rem;
        color: var(--text-muted);
        font-style: italic;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .dibujo-fecha {
        font-size: 0.7rem;
        color: var(--text-muted);
        opacity: 0.7;
    }

    .btn-admin-delete-dibujo {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid #c5a0a0;
        border-radius: 3px;
        background: transparent;
        color: #a07070;
        cursor: pointer;
        padding: 0.25rem 0.6rem;
        transition: var(--transition-smooth);
        font-family: 'Inter', sans-serif;
    }

    .btn-admin-delete-dibujo:hover {
        background: #B0857D20;
        border-color: var(--accent-rose);
        color: var(--accent-rose);
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        grid-column: 1 / -1;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.4;
    }

    .empty-state-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        font-style: italic;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        opacity: 0.7;
    }

    /* ── FAB ── */
    .fab-crear {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.85rem 1.4rem;
        background: var(--accent-gold);
        color: #fff;
        border: none;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 0 6px 24px rgba(192, 160, 128, 0.45);
        transition: var(--transition-smooth);
        z-index: 50;
    }

    .fab-crear:hover {
        background: var(--accent-rose);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(176, 133, 125, 0.45);
    }

    /* ── LIGHTBOX ── */
    .lightbox-overlay {
        position: fixed;
        inset: 0;
        background: rgba(44, 38, 35, 0.88);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 1.5rem;
        backdrop-filter: blur(6px);
    }

    .lightbox-overlay.open {
        display: flex;
    }

    .lightbox-img {
        max-width: 90vw;
        max-height: 88vh;
        border-radius: 6px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        object-fit: contain;
    }

    .lightbox-close {
        position: fixed;
        top: 1.25rem;
        right: 1.25rem;
        background: rgba(249, 246, 240, 0.15);
        border: 1px solid rgba(249, 246, 240, 0.3);
        color: #F9F6F0;
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.2rem;
        transition: var(--transition-smooth);
    }

    .lightbox-close:hover {
        background: rgba(249, 246, 240, 0.3);
    }

    /* ── CANVAS MODAL ── */
    .canvas-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(44, 38, 35, 0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 1rem;
        backdrop-filter: blur(4px);
    }

    .canvas-modal-overlay.open {
        display: flex;
    }

    .canvas-panel {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(44, 38, 35, 0.2);
        width: 100%;
        max-width: 760px;
        max-height: 95vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .canvas-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .canvas-panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-weight: 600;
        font-style: italic;
        color: var(--text-main);
    }

    .canvas-close-btn {
        background: none;
        border: none;
        font-size: 1.4rem;
        color: var(--text-muted);
        cursor: pointer;
        line-height: 1;
        padding: 0.25rem;
        transition: var(--transition-smooth);
    }

    .canvas-close-btn:hover { color: var(--accent-rose); }

    /* ── TOOLBAR ── */
    .canvas-toolbar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
        flex-shrink: 0;
        background: var(--bg-primary);
    }

    .toolbar-section {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .toolbar-label {
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 600;
        white-space: nowrap;
    }

    /* Swatch de colores */
    .color-swatch {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        transition: transform 0.2s ease, border-color 0.2s ease;
        outline: none;
        flex-shrink: 0;
    }

    .color-swatch:hover { transform: scale(1.15); }
    .color-swatch.active { border-color: var(--accent-gold); transform: scale(1.15); }

    /* Slider de grosor */
    .brush-slider {
        -webkit-appearance: none;
        width: 80px;
        height: 4px;
        border-radius: 2px;
        background: var(--border-color);
        outline: none;
        cursor: pointer;
    }

    .brush-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--accent-gold);
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    }

    /* Botones herramienta */
    .tool-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.35rem 0.7rem;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: var(--transition-smooth);
        white-space: nowrap;
    }

    .tool-btn:hover { border-color: var(--accent-gold); color: var(--text-main); }
    .tool-btn.active { background: var(--accent-gold); border-color: var(--accent-gold); color: #fff; }

    /* ── CANVAS WRAPPER ── */
    .canvas-wrapper {
        flex: 1;
        overflow: hidden;
        position: relative;
        background: #FDFAF5;
        cursor: crosshair;
        min-height: 0;
    }

    #drawing-canvas {
        display: block;
        width: 100%;
        height: 100%;
        touch-action: none;
    }

    /* ── FOOTER DEL CANVAS ── */
    .canvas-panel-footer {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 1.2rem;
        border-top: 1px solid var(--border-color);
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    .canvas-titulo-input {
        flex: 1;
        min-width: 160px;
        padding: 0.5rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: var(--text-main);
        background: var(--bg-primary);
        outline: none;
        transition: border-color 0.2s;
    }

    .canvas-titulo-input:focus { border-color: var(--accent-gold); }

    .btn-guardar-dibujo {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 1.25rem;
        background: var(--accent-gold);
        color: #fff;
        border: none;
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: var(--transition-smooth);
        white-space: nowrap;
    }

    .btn-guardar-dibujo:hover { background: var(--accent-rose); transform: translateY(-1px); }
    .btn-guardar-dibujo:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    /* ── RESPONSIVE ── */
    @media (max-width: 680px) {
        .dibujos-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .dibujos-hero-title { font-size: 2.2rem; }
        .canvas-panel { max-height: 100vh; border-radius: 0; }
        .canvas-toolbar { gap: 0.5rem; }
        .fab-crear { bottom: 5.5rem; right: 1rem; }
    }

    @media (max-width: 420px) {
        .dibujos-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="dibujos-container">

    {{-- HERO --}}
    <div class="dibujos-hero">
        <h1 class="dibujos-hero-title">Nuestros Dibujos</h1>
        <p class="dibujos-hero-subtitle">Trazos que quedan guardados</p>
        <div class="dibujos-divider">
            <span style="color: var(--accent-gold); font-size: 1rem;">✏</span>
        </div>
        <div style="display: flex; justify-content: center; margin-top: 0.5rem;">
            <button class="btn-crear-dibujo-principal" onclick="openCanvasModal()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
                ¡Crear un nuevo dibujo!
            </button>
        </div>
    </div>

    {{-- FLASH ERROR --}}
    @if($errors->any())
        <div class="alert" style="background: #FEF2F2; border-left-color: #B91C1C; color: #7F1D1D; margin-bottom: 2rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- GALERÍA --}}
    <div class="dibujos-grid" id="dibujos-grid">
        @forelse($dibujos as $dibujo)
            <article class="dibujo-card" id="card-dibujo-{{ $dibujo->id }}">
                <img
                    class="dibujo-img"
                    src="{{ $dibujo->imagen }}"
                    alt="{{ $dibujo->titulo ?? 'Dibujo de ' . $dibujo->creado_por }}"
                    onclick="openLightbox('{{ $dibujo->imagen }}', '{{ $dibujo->titulo ?? '' }}')"
                    loading="lazy"
                >
                <div class="dibujo-info">
                    @if($dibujo->titulo)
                        <p class="dibujo-titulo">{{ $dibujo->titulo }}</p>
                    @endif
                    <div class="dibujo-meta">
                        <span class="dibujo-creador">
                            <span style="color: var(--accent-gold);">♥</span>
                            {{ $dibujo->creado_por }}
                        </span>
                        <span class="dibujo-fecha">{{ $dibujo->created_at->format('d/m/Y') }}</span>
                    </div>
                    @auth
                        <div style="margin-top: 0.4rem;">
                            <form action="{{ route('admin.dibujos.destroy', $dibujo->id) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('¿Eliminar este dibujo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-delete-dibujo">
                                    × Eliminar
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </article>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon">✏</div>
                <p class="empty-state-title">Aún no hay dibujos aquí</p>
                <p class="empty-state-text">¡Sé el primero en dejar un trazo!</p>
            </div>
        @endforelse
    </div>

</div>

{{-- ── FAB ── --}}
<button class="fab-crear" id="btn-abrir-canvas" onclick="openCanvasModal()">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
        stroke-linecap="round">
        <line x1="12" y1="5" x2="12" y2="19" />
        <line x1="5" y1="12" x2="19" y2="12" />
    </svg>
    Crear Dibujo
</button>

{{-- ── LIGHTBOX ── --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
    <button class="lightbox-close" onclick="closeLightboxBtn()">×</button>
    <img class="lightbox-img" id="lightbox-img" src="" alt="">
</div>

{{-- ── CANVAS MODAL ── --}}
<div class="canvas-modal-overlay" id="canvas-modal">
    <div class="canvas-panel">

        <div class="canvas-panel-header">
            <span class="canvas-panel-title">Tu Lienzo</span>
            <button class="canvas-close-btn" onclick="closeCanvasModal()" title="Cerrar">×</button>
        </div>

        {{-- TOOLBAR --}}
        <div class="canvas-toolbar">

            {{-- Colores --}}
            <div class="toolbar-section">
                <span class="toolbar-label">Color</span>
                <button class="color-swatch active" style="background:#2C2623;" data-color="#2C2623" title="Espresso" onclick="setColor(this)"></button>
                <button class="color-swatch" style="background:#C0A080;" data-color="#C0A080" title="Dorado" onclick="setColor(this)"></button>
                <button class="color-swatch" style="background:#B0857D;" data-color="#B0857D" title="Rosa" onclick="setColor(this)"></button>
                <button class="color-swatch" style="background:#5E8C6A;" data-color="#5E8C6A" title="Verde" onclick="setColor(this)"></button>
                <button class="color-swatch" style="background:#7A9AB0;" data-color="#7A9AB0" title="Azul" onclick="setColor(this)"></button>
                <button class="color-swatch" style="background:#6B615B;" data-color="#6B615B" title="Marrón" onclick="setColor(this)"></button>
                <button class="color-swatch" style="background:#1a1a1a;" data-color="#1a1a1a" title="Negro" onclick="setColor(this)"></button>
                <input type="color" id="color-picker-input" value="#2C2623" title="Color personalizado"
                    style="width:22px;height:22px;border-radius:50%;border:2px solid var(--border-color);cursor:pointer;padding:0;overflow:hidden;"
                    onchange="setColorFromPicker(this.value)">
            </div>

            <div style="width:1px;height:20px;background:var(--border-color);margin:0 0.1rem;"></div>

            {{-- Tamaño pincel --}}
            <div class="toolbar-section">
                <span class="toolbar-label">Grosor</span>
                <input type="range" class="brush-slider" id="brush-size" min="1" max="30" value="4"
                    oninput="updateBrushSize(this.value)">
                <span id="brush-size-label" style="font-size:0.7rem;color:var(--text-muted);min-width:18px;text-align:center;">4</span>
            </div>

            <div style="width:1px;height:20px;background:var(--border-color);margin:0 0.1rem;"></div>

            {{-- Herramientas --}}
            <div class="toolbar-section">
                <button class="tool-btn active" id="btn-pincel" onclick="setTool('pincel')" title="Pincel">✏ Pincel</button>
                <button class="tool-btn" id="btn-borrador" onclick="setTool('borrador')" title="Borrador">◻ Borrador</button>
                <button class="tool-btn" id="btn-balde" onclick="setTool('balde')" title="Balde de Pintura (Relleno)">🪣 Pintar</button>
            </div>

            <div style="width:1px;height:20px;background:var(--border-color);margin:0 0.1rem;"></div>

            {{-- Figuras --}}
            <div class="toolbar-section">
                <span class="toolbar-label">Figuras</span>
                <button class="tool-btn" id="btn-cuadrado" onclick="setTool('cuadrado')" title="Cuadrado">⏹ Cuadrado</button>
                <button class="tool-btn" id="btn-rectangulo" onclick="setTool('rectangulo')" title="Rectángulo">▭ Rectángulo</button>
                <button class="tool-btn" id="btn-estrella" onclick="setTool('estrella')" title="Estrella">⭐ Estrella</button>
            </div>

            <div style="width:1px;height:20px;background:var(--border-color);margin:0 0.1rem;"></div>

            {{-- Acciones --}}
            <div class="toolbar-section">
                <button class="tool-btn" onclick="deshacerTrazo()" title="Deshacer (Ctrl+Z)">↩ Deshacer</button>
                <button class="tool-btn" onclick="limpiarCanvas()" style="color:#a07070;border-color:#c5a0a0;" title="Limpiar todo">↺ Limpiar</button>
            </div>
        </div>

        {{-- CANVAS --}}
        <div class="canvas-wrapper" id="canvas-wrapper">
            <canvas id="drawing-canvas"></canvas>
        </div>

        {{-- FOOTER --}}
        <div class="canvas-panel-footer">
            <input
                type="text"
                id="dibujo-titulo-input"
                class="canvas-titulo-input"
                placeholder="Título del dibujo (opcional)"
                maxlength="255"
            >
            <button class="btn-guardar-dibujo" id="btn-guardar" onclick="guardarDibujo()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Guardar
            </button>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // ── LIGHTBOX ──────────────────────────────────────────────────────────────
    function openLightbox(src, titulo) {
        const lb = document.getElementById('lightbox');
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-img').alt = titulo || 'Dibujo';
        lb.classList.add('open');
    }

    function closeLightboxBtn() {
        document.getElementById('lightbox').classList.remove('open');
    }

    function closeLightbox(e) {
        if (e.target === document.getElementById('lightbox')) closeLightboxBtn();
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeLightboxBtn();
            closeCanvasModal();
        }
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z') {
            const modal = document.getElementById('canvas-modal');
            if (modal && modal.classList.contains('open')) {
                e.preventDefault();
                deshacerTrazo();
            }
        }
    });

    // ── CANVAS ────────────────────────────────────────────────────────────────
    let canvas, ctx;
    let isDrawing = false;
    let currentColor = '#2C2623';
    let currentTool = 'pincel';  // 'pincel' | 'borrador' | 'balde' | 'cuadrado' | 'rectangulo' | 'estrella'
    let brushSize = 4;
    let lastX = 0, lastY = 0;
    let savedImageData = null;
    let startX = 0, startY = 0;
    let undoStack = [];

    function openCanvasModal() {
        document.getElementById('canvas-modal').classList.add('open');
        if (!canvas) initCanvas();
        else resizeCanvas();
    }

    function closeCanvasModal() {
        document.getElementById('canvas-modal').classList.remove('open');
    }

    function initCanvas() {
        canvas = document.getElementById('drawing-canvas');
        ctx = canvas.getContext('2d');
        resizeCanvas();
        attachCanvasEvents();
    }

    function resizeCanvas() {
        const wrapper = document.getElementById('canvas-wrapper');
        const rect = wrapper.getBoundingClientRect();
        // Guardar el contenido actual si ya había algo dibujado
        let imgData = null;
        if (canvas.width > 0 && canvas.height > 0) {
            try { imgData = ctx.getImageData(0, 0, canvas.width, canvas.height); } catch(e) {}
        }
        canvas.width  = rect.width;
        canvas.height = rect.height || 340;
        // Fondo crema
        ctx.fillStyle = '#FDFAF5';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        // Restaurar dibujo previo si había
        if (imgData) {
            try { ctx.putImageData(imgData, 0, 0); } catch(e) {}
        }
        setCtxStyle();
    }

    function setCtxStyle() {
        ctx.lineJoin    = 'round';
        ctx.lineCap     = 'round';
        ctx.lineWidth   = brushSize;
        ctx.strokeStyle = currentTool === 'borrador' ? '#FDFAF5' : currentColor;
    }

    function attachCanvasEvents() {
        // Mouse
        canvas.addEventListener('mousedown', startDraw);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', (e) => stopDraw(e));
        canvas.addEventListener('mouseleave', (e) => stopDraw(e));
        // Touch
        canvas.addEventListener('touchstart', (e) => { e.preventDefault(); startDraw(e.touches[0]); }, { passive: false });
        canvas.addEventListener('touchmove',  (e) => { e.preventDefault(); draw(e.touches[0]); }, { passive: false });
        canvas.addEventListener('touchend',   (e) => stopDraw(e.changedTouches[0] || null));
    }

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width  / rect.width;
        const scaleY = canvas.height / rect.height;
        return {
            x: (e.clientX - rect.left) * scaleX,
            y: (e.clientY - rect.top)  * scaleY,
        };
    }

    function startDraw(e) {
        saveState();
        isDrawing = true;
        const pos = getPos(e);
        lastX = pos.x;
        lastY = pos.y;
        startX = pos.x;
        startY = pos.y;

        if (currentTool === 'balde') {
            const fillX = Math.max(0, Math.min(canvas.width - 1, Math.round(pos.x)));
            const fillY = Math.max(0, Math.min(canvas.height - 1, Math.round(pos.y)));
            floodFill(fillX, fillY, currentColor);
            isDrawing = false;
            return;
        }

        if (['cuadrado', 'rectangulo', 'estrella'].includes(currentTool)) {
            savedImageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            return;
        }

        // Punto inmediato al hacer click
        ctx.beginPath();
        ctx.arc(lastX, lastY, brushSize / 2, 0, Math.PI * 2);
        ctx.fillStyle = currentTool === 'borrador' ? '#FDFAF5' : currentColor;
        ctx.fill();
    }

    function draw(e) {
        if (!isDrawing) return;
        const pos = getPos(e);

        if (['cuadrado', 'rectangulo', 'estrella'].includes(currentTool)) {
            if (savedImageData) {
                ctx.putImageData(savedImageData, 0, 0);
                drawShape(currentTool, startX, startY, pos.x, pos.y);
            }
            return;
        }

        setCtxStyle();
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastX = pos.x;
        lastY = pos.y;
    }

    function stopDraw(e) {
        if (!isDrawing) return;
        if (['cuadrado', 'rectangulo', 'estrella'].includes(currentTool)) {
            if (savedImageData) {
                ctx.putImageData(savedImageData, 0, 0);
                let pos = { x: lastX, y: lastY };
                if (e) {
                    pos = getPos(e);
                }
                drawShape(currentTool, startX, startY, pos.x, pos.y);
            }
        }
        isDrawing = false;
        savedImageData = null;
    }

    function drawShape(tool, x1, y1, x2, y2) {
        setCtxStyle();
        ctx.beginPath();
        if (tool === 'rectangulo') {
            const w = x2 - x1;
            const h = y2 - y1;
            ctx.rect(x1, y1, w, h);
            ctx.stroke();
        } else if (tool === 'cuadrado') {
            const dx = x2 - x1;
            const dy = y2 - y1;
            const size = Math.max(Math.abs(dx), Math.abs(dy));
            const w = Math.sign(dx) * size;
            const h = Math.sign(dy) * size;
            ctx.rect(x1, y1, w, h);
            ctx.stroke();
        } else if (tool === 'estrella') {
            const outerRadius = Math.hypot(x2 - x1, y2 - y1);
            const innerRadius = outerRadius * 0.4;
            const spikes = 5;
            let rot = Math.PI / 2 * 3;
            let cx = x1;
            let cy = y1;
            const step = Math.PI / spikes;

            ctx.moveTo(cx, cy - outerRadius);
            for (let i = 0; i < spikes; i++) {
                let x = cx + Math.cos(rot) * outerRadius;
                let y = cy + Math.sin(rot) * outerRadius;
                ctx.lineTo(x, y);
                rot += step;

                x = cx + Math.cos(rot) * innerRadius;
                y = cy + Math.sin(rot) * innerRadius;
                ctx.lineTo(x, y);
                rot += step;
            }
            ctx.closePath();
            ctx.stroke();
        }
    }

    function hexToRgba(hex) {
        let r = 0, g = 0, b = 0, a = 255;
        if (hex.startsWith('#')) {
            if (hex.length === 4) {
                r = parseInt(hex[1] + hex[1], 16);
                g = parseInt(hex[2] + hex[2], 16);
                b = parseInt(hex[3] + hex[3], 16);
            } else if (hex.length === 7) {
                r = parseInt(hex.substring(1, 3), 16);
                g = parseInt(hex.substring(3, 5), 16);
                b = parseInt(hex.substring(5, 7), 16);
            }
        }
        return { r, g, b, a };
    }

    function floodFill(startX, startY, fillHex) {
        const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imgData.data;
        const width = canvas.width;
        const height = canvas.height;

        const fillRgba = hexToRgba(fillHex);
        const startPos = (startY * width + startX) * 4;
        const targetR = data[startPos];
        const targetG = data[startPos + 1];
        const targetB = data[startPos + 2];
        const targetA = data[startPos + 3];

        if (targetR === fillRgba.r &&
            targetG === fillRgba.g &&
            targetB === fillRgba.b &&
            targetA === fillRgba.a) {
            return;
        }

        const visited = new Uint8Array(width * height);
        const stack = [startY * width + startX];
        const tolerance = 20;

        function matchStartColor(pos) {
            return Math.abs(data[pos] - targetR) <= tolerance &&
                   Math.abs(data[pos + 1] - targetG) <= tolerance &&
                   Math.abs(data[pos + 2] - targetB) <= tolerance &&
                   Math.abs(data[pos + 3] - targetA) <= tolerance;
        }

        while (stack.length > 0) {
            const idx = stack.pop();
            if (visited[idx]) continue;
            visited[idx] = 1;

            const pos = idx * 4;
            if (matchStartColor(pos)) {
                data[pos] = fillRgba.r;
                data[pos + 1] = fillRgba.g;
                data[pos + 2] = fillRgba.b;
                data[pos + 3] = fillRgba.a;

                const x = idx % width;
                const y = Math.floor(idx / width);

                if (x + 1 < width) stack.push(idx + 1);
                if (x - 1 >= 0) stack.push(idx - 1);
                if (y + 1 < height) stack.push(idx + width);
                if (y - 1 >= 0) stack.push(idx - width);
            }
        }

        ctx.putImageData(imgData, 0, 0);
    }

    function setColor(btn) {
        currentColor = btn.dataset.color;
        if (currentTool === 'borrador') {
            currentTool = 'pincel';
        }
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        btn.classList.add('active');
        setTool(currentTool);
    }

    function setColorFromPicker(value) {
        currentColor = value;
        if (currentTool === 'borrador') {
            currentTool = 'pincel';
        }
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        setTool(currentTool);
    }

    function updateBrushSize(val) {
        brushSize = parseInt(val);
        document.getElementById('brush-size-label').textContent = val;
        setCtxStyle();
    }

    function setTool(tool) {
        currentTool = tool;
        const tools = ['pincel', 'borrador', 'balde', 'cuadrado', 'rectangulo', 'estrella'];
        tools.forEach(t => {
            const btn = document.getElementById(`btn-${t}`);
            if (btn) btn.classList.toggle('active', t === tool);
        });
        setCtxStyle();
    }

    function saveState() {
        if (!ctx || !canvas) return;
        undoStack.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
        if (undoStack.length > 25) undoStack.shift();
    }

    function deshacerTrazo() {
        if (undoStack.length > 0) {
            ctx.putImageData(undoStack.pop(), 0, 0);
        } else {
            limpiarCanvas(true);
        }
    }

    function limpiarCanvas(noSave) {
        if (!ctx) return;
        if (!noSave) saveState();
        ctx.fillStyle = '#FDFAF5';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    // ── GUARDAR ───────────────────────────────────────────────────────────────
    async function guardarDibujo() {
        if (!canvas) return;

        const btnGuardar = document.getElementById('btn-guardar');
        btnGuardar.disabled = true;
        btnGuardar.textContent = 'Guardando…';

        const titulo = document.getElementById('dibujo-titulo-input').value.trim();
        const imagen = canvas.toDataURL('image/png');

        try {
            const response = await fetch('{{ route("dibujos.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ titulo, imagen }),
            });

            const data = await response.json();

            if (data.success) {
                // Añadir la card al grid sin recargar
                prependDibujoCard(data.dibujo);
                closeCanvasModal();
                limpiarCanvas();
                document.getElementById('dibujo-titulo-input').value = '';
                mostrarToast('¡Dibujo guardado con cariño! ♥');
            } else {
                alert('No se pudo guardar el dibujo. Inténtalo de nuevo.');
            }
        } catch (err) {
            alert('Error al guardar. Verifica tu conexión.');
        }

        btnGuardar.disabled = false;
        btnGuardar.innerHTML = `
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
            </svg>
            Guardar`;
    }

    function prependDibujoCard(d) {
        const grid = document.getElementById('dibujos-grid');

        // Quitar el empty-state si existe
        const emptyState = grid.querySelector('.empty-state');
        if (emptyState) emptyState.parentElement.remove();

        const isAdmin = {{ auth()->check() ? 'true' : 'false' }};
        const deleteForm = isAdmin
            ? `<div style="margin-top:0.4rem;">
                    <form action="/admin/dibujos/${d.id}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este dibujo?')">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn-admin-delete-dibujo">× Eliminar</button>
                    </form>
               </div>`
            : '';

        const tituloHtml = d.titulo
            ? `<p class="dibujo-titulo">${escHtml(d.titulo)}</p>`
            : '';

        const card = document.createElement('article');
        card.className = 'dibujo-card';
        card.id = `card-dibujo-${d.id}`;
        card.style.animationDelay = '0s';
        card.innerHTML = `
            <img class="dibujo-img" src="${d.imagen}"
                alt="${escHtml(d.titulo || 'Dibujo')}"
                onclick="openLightbox('${d.imagen}', '${escHtml(d.titulo || '')}')">
            <div class="dibujo-info">
                ${tituloHtml}
                <div class="dibujo-meta">
                    <span class="dibujo-creador"><span style="color:var(--accent-gold);">♥</span> ${escHtml(d.creado_por)}</span>
                    <span class="dibujo-fecha">${d.fecha}</span>
                </div>
                ${deleteForm}
            </div>`;

        grid.insertBefore(card, grid.firstChild);
    }

    function escHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    // ── TOAST ─────────────────────────────────────────────────────────────────
    function mostrarToast(msg) {
        const t = document.createElement('div');
        t.textContent = msg;
        Object.assign(t.style, {
            position: 'fixed', bottom: '2rem', left: '50%', transform: 'translateX(-50%)',
            background: 'var(--accent-gold)', color: '#fff', padding: '0.7rem 1.4rem',
            borderRadius: '50px', fontFamily: 'Inter, sans-serif', fontSize: '0.82rem',
            fontWeight: '600', zIndex: '9999', boxShadow: '0 6px 20px rgba(192,160,128,.4)',
            opacity: '0', transition: 'opacity 0.3s ease',
        });
        document.body.appendChild(t);
        requestAnimationFrame(() => { t.style.opacity = '1'; });
        setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => t.remove(), 350);
        }, 2800);
    }

    // Redimensionar canvas cuando cambie el tamaño de la ventana
    window.addEventListener('resize', () => {
        if (canvas && document.getElementById('canvas-modal').classList.contains('open')) {
            resizeCanvas();
        }
    });
</script>
@endsection
