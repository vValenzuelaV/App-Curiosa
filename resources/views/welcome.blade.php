@extends('layouts.app')

@section('styles')
<style>
    .welcome-container {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 1s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-section {
        text-align: center;
        padding: 3rem 1rem 4rem 1rem;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 4rem;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        font-weight: 300;
        font-style: italic;
        margin-bottom: 1.5rem;
        color: var(--text-main);
    }

    .heart-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .heart-divider::before, .heart-divider::after {
        content: '';
        height: 1px;
        width: 60px;
        background-color: var(--accent-gold);
    }

    .heart-icon {
        color: var(--accent-rose);
        font-size: 1.2rem;
    }

    .intro-letter {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 3rem;
        box-shadow: var(--card-shadow);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.35rem;
        line-height: 1.8;
        color: var(--text-main);
        max-width: 700px;
        margin: 0 auto 4rem auto;
        position: relative;
        text-align: justify;
    }

    .intro-letter::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-gold), var(--accent-rose));
    }

    .intro-signature {
        text-align: right;
        margin-top: 2rem;
        font-style: italic;
        font-size: 1.45rem;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-bottom: 4rem;
    }

    .value-card {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 2.2rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        position: relative;
    }

    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-gold);
    }

    .value-icon {
        color: var(--accent-gold);
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .value-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--text-main);
    }

    .value-desc {
        font-size: 0.92rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .action-row {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 3rem;
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

    .admin-controls-inline {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: auto;
        padding-top: 1rem;
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

    @media (max-width: 768px) {
        .hero-section {
            padding: 2rem 1rem 2.5rem 1rem;
            margin-bottom: 2.5rem;
        }

        .hero-title {
            font-size: 2.2rem;
            line-height: 1.3;
        }

        .intro-letter {
            padding: 2rem 1.25rem;
            font-size: 1.15rem;
            text-align: left;
            margin-bottom: 2.5rem;
        }

        .intro-signature {
            font-size: 1.3rem;
            margin-top: 1.5rem;
        }

        .values-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .action-row {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-row .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="welcome-container">
    
    <!-- SECCIÓN HERO -->
    <div class="hero-section">
        <span class="subtitle-sans">Un espacio privado para nosotros</span>
        <h1 class="hero-title">Queriendo comprenderme como me necesito</h1>
        <div class="heart-divider">
            <span class="heart-icon">✦</span>
        </div>
    </div>

    <!-- CARTA DE INTRODUCCIÓN -->
    <div class="intro-letter">
        <p>
            Fernadna, la verad se que las palabras son fragiles y más si no puedo hacer nada por tener esa cercania que me gustaria tener y la cual perdi todo el derecho, las disculpas solo tienen valor si vienen acompañadas de cambios verdaderos lo tengo más que claro, hay tantas cosas que me gustaria poder dercirte pero las cuales yo mismo arranque de mi instancia para decirlas.
        </p>
        <br>
        <p>
            Por eso diseñé este sitio. Buscaba esa posibilidad de poder darte algunas de las tantas cosas que quisera darte sin presionarte o incomdarte más de lo que mi precencia lo hace.
        </p>
        <br>
	<p>
	    Toma este espacio y eres libre de responder alguna de las cartas que te vaya escribiendo si lo ves asi.
	</p>
        <div class="intro-signature">Con amor</div>
    </div>

    <!-- ENLACES DE ACCIÓN -->
    <div class="action-row">
        <a href="{{ route('cartas') }}" class="btn btn-primary">
            Leer mis Cartas
        </a>
        <a href="{{ route('momentos') }}" class="btn btn-secondary">
            Ver Momentos Especiales
        </a>
        <a href="{{ route('musica') }}" class="btn btn-secondary">
            ♫ Nuestra Música
        </a>
        <a href="{{ route('dibujos') }}" class="btn btn-secondary">
            ✏ Nuestros Dibujos
        </a>
    </div>

</div>
@endsection

@section('scripts')
@auth
<script>
    const modal = document.getElementById('valor-modal');
    const form = document.getElementById('valor-form');
    const modalTitle = document.getElementById('modal-title');
    const inputTitulo = document.getElementById('valor-titulo');
    const inputDesc = document.getElementById('valor-descripcion');
    const methodContainer = document.getElementById('form-method-container');

    function openAddModal() {
        modalTitle.innerText = "Agregar Compromiso";
        form.action = "{{ route('admin.valores.store') }}";
        methodContainer.innerHTML = "";
        inputTitulo.value = "";
        inputDesc.value = "";
        modal.style.display = 'flex';
    }

    function openEditModal(id) {
        modalTitle.innerText = "Editar Compromiso";
        form.action = `/admin/valores/${id}`;
        methodContainer.innerHTML = '@method("PUT")';
        
        // Obtener datos actuales de la interfaz
        const currentTitle = document.getElementById(`valor-title-${id}`).innerText;
        const currentDesc = document.getElementById(`valor-desc-${id}`).innerText;
        
        inputTitulo.value = currentTitle;
        inputDesc.value = currentDesc;
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
