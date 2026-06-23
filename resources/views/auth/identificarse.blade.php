@extends('layouts.app')

@section('styles')
<style>
    .visitor-container {
        max-width: 420px;
        margin: 4rem auto;
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

    .visitor-card {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 3rem 2.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
        text-align: center;
    }

    .visitor-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-gold), var(--accent-rose));
    }

    .visitor-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        font-weight: 400;
        margin-bottom: 1rem;
        color: var(--text-main);
    }

    .visitor-subtitle {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        text-align: left;
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
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        transition: var(--transition-smooth);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent-rose);
        background-color: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(176, 133, 125, 0.15);
    }

    @media (max-width: 768px) {
        .visitor-container {
            margin: 2rem auto;
            max-width: 92%;
        }

        .visitor-card {
            padding: 2rem 1.25rem;
        }

        .visitor-title {
            font-size: 1.8rem;
        }

        .form-control {
            font-size: 16px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="visitor-container">
    
    <div class="visitor-card">
        <h1 class="visitor-title">Identificarse</h1>
        <p class="visitor-subtitle">
            Dinos tu nombre para personalizar tu espacio de lectura. Se guardará de forma privada en tu sesión para firmar tus comentarios.
        </p>

        <form action="{{ route('identificar.submit') }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre">Tu Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Feñi" required autofocus max="100">
            </div>

            <!-- Botón de Envío -->
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem;">
                Ingresar al Espacio
            </button>
        </form>
    </div>

</div>
@endsection
