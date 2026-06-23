@extends('layouts.app')

@section('styles')
<style>
    .login-container {
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

    .login-card {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 3rem 2.5rem;
        box-shadow: var(--card-shadow);
        position: relative;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-gold), var(--accent-rose));
    }

    .login-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        font-weight: 400;
        text-align: center;
        margin-bottom: 2rem;
        color: var(--text-main);
    }

    .form-group {
        margin-bottom: 1.5rem;
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

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        cursor: pointer;
        user-select: none;
    }

    .form-check input {
        cursor: pointer;
        accent-color: var(--accent-rose);
    }

    .form-check label {
        font-size: 0.85rem;
        color: var(--text-muted);
        cursor: pointer;
    }

    .error-list {
        background-color: #FEF2F2;
        border-left: 3px solid #EF4444;
        color: #B91C1C;
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        list-style: none;
    }

    @media (max-width: 768px) {
        .login-container {
            margin: 2rem auto;
            max-width: 92%;
        }

        .login-card {
            padding: 2rem 1.25rem;
        }

        .login-title {
            font-size: 1.8rem;
        }

        .form-control {
            font-size: 16px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    
    <div class="login-card">
        <h1 class="login-title">Administración</h1>
        
        <!-- Mostrar errores de autenticación -->
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="admin@example.com">
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
            </div>

            <!-- Recordarme -->
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Mantener sesión iniciada</label>
            </div>

            <!-- Botón de Envío -->
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem;">
                Iniciar Sesión
            </button>
        </form>
    </div>

</div>
@endsection
