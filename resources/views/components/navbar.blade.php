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
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('collections*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-layer-group me-1"></i>Coleções
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('collections.index') }}">
                                <i class="fas fa-list me-2"></i>Ver Todas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('collections.explore') }}">
                                <i class="fas fa-compass me-2"></i>Explorar
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('collections.index', ['filter' => 'my']) }}">
                                <i class="fas fa-user me-2"></i>Minhas Coleções
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                                <i class="fas fa-plus me-2"></i>Nova Coleção
                            </button>
                        </li>
                    </ul>
                </li>
                @endauth
                {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->is('/sobre') ? 'active' : '' }}" href="{{ url('/sobre') }}">Sobre</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('sugestoes') ? 'active' : '' }}" href="{{ url('/sugestoes') }}">Sugestões</a>
                </li>
                @auth
                    <li class="nav-item dropdown position-relative">
                        <a class="nav-link" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill" id="notification-count" style="display: none;">
                                0
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" id="notification-list">
                            <li class="dropdown-header-custom">
                                <span><i class="fa-solid fa-bell me-2"></i>Notificações</span>
                                <button class="btn btn-sm text-muted" onclick="markNotificationsAsRead()" style="background: none; border: none; padding: 0;" title="Marcar todas como lidas">
                                    <i class="fa-solid fa-check-double"></i>
                                </button>
                            </li>
                            <li>
                                <div class="notification-empty">
                                    <i class="fa-solid fa-spinner fa-spin"></i>
                                    <p class="mb-0">Carregando...</p>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>

            <!-- Botões de Login/Cadastro -->
            <ul class="navbar-nav ms-3">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.9rem;">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="user-dropdown-header">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ Auth::user()->name }}</div>
                                        <div class="user-email">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user"></i>
                                    <span>Meu Perfil</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->is('collections*') ? 'active' : '' }}" href="{{ route('collections.index', ['filter' => 'my']) }}">
                                    <i class="fas fa-layer-group"></i>
                                    <span>Minhas Coleções</span>
                                </a>
                            </li>
                            <li>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Nova Coleção</span>
                                </button>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->is('updates') ? 'active' : '' }}" href="{{ route('logs.index') }}">
                                    <i class="fas fa-clock"></i>
                                    <span>Atividades</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->is('/changelog') ? 'active' : '' }}" href="{{ route('changelog') }}">
                                    <i class="fas fa-code-branch"></i>
                                    <span>Changelog</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('user.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Sair</span>
                                    </button>
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