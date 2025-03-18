<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('index') }}">
            <img id="logo" src="{{ asset('img/logo_green.png') }}" alt="memorycard">
        </a>

        <!-- Botão para mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Itens do menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Inicio</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->is('/sobre') ? 'active' : '' }}" href="{{ url('/sobre') }}">Sobre</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('sugestoes') ? 'active' : '' }}" href="{{ url('/sugestoes') }}">Sugestões</a>
                </li>
                <li class="nav-item dropdown" style="max-width: 100%;">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" onclick="markNotificationsAsRead()">
                        <i class="fa-solid fa-bell"></i>
                        {{-- <span class="badge bg-danger" id="notification-count">0</span> --}}
                    </a>
                    <div>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" id="notification-count">
                            0
                        <span class="visually-hidden">unread messages</span>
                    </div>
                    <ul class="dropdown-menu" id="notification-list" style="max-width: 50vh">
                        <li class="dropdown-item text-muted" style="font-size: smaller;">Carregando...</li>
                    </ul>
                </li>
            </ul>

            <!-- Botões de Login/Cadastro -->
            <ul class="navbar-nav ms-3">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ request()->is('/changelog') ? 'active' : '' }}" href="{{ route("changelog") }}">
                                    Changelog
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item {{ request()->is('/logs') ? 'active' : '' }}" href="{{ route("logs.index") }}">
                                    Logs
                                </a>
                            </li> --}}
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('user.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <button class="btn btn-custom-secondary" data-bs-toggle="modal" data-bs-target="#userLogin">Entrar</button>
                        {{-- <a class="btn btn-custom" href="{{ route('user.loginView') }}">Entrar</a> --}}
                    </li>
                    <li class="nav-item">
                        {{-- <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#userRegister">Regitrar-se</button> --}}
                        <a class="btn btn-custom" href="{{ route('user.registerView') }}">Regitrar-se</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>