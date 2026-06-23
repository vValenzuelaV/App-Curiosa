<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Para Feñi | Espacio de Reflexión</title>

    <!-- Google Fonts: Cormorant Garamond para textos íntimos y cartas; Inter para controles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* CSS RESET & VARIABLES */
        :root {
            --bg-primary: #F9F6F0; /* Crema cálido suave (hoja de carta) */
            --bg-secondary: #FFFFFF;
            --text-main: #2C2623; /* Espresso oscuro, más suave que el negro puro */
            --text-muted: #6B615B;
            --accent-gold: #C0A080; /* Oro viejo / bronce */
            --accent-rose: #B0857D; /* Rosa empolvado */
            --border-color: #E8E2D9;
            --card-shadow: 0 4px 20px rgba(44, 38, 35, 0.04);
            --card-shadow-hover: 0 10px 30px rgba(44, 38, 35, 0.08);
            --transition-smooth: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* HEADER & NAVIGATION */
        header {
            background-color: rgba(249, 246, 240, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: var(--transition-smooth);
        }

        .nav-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-link {
            text-decoration: none;
            color: var(--text-main);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: var(--transition-smooth);
        }

        .logo-link:hover {
            color: var(--accent-rose);
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
            padding: 0.25rem 0;
            transition: var(--transition-smooth);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--text-main);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 1px;
            bottom: 0;
            left: 0;
            background-color: var(--accent-gold);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* MAIN CONTENT */
        main {
            flex: 1;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        /* FOOTER */
        footer {
            border-top: 1px solid var(--border-color);
            padding: 2.5rem 2rem;
            text-align: center;
            background-color: var(--bg-secondary);
        }

        .footer-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-style: italic;
            color: var(--text-muted);
        }

        .footer-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* GENERAL STYLES & UTILITIES */
        .title-serif {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 1.5rem;
            color: var(--text-main);
            line-height: 1.2;
        }

        .subtitle-sans {
            font-size: 0.95rem;
            color: var(--accent-rose);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .lead-text {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
            max-width: 650px;
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.8rem 1.8rem;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-radius: 4px;
            text-decoration: none;
            transition: var(--transition-smooth);
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--text-main);
            color: var(--bg-primary);
        }

        .btn-primary:hover {
            background-color: var(--accent-rose);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            border-color: var(--accent-gold);
            color: var(--text-main);
        }

        .btn-secondary:hover {
            background-color: var(--bg-primary);
            border-color: var(--text-main);
            transform: translateY(-2px);
        }

        /* MOBILE BOTTOM NAV BAR */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 64px;
            background-color: rgba(249, 246, 240, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid var(--border-color);
            z-index: 999;
            justify-content: space-around;
            align-items: center;
            padding-bottom: env(safe-area-inset-bottom, 0px);
            box-shadow: 0 -4px 20px rgba(44, 38, 35, 0.05);
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--text-muted);
            flex: 1;
            height: 100%;
            transition: var(--transition-smooth);
            gap: 4px;
        }

        .mobile-nav-icon {
            width: 20px;
            height: 20px;
            stroke-width: 2;
            transition: var(--transition-smooth);
        }

        .mobile-nav-label {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .mobile-nav-item.active {
            color: var(--accent-rose);
        }

        .mobile-nav-item.active .mobile-nav-icon {
            color: var(--accent-rose);
            stroke-width: 2.5;
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            body {
                padding-bottom: 74px;
                /* Evitar que el pie de página quede oculto por la barra móvil */
            }

            .mobile-bottom-nav {
                display: flex;
            }

            .nav-item-main {
                display: none !important;
                /* Ocultar enlaces de la cabecera superior en móvil */
            }

            .nav-container {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.25rem;
                gap: 0;
            }

            .logo-link {
                font-size: 1.35rem;
            }

            .nav-menu {
                gap: 0.75rem;
            }

            .nav-link {
                font-size: 0.8rem;
            }
        }

        /* ALERTS */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            border-left: 3px solid;
        }

        .alert-success {
            background-color: #F0F5F1;
            color: #385E3E;
            border-left-color: #7AA882;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- CABECERA -->
    <header>
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo-link">Espacio Continental </a>
            <nav>
                <ul class="nav-menu">
                    @if(session()->has('visitor_name') || Auth::check())
                        <li class="nav-item-main">
                            <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                                Inicio
                            </a>
                        </li>
                        <li class="nav-item-main">
                            <a href="{{ route('cartas') }}" class="nav-link {{ Route::is('cartas') ? 'active' : '' }}">
                                Cartas
                            </a>
                        </li>
                        <li class="nav-item-main">
                            <a href="{{ route('momentos') }}" class="nav-link {{ Route::is('momentos') ? 'active' : '' }}">
                                Momentos
                            </a>
                        </li>
                        <li class="nav-item-main">
                            <a href="{{ route('musica') }}" class="nav-link {{ Route::is('musica') ? 'active' : '' }}">
                                Música
                            </a>
                        </li>
                        <li class="nav-item-main">
                            <a href="{{ route('respuestas') }}"
                                class="nav-link {{ Route::is('respuestas') ? 'active' : '' }}">
                                Respuestas
                            </a>
                        </li>
                    @endif
                    @if(session()->has('visitor_name') && !Auth::check())
                        <li style="display: flex; align-items: center; gap: 0.25rem;">
                            <span class="nav-link"
                                style="color: var(--accent-rose); font-style: italic; font-weight: 500; cursor: default;">
                                Hola, {{ session('visitor_name') }}
                            </span>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('visitor-logout-form').submit();"
                                style="color: var(--text-muted); font-size: 0.75rem; text-decoration: none; padding-right: 0.5rem;"
                                title="Salir de la sesión de visitante">
                                (Salir)
                            </a>
                            <form id="visitor-logout-form" action="{{ route('identificar.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @elseif(!Auth::check())
                        <li>
                            <a href="{{ route('identificar') }}"
                                class="nav-link {{ Route::is('identificar') ? 'active' : '' }}">
                                Identificarse
                            </a>
                        </li>
                    @endif
                    @auth
                        <li>
                            <a href="#" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                style="color: var(--accent-rose); font-weight: 600;">
                                Salir (Admin)
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- PIE DE PÁGINA -->
    <footer>
        <div class="footer-sub">
            Espacio íntimo
            @guest
                <a href="{{ route('login') }}"
                    style="text-decoration: none; color: inherit; margin-left: 8px; opacity: 0.4;">• Acceder</a>
            @endguest
        </div>
    </footer>

    <!-- NAV MÓVIL INFERIOR -->
    @if(session()->has('visitor_name') || Auth::check())
        <div class="mobile-bottom-nav">
            <a href="{{ route('home') }}" class="mobile-nav-item {{ Route::is('home') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span class="mobile-nav-label">Inicio</span>
            </a>
            <a href="{{ route('cartas') }}" class="mobile-nav-item {{ Route::is('cartas') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
                <span class="mobile-nav-label">Cartas</span>
            </a>
            <a href="{{ route('momentos') }}" class="mobile-nav-item {{ Route::is('momentos') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3z" />
                    <circle cx="12" cy="13" r="3" />
                </svg>
                <span class="mobile-nav-label">Momentos</span>
            </a>
            <a href="{{ route('musica') }}" class="mobile-nav-item {{ Route::is('musica') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18V5l12-2v13" />
                    <circle cx="6" cy="18" r="3" />
                    <circle cx="18" cy="16" r="3" />
                </svg>
                <span class="mobile-nav-label">Música</span>
            </a>
            <a href="{{ route('respuestas') }}" class="mobile-nav-item {{ Route::is('respuestas') ? 'active' : '' }}">
                <svg class="mobile-nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
                <span class="mobile-nav-label">Respuestas</span>
            </a>
        </div>
    @endif

    @yield('scripts')
</body>
</html>
