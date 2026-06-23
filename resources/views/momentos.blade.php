@extends('layouts.app')

@section('styles')
<style>
    .momentos-container {
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

    /* Estilos del Timeline */
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 4rem auto 0 auto;
        padding: 0 1rem;
    }

    /* Línea vertical central */
    .timeline::after {
        content: '';
        position: absolute;
        width: 1px;
        background-color: var(--accent-gold);
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -0.5px;
    }

    .timeline-item {
        padding: 1rem 0;
        width: 50%;
        position: relative;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUpItem 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.3s; }
    .timeline-item:nth-child(3) { animation-delay: 0.5s; }

    @keyframes fadeInUpItem {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Alinear izquierda / derecha */
    .timeline-item-left {
        left: 0;
        padding-right: 3rem;
    }

    .timeline-item-right {
        left: 50%;
        padding-left: 3rem;
    }

    /* Puntos indicadores en la línea */
    .timeline-badge {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--bg-primary);
        border: 2px solid var(--accent-gold);
        position: absolute;
        top: 2rem;
        z-index: 10;
        transition: var(--transition-smooth);
    }

    .timeline-item-left .timeline-badge {
        right: -6px;
    }

    .timeline-item-right .timeline-badge {
        left: -6px;
    }

    .timeline-item:hover .timeline-badge {
        background-color: var(--accent-rose);
        border-color: var(--text-main);
        transform: scale(1.3);
    }

    /* Tarjeta del Recuerdo (Estilo Polaroid/Sobrio) */
    .moment-card {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
    }

    .moment-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-gold);
    }

    .moment-date {
        font-size: 0.8rem;
        color: var(--accent-rose);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0.5rem;
        display: block;
    }

    .moment-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 1rem;
    }

    /* Contenedor de la Foto con fallback */
    .moment-photo-container {
        width: 100%;
        height: 200px;
        background-color: #FAF8F5;
        border: 1px solid var(--border-color);
        border-radius: 2px;
        margin-bottom: 1.25rem;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .moment-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-smooth);
    }

    .moment-card:hover .moment-img {
        transform: scale(1.05);
    }

    .moment-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        text-align: center;
        color: var(--text-muted);
        background: linear-gradient(135deg, #FAF8F5 0%, #EFECE7 100%);
    }

    .placeholder-icon {
        font-size: 1.8rem;
        color: var(--accent-gold);
        margin-bottom: 0.5rem;
    }

    .placeholder-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-style: italic;
    }

    .moment-desc {
        font-size: 0.92rem;
        line-height: 1.6;
        color: var(--text-muted);
        text-align: justify;
    }

    /* CONTROLES DE ADMINISTRACIÓN */
    .admin-controls-inline {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px dashed var(--border-color);
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

    /* Adaptabilidad Móvil */
    @media (max-width: 768px) {
        .timeline {
            margin: 2rem auto 0 auto;
        }

        .timeline::after {
            left: 15px;
        }

        .timeline-item {
            width: 100%;
            left: 0 !important;
            padding-left: 2.2rem !important;
            padding-right: 0 !important;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .timeline-badge {
            left: 9px !important;
            right: auto !important;
            top: 1.5rem;
        }

        .moment-card {
            padding: 1.25rem;
        }

        .moment-title {
            font-size: 1.45rem;
            margin-bottom: 0.75rem;
        }

        .moment-photo-container {
            height: 180px;
            margin-bottom: 1rem;
        }

        .moment-desc {
            text-align: left;
            font-size: 0.9rem;
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
<div class="momentos-container">
    
    <!-- CABECERA -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <span class="subtitle-sans">Nuestra Historia</span>
        <h1 class="title-serif" style="display: inline-flex; align-items: center; gap: 1rem; justify-content: center; width: 100%;">
            Momentos Especiales
            @auth
                <button onclick="openAddModal()" class="btn btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.75rem;">+ Agregar Momento</button>
            @endauth
        </h1>
        <p class="lead-text" style="margin: 0.5rem auto 0 auto;">
            Una pequeña recopilación de los días felices que compartimos en algun momento, que no quiero olvidar jamas. Los mantengo aquí no como nostalgia vacía, sino como un recordatorio del cariño.
        </p>
    </div>

    <!-- TIMELINE -->
    <div class="timeline">
        @forelse($momentos as $index => $momento)
            <div class="timeline-item {{ $index % 2 == 0 ? 'timeline-item-left' : 'timeline-item-right' }}">
                <!-- Punto en el timeline -->
                <div class="timeline-badge"></div>
                
                <!-- Tarjeta -->
                <div class="moment-card" id="momento-card-{{ $momento->id }}">
                    <span class="moment-date">{{ \Carbon\Carbon::parse($momento->fecha)->locale('es')->isoFormat('LL') }}</span>
                    
                    <!-- Imagen con fallback inteligente por si no existe el archivo -->
                    <div class="moment-photo-container">
                        @if($momento->foto)
                            <img src="{{ asset('images/' . $momento->foto) }}" alt="{{ $momento->titulo }}" class="moment-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        <div class="moment-placeholder" style="display: {{ $momento->foto ? 'none' : 'flex' }};">
                            <span class="placeholder-icon">✦</span>
                            <span class="placeholder-text">Instante guardado en el corazón</span>
                        </div>
                    </div>

                    <h2 class="moment-title" id="momento-title-{{ $momento->id }}">{{ $momento->titulo }}</h2>
                    <p class="moment-desc" id="momento-desc-{{ $momento->id }}">{{ $momento->descripcion }}</p>
                    
                    <!-- Guardar datos en crudo para la edición -->
                    <span id="momento-raw-date-{{ $momento->id }}" style="display:none;">{{ $momento->fecha }}</span>
                    <span id="momento-raw-hasphoto-{{ $momento->id }}" style="display:none;">{{ $momento->foto ? 'true' : 'false' }}</span>

                    @auth
                        <!-- Controles de Administración -->
                        <div class="admin-controls-inline">
                            <button onclick="openEditModal({{ $momento->id }})" class="btn-admin-small">Editar</button>
                            <form action="{{ route('admin.momentos.destroy', $momento->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este recuerdo?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-small btn-admin-delete">Eliminar</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 4rem 2rem; background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 4px; width: 100%;">
                <p style="color: var(--text-muted); font-style: italic;">No hay momentos registrados todavía.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- MODAL MOMENTOS (ADMIN) -->
@auth
<div id="momento-modal" class="modal-overlay" style="display: none;">
    <div class="modal-card">
        <h3 id="modal-title" class="title-serif" style="font-size: 1.8rem; margin-bottom: 1.5rem;">Agregar Momento</h3>
        <form id="momento-form" method="POST" action="{{ route('admin.momentos.store') }}" enctype="multipart/form-data">
            @csrf
            <div id="form-method-container"></div>
            
            <div class="form-group">
                <label for="momento-titulo">Título del Momento</label>
                <input type="text" name="titulo" id="momento-titulo" class="form-control" required placeholder="Ej. Nuestra primera cita">
            </div>

            <div class="form-group">
                <label for="momento-fecha">Fecha del Recuerdo</label>
                <input type="date" name="fecha" id="momento-fecha" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="momento-foto">Fotografía (Opcional)</label>
                <input type="file" name="foto" id="momento-foto" class="form-control" accept="image/*">
                <small style="color: var(--text-muted); font-size: 0.75rem; margin-top: 0.25rem;">Formatos: JPG, PNG, WEBP, GIF. Máx 5MB.</small>
                <div id="current-photo-info" style="display: none; font-size: 0.8rem; color: var(--accent-rose); margin-top: 0.5rem; font-style: italic;">
                    * Ya hay una foto cargada. Sube una nueva para reemplazarla.
                </div>
            </div>
            
            <div class="form-group">
                <label for="momento-descripcion">Descripción / Historia</label>
                <textarea name="descripcion" id="momento-descripcion" class="form-control" style="min-height: 120px; resize: vertical;" required placeholder="Describe lo que ocurrió ese día..."></textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Recuerdo</button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection

@section('scripts')
@auth
<script>
    const modal = document.getElementById('momento-modal');
    const form = document.getElementById('momento-form');
    const modalTitle = document.getElementById('modal-title');
    const inputTitulo = document.getElementById('momento-titulo');
    const inputFecha = document.getElementById('momento-fecha');
    const inputDesc = document.getElementById('momento-descripcion');
    const inputFoto = document.getElementById('momento-foto');
    const currentPhotoInfo = document.getElementById('current-photo-info');
    const methodContainer = document.getElementById('form-method-container');

    function openAddModal() {
        modalTitle.innerText = "Agregar Momento";
        form.action = "{{ route('admin.momentos.store') }}";
        methodContainer.innerHTML = "";
        inputTitulo.value = "";
        inputFecha.value = "";
        inputDesc.value = "";
        inputFoto.value = "";
        inputFoto.required = false;
        currentPhotoInfo.style.display = 'none';
        modal.style.display = 'flex';
    }

    function openEditModal(id) {
        modalTitle.innerText = "Editar Momento";
        form.action = `/admin/momentos/${id}`;
        methodContainer.innerHTML = '@method("PUT")';
        
        // Obtener datos del DOM
        const currentTitle = document.getElementById(`momento-title-${id}`).innerText;
        const currentFecha = document.getElementById(`momento-raw-date-${id}`).innerText;
        const currentDesc = document.getElementById(`momento-desc-${id}`).innerText;
        const hasPhoto = document.getElementById(`momento-raw-hasphoto-${id}`).innerText === 'true';
        
        inputTitulo.value = currentTitle;
        inputFecha.value = currentFecha;
        inputDesc.value = currentDesc;
        inputFoto.value = "";
        inputFoto.required = false;
        
        if (hasPhoto) {
            currentPhotoInfo.style.display = 'block';
        } else {
            currentPhotoInfo.style.display = 'none';
        }
        
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // Cerrar al hacer clic fuera del card
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endauth
@endsection
