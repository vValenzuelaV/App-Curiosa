@extends('layouts.app')

@section('styles')
<style>
    .respuestas-container {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .respuestas-timeline {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 3rem;
    }

    .respuesta-card {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 2rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
    }

    .respuesta-card:hover {
        border-color: var(--accent-gold);
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .respuesta-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.75rem;
    }

    .respuesta-author-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .avatar-indicator {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: var(--bg-primary);
        border: 1px solid var(--accent-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 1rem;
        color: var(--accent-rose);
        text-transform: uppercase;
    }

    .author-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-main);
    }

    .respuesta-date {
        font-size: 0.78rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .respuesta-content {
        font-size: 1rem;
        line-height: 1.6;
        color: var(--text-main);
        margin-bottom: 1.25rem;
        white-space: pre-line;
    }

    .respuesta-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        border-top: 1px dashed var(--border-color);
        padding-top: 0.75rem;
    }

    .letter-link {
        color: var(--accent-rose);
        text-decoration: none;
        font-style: italic;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 500;
        transition: var(--transition-smooth);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .letter-link:hover {
        color: var(--text-main);
    }

    /* CONTROLES DE ADMINISTRACIÓN */
    .admin-controls-inline {
        display: flex;
        gap: 0.5rem;
    }

    .btn-admin-small {
        padding: 0.4rem 0.8rem;
        font-size: 0.7rem;
        border-radius: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid var(--border-color);
        background-color: transparent;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition-smooth);
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
        color: #B91C1C;
    }

    /* ESTILOS MODAL ADMIN */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(44, 38, 35, 0.4);
        backdrop-filter: blur(4px);
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
        border-radius: 4px;
        padding: 2.5rem;
        width: 100%;
        max-width: 500px;
        box-shadow: var(--card-shadow-hover);
        transform: translateY(20px);
        animation: slideUp 0.3s forwards;
    }

    @keyframes fadeIn { to { opacity: 1; } }
    @keyframes slideUp { to { transform: translateY(0); } }

    .form-group {
        margin-bottom: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
    }

    .form-control {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent-rose);
        background-color: #FFFFFF;
    }

    @media (max-width: 768px) {
        .respuesta-card {
            padding: 1.25rem;
        }

        .respuesta-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .respuesta-author-info {
            gap: 0.5rem;
        }

        .avatar-indicator {
            width: 28px;
            height: 28px;
            font-size: 0.9rem;
        }

        .author-name {
            font-size: 0.9rem;
        }

        .respuesta-date {
            font-size: 0.72rem;
            align-self: auto;
        }

        .respuesta-content {
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .respuesta-footer {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }

        .admin-controls-inline {
            justify-content: flex-end;
            margin-top: 0.25rem;
        }

        .form-control {
            font-size: 16px !important;
        }

        .modal-card {
            padding: 1.75rem 1.25rem;
            width: 92%;
            margin: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="respuestas-container">
    
    <!-- CABECERA -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span class="subtitle-sans">Diálogo y Conexión</span>
        <h1 class="title-serif">Respuestas y Mensajes</h1>
        <p class="lead-text" style="margin: 0 auto;">
            Este va a ser tu espacio si lo quieres tomar, estar tus comentarios y los podre ver, claro si asi siemore lo desees, sera privado y solamente para ti.
        </p>
    </div>

    <!-- LISTADO DE RESPUESTAS -->
    <div class="respuestas-timeline">
        @forelse($respuestas as $respuesta)
            <div class="respuesta-card">
                
                <!-- Encabezado de la Respuesta -->
                <div class="respuesta-header">
                    <div class="respuesta-author-info">
                        <div class="avatar-indicator">{{ strtoupper(substr($respuesta->nombre, 0, 1)) }}</div>
                        <span class="author-name">{{ $respuesta->nombre }}</span>
                    </div>
                    <span class="respuesta-date">
                        {{ \Carbon\Carbon::parse($respuesta->created_at)->locale('es')->isoFormat('LL [a las] HH:mm') }}
                    </span>
                </div>

                <!-- Contenido de la Respuesta -->
                <div class="respuesta-content">
                    {{ $respuesta->comentario }}
                </div>
                
                <!-- Datos ocultos para la edición -->
                <span id="respuesta-raw-comentario-{{ $respuesta->id }}" style="display:none;">{{ $respuesta->comentario }}</span>

                <!-- Pie de la Tarjeta con Enlace a la Carta -->
                <div class="respuesta-footer">
                    <div>
                        <span style="color: var(--text-muted); font-size: 0.8rem;">En respuesta a la carta:</span>
                        @if($respuesta->cartas)
                            <a href="{{ route('cartas') }}#envelope-{{ $respuesta->cartas->id }}" class="letter-link">
                                "{{ $respuesta->cartas->titulo }}" <span>→</span>
                            </a>
                        @else
                            <span style="font-style: italic; color: var(--text-muted);">Carta no encontrada</span>
                        @endif
                    </div>

                    @auth
                        <!-- Controles de administración -->
                        <div class="admin-controls-inline">
                            <button onclick="openEditRespuestaModal({{ $respuesta->id }})" class="btn-admin-small">Editar</button>
                            <form action="{{ route('admin.respuestas.destroy', $respuesta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta respuesta?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-small btn-admin-delete">Eliminar</button>
                            </form>
                        </div>
                    @endauth
                </div>

            </div>
        @empty
            <div style="text-align: center; padding: 4rem 2rem; background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 4px;">
                <p style="color: var(--text-muted); font-style: italic;">Aún no se han enviado respuestas o reflexiones.</p>
                <a href="{{ route('cartas') }}" class="btn btn-secondary" style="margin-top: 1.5rem;">
                    Ir a las Cartas
                </a>
            </div>
        @endforelse
    </div>

</div>

<!-- MODAL RESPUESTAS (ADMIN) -->
@auth
<div id="respuesta-modal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <h3 class="title-serif" style="font-size: 1.8rem; margin-bottom: 1.5rem;">Editar Respuesta</h3>
        <form id="respuesta-form" method="POST" action="">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="respuesta-comentario">Comentario / Respuesta</label>
                <textarea name="comentario" id="respuesta-comentario" class="form-control" style="min-height: 150px; resize: vertical;" required></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="closeRespuestaModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection

@section('scripts')
@auth
<script>
    const respModal = document.getElementById('respuesta-modal');
    const respForm = document.getElementById('respuesta-form');
    const respComment = document.getElementById('respuesta-comentario');

    function openEditRespuestaModal(id) {
        respForm.action = `/admin/respuestas/${id}`;
        const rawComment = document.getElementById(`respuesta-raw-comentario-${id}`).innerText;
        respComment.value = rawComment;
        respModal.style.display = 'flex';
    }

    function closeRespuestaModal() {
        respModal.style.display = 'none';
    }

    // Cerrar al hacer clic fuera del card
    window.onclick = function(event) {
        if (event.target == respModal) {
            closeRespuestaModal();
        }
    }
</script>
@endauth
@endsection
