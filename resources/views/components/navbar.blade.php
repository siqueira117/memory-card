<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <img id="logo" src="{{ asset('img/logo_purple.png') }}" alt="memorycard">
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
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/sobre') ? 'active' : '' }}" href="{{ url('/sobre') }}">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contato') ? 'active' : '' }}" href="{{ url('/contato') }}">Contato</a>
                </li>
            </ul>

            {{-- <!-- Botões de Login/Cadastro -->
            <ul class="navbar-nav ms-3">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/perfil') }}">Meu Perfil</a></li>
                            <li>
                                <form method="POST" action="">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-custom" href="">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="">Sign Up</a>
                    </li>
                @endauth
            </ul> --}}
        </div>
    </div>
</nav>