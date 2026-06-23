@extends('layouts.app')

@section('styles')
<style>
    .cartas-container {
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

    .letters-list {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        margin-top: 3rem;
    }

    .letter-envelope {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: var(--transition-smooth);
        cursor: pointer;
    }

    .letter-envelope:hover {
        border-color: var(--accent-gold);
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    /* Cabecera del Sobre */
    .envelope-header {
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--bg-secondary);
        position: relative;
        z-index: 2;
    }

    .envelope-meta {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
    }

    .envelope-date {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .envelope-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 500;
        color: var(--text-main);
        transition: var(--transition-smooth);
    }

    .letter-envelope.expanded .envelope-title {
        color: var(--accent-rose);
        font-style: italic;
    }

    .envelope-indicators {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .status-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.6rem;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .status-new {
        background-color: #FEF3C7;
        color: #D97706;
    }

    .status-read {
        background-color: #F3F4F6;
        color: #9CA3AF;
    }

    .toggle-arrow {
        color: var(--accent-gold);
        font-size: 1.2rem;
        transition: transform 0.4s ease;
    }

    .letter-envelope.expanded .toggle-arrow {
        transform: rotate(180deg);
    }

    /* Cuerpo de la Carta (Contenido Desplegable) */
    .envelope-content-wrapper {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        border-top: 0 solid var(--border-color);
    }

    .letter-envelope.expanded .envelope-content-wrapper {
        border-top-width: 1px;
    }

    .envelope-body {
        padding: 3rem 2rem;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.35rem;
        line-height: 1.8;
        color: var(--text-main);
        white-space: pre-line;
        background-color: #FAF9F6;
        position: relative;
        text-align: justify;
    }

    /* Sección de Respuestas dentro de la Carta */
    .responses-section {
        background-color: var(--bg-secondary);
        border-top: 1px solid var(--border-color);
        padding: 2.5rem 2rem;
    }

    .responses-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-style: italic;
        margin-bottom: 1.5rem;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .responses-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background-color: var(--border-color);
    }

    .responses-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .response-item {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        border-radius: 4px;
        position: relative;
    }

    .response-item-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .response-item-text {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    /* Formulario para Responder */
    .response-form-title {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .response-form textarea {
        width: 100%;
        min-height: 120px;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        resize: vertical;
        transition: var(--transition-smooth);
        margin-bottom: 1rem;
    }

    .response-form textarea:focus {
        outline: none;
        border-color: var(--accent-rose);
        background-color: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(176, 133, 125, 0.15);
    }

    .response-form-footer {
        display: flex;
        justify-content: flex-end;
    }

    /* CONTROLES DE ADMINISTRACIÓN */
    .admin-controls-inline {
        display: flex;
        gap: 0.5rem;
        margin-left: 1rem;
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
        max-width: 650px;
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
        .letters-list {
            gap: 1.25rem;
            margin-top: 2rem;
        }

        .envelope-header {
            padding: 1.25rem 1rem;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .envelope-meta {
            flex: 1;
        }

        .envelope-title {
            font-size: 1.35rem;
        }

        .envelope-indicators {
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
        }

        .admin-controls-inline {
            margin-left: 0;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .envelope-body {
            padding: 2rem 1.25rem;
            font-size: 1.15rem;
            text-align: left;
        }

        .responses-section {
            padding: 2rem 1.1rem;
        }

        .response-form textarea,
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
<div class="cartas-container">
    
    <!-- CABECERA -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span class="subtitle-sans">Sinceridad y Reflexión</span>
        <h1 class="title-serif" style="display: inline-flex; align-items: center; gap: 1rem; justify-content: center; width: 100%;">
            Cartas para Ti
            @auth
                <button onclick="openAddModal()" class="btn btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.75rem;">+ Nueva Carta</button>
            @endauth
        </h1>
        <p class="lead-text" style="margin: 0.5rem auto 0 auto;">
            En estas cartas quiero plasmar las palabras que me dan miedo y vergúnza decirte, lo que estoy aprendiendo y mis compromisos que quiero plasmar. Siéntete libre de responder en cualquier carta si deseas compartir lo que sientes.
        </p>
    </div>

    <!-- LISTADO DE CARTAS -->
    <div class="letters-list">
        @forelse($cartas as $carta)
            <div class="letter-envelope" id="envelope-{{ $carta->id }}">
                
                <!-- Encabezado del sobre -->
                <div class="envelope-header" onclick="toggleLetter({{ $carta->id }})">
                    <div class="envelope-meta">
                        <span class="envelope-date">Escrita el <span id="carta-date-raw-{{ $carta->id }}">{{ \Carbon\Carbon::parse($carta->fecha)->locale('es')->isoFormat('LL') }}</span></span>
                        <h2 class="envelope-title" id="carta-title-{{ $carta->id }}">{{ $carta->titulo }}</h2>
                        <!-- Guardamos datos ocultos para la edición -->
                        <span id="carta-raw-date-{{ $carta->id }}" style="display:none;">{{ $carta->fecha }}</span>
                        <span id="carta-raw-content-{{ $carta->id }}" style="display:none;">{{ $carta->contenido }}</span>
                    </div>
                    
                    <div class="envelope-indicators" onclick="event.stopPropagation()">
                        @if($carta->leida)
                            <span class="status-badge status-read">Leída</span>
                        @else
                            <span class="status-badge status-new">Nueva</span>
                        @endif
                        
                        @auth
                            <!-- Controles de Administración -->
                            <div class="admin-controls-inline">
                                <button onclick="openEditModal({{ $carta->id }})" class="btn-admin-small">Editar</button>
                                <form action="{{ route('admin.cartas.destroy', $carta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta carta y todas sus respuestas?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-small btn-admin-delete">Eliminar</button>
                                </form>
                            </div>
                        @endauth
                        
                        <!-- Flecha indicadora de apertura -->
                        <span class="toggle-arrow" onclick="toggleLetter({{ $carta->id }})" style="cursor: pointer; padding: 0 0.5rem;">▼</span>
                    </div>
                </div>

                <!-- Contenido deslizable de la carta -->
                <div class="envelope-content-wrapper" id="content-wrapper-{{ $carta->id }}">
                    
                    <!-- Cuerpo de la carta -->
                    <div class="envelope-body">
                        {{ $carta->contenido }}
                    </div>

                    <!-- Sección de Respuestas -->
                    <div class="responses-section" onclick="event.stopPropagation()">
                        <h3 class="responses-title">Respuestas e Interacciones</h3>
                        
                        <div class="responses-list">
                            @forelse($carta->respuestas as $respuesta)
                                <div class="response-item">
                                    <div class="response-item-meta">
                                        <span style="font-weight:600; color: var(--accent-rose);">{{ $respuesta->nombre }}</span>
                                        <span>{{ \Carbon\Carbon::parse($respuesta->created_at)->setTimezone('America/Santiago')->locale('es')->isoFormat('LL [a las] HH:mm') }}</span>
                                    </div>
                                    <div class="response-item-text" id="respuesta-text-{{ $respuesta->id }}">
                                        {{ $respuesta->comentario }}
                                    </div>
                                    <!-- Guardar comentario para edición por admin -->
                                    <span id="respuesta-raw-comentario-{{ $respuesta->id }}" style="display:none;">{{ $respuesta->comentario }}</span>

                                    @auth
                                        <!-- Botones para gestionar la respuesta -->
                                        <div class="admin-controls-inline" style="border-top:none; padding-top:0.5rem; margin-top:0.5rem;">
                                            <button onclick="openEditRespuestaModal({{ $respuesta->id }})" class="btn-admin-small">Editar</button>
                                            <form action="{{ route('admin.respuestas.destroy', $respuesta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta respuesta?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-admin-small btn-admin-delete">Eliminar</button>
                                            </form>
                                        </div>
                                    @endauth
                                </div>
                            @empty
                                <p style="font-size: 0.9rem; color: var(--text-muted); font-style: italic; text-align: center; margin: 1rem 0;">
                                    Aún no hay respuestas en esta carta. Eres libre de dejar tu comentario abajo cuando estés lista.
                                </p>
                            @endforelse
                        </div>

                        <!-- Formulario para responder -->
                        @if(session()->has('visitor_name'))
                            <div class="response-form-title">Responder como **{{ session('visitor_name') }}**:</div>
                        @else
                            <div class="response-form-title">Dejar una respuesta o pensamiento</div>
                        @endif

                        <form action="{{ route('respuestas.store', $carta->id) }}" method="POST" class="response-form">
                            @csrf
                            
                            @if(!session()->has('visitor_name'))
                                <div class="form-group" style="margin-bottom: 1.25rem;">
                                    <label for="nombre-respuesta-{{ $carta->id }}">Tu Nombre</label>
                                    <input type="text" name="nombre" id="nombre-respuesta-{{ $carta->id }}" class="form-control" required placeholder="Dinos tu nombre para responder (ej. Feñi)" style="background-color: var(--bg-primary);">
                                </div>
                            @endif

                            <textarea name="comentario" placeholder="Escribe aquí lo que sientes, tus pensamientos o cualquier cosa que desees expresarme..." required></textarea>
                            
                            <div class="response-form-footer">
                                <button type="submit" class="btn btn-primary">
                                    Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        @empty
            <div style="text-align: center; padding: 4rem 2rem; background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 4px;">
                <p style="color: var(--text-muted); font-style: italic;">No hay cartas disponibles por el momento.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- MODAL CARTAS (ADMIN) -->
@auth
<div id="carta-modal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <h3 id="modal-title" class="title-serif" style="font-size: 1.8rem; margin-bottom: 1.5rem;">Escribir Carta</h3>
        <form id="carta-form" method="POST" action="{{ route('admin.cartas.store') }}">
            @csrf
            <div id="form-method-container"></div>
            
            <div class="form-group">
                <label for="carta-titulo">Título de la Carta</label>
                <input type="text" name="titulo" id="carta-titulo" class="form-control" required placeholder="Ej. El valor de reconocer mis errores">
            </div>

            <div class="form-group">
                <label for="carta-fecha">Fecha de Escritura</label>
                <input type="date" name="fecha" id="carta-fecha" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            
            <div class="form-group">
                <label for="carta-contenido">Contenido de la Carta</label>
                <textarea name="contenido" id="carta-contenido" class="form-control" style="min-height: 220px; resize: vertical;" required placeholder="Escribe tu reflexión..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Carta</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL RESPUESTAS (ADMIN) -->
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
<script>
    // Función para alternar el despliegue de una carta
    function toggleLetter(id) {
        const envelope = document.getElementById(`envelope-${id}`);
        const wrapper = document.getElementById(`content-wrapper-${id}`);
        
        if (envelope.classList.contains('expanded')) {
            // Contraer
            wrapper.style.maxHeight = '0px';
            envelope.classList.remove('expanded');
        } else {
            // Expandir
            // Cerrar cualquier otra abierta
            document.querySelectorAll('.letter-envelope.expanded').forEach(el => {
                const openId = el.id.replace('envelope-', '');
                if (openId != id) {
                    document.getElementById(`content-wrapper-${openId}`).style.maxHeight = '0px';
                    el.classList.remove('expanded');
                }
            });

            // Medir y expandir
            const contentHeight = wrapper.scrollHeight;
            wrapper.style.maxHeight = contentHeight + 'px';
            envelope.classList.add('expanded');
            
            // Reajustar altura después de transicionar
            setTimeout(() => {
                if (envelope.classList.contains('expanded')) {
                    wrapper.style.maxHeight = 'none';
                }
            }, 600);

            // AJAX: Marcar como leída automáticamente al expandirse (solo si está en estado 'Nueva')
            const badge = envelope.querySelector('.status-badge');
            if (badge && badge.classList.contains('status-new')) {
                marcarCartaComoLeida(id, badge);
            }
        }
    }

    // Función AJAX para registrar la lectura
    function marcarCartaComoLeida(id, badgeElement) {
        fetch(`/cartas/${id}/leer`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && !data.already_read) {
                // Actualizar estilo visual del badge
                badgeElement.className = 'status-badge status-read';
                badgeElement.innerText = 'Leída';
            }
        })
        .catch(err => console.error("Error al registrar lectura de carta:", err));
    }

    // Si abrimos la página con un Hash directo a una carta, desplegarla
    document.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        if (hash && hash.startsWith('#envelope-')) {
            const id = hash.replace('#envelope-', '');
            const targetEnvelope = document.getElementById(`envelope-${id}`);
            if (targetEnvelope) {
                // Pequeño retardo para asegurar que las animaciones de carga finalicen
                setTimeout(() => {
                    toggleLetter(id);
                    targetEnvelope.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 400);
            }
        }
    });
</script>

@auth
<script>
    const modal = document.getElementById('carta-modal');
    const form = document.getElementById('carta-form');
    const modalTitle = document.getElementById('modal-title');
    const inputTitulo = document.getElementById('carta-titulo');
    const inputFecha = document.getElementById('carta-fecha');
    const inputContenido = document.getElementById('carta-contenido');
    const methodContainer = document.getElementById('form-method-container');

    function openAddModal() {
        modalTitle.innerText = "Escribir Carta";
        form.action = "{{ route('admin.cartas.store') }}";
        methodContainer.innerHTML = "";
        inputTitulo.value = "";
        inputFecha.value = "{{ date('Y-m-d') }}";
        inputContenido.value = "";
        modal.style.display = 'flex';
    }

    function openEditModal(id) {
        modalTitle.innerText = "Editar Carta";
        form.action = `/admin/cartas/${id}`;
        methodContainer.innerHTML = '@method("PUT")';
        
        // Obtener datos del DOM
        const currentTitle = document.getElementById(`carta-title-${id}`).innerText;
        const currentFecha = document.getElementById(`carta-raw-date-${id}`).innerText;
        const currentContenido = document.getElementById(`carta-raw-content-${id}`).innerText;
        
        inputTitulo.value = currentTitle;
        inputFecha.value = currentFecha;
        inputContenido.value = currentContenido;
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // Modal para editar respuestas
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
        if (event.target == modal) {
            closeModal();
        } else if (event.target == respModal) {
            closeRespuestaModal();
        }
    }
</script>
@endauth
@endsection
