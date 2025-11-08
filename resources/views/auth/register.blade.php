@extends('layout')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="register-card">
                <div class="register-header">
                    <div class="register-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="register-title">Criar Conta</h2>
                    <p class="register-subtitle">Junte-se à comunidade gamer!</p>
                </div>

                <div class="register-body">
                    <form id="userRegisterForm" action="{{ route('user.register') }}" method="post">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Nome de Usuário
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" 
                                       class="form-control form-control-modern ps-5" 
                                       name="userName" 
                                       placeholder="Escolha seu nome de usuário" 
                                       value="{{ old('userName') }}"
                                       required>
                            </div>
                            @error('userName') 
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span> 
                            @enderror
                            <small class="form-text text-secondary">
                                <i class="fas fa-info-circle me-1"></i>Mínimo 3 caracteres
                            </small>
                        </div>
                    
                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>E-mail
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" 
                                       class="form-control form-control-modern ps-5" 
                                       name="userEmail" 
                                       placeholder="seu@email.com"
                                       value="{{ old('userEmail') }}"
                                       required>
                            </div>
                            @error('userEmail') 
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span> 
                            @enderror
                        </div>
                    
                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-lock me-2"></i>Senha
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       class="form-control form-control-modern ps-5" 
                                       name="userPassword" 
                                       placeholder="Crie uma senha segura"
                                       required>
                            </div>
                            @error('userPassword') 
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </span> 
                            @enderror
                            <small class="form-text text-secondary">
                                <i class="fas fa-shield-alt me-1"></i>Mínimo 6 caracteres
                            </small>
                        </div>
                    
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirmar Senha
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       class="form-control form-control-modern ps-5" 
                                       name="userPassword_confirmation" 
                                       placeholder="Digite a senha novamente"
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-custom w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Criar Conta
                        </button>

                        <div class="text-center">
                            <p class="text-secondary mb-0">
                                Já tem uma conta? 
                                <a href="#" class="text-success fw-bold" data-bs-toggle="modal" data-bs-target="#userLogin">
                                    Faça Login
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.register-card {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    overflow: hidden;
}

.register-header {
    background: rgba(45, 150, 27, 0.1);
    padding: 40px 30px;
    text-align: center;
    border-bottom: 1px solid var(--border-color);
}

.register-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: var(--btn-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(45, 150, 27, 0.4);
    animation: pulse 2s infinite;
}

.register-icon i {
    font-size: 2.5rem;
    color: white;
}

.register-title {
    color: var(--text-primary);
    font-weight: 800;
    margin-bottom: 8px;
}

.register-subtitle {
    color: var(--text-secondary);
    margin-bottom: 0;
}

.register-body {
    padding: 30px;
}

.form-label {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 8px;
}

.form-label i {
    color: var(--btn-color);
}

.input-icon-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    z-index: 1;
}

.form-control-modern {
    padding-left: 45px !important;
}

.error-message {
    color: #ff4444;
    font-size: 0.85rem;
    display: block;
    margin-top: 8px;
}

.form-text {
    display: block;
    margin-top: 6px;
    font-size: 0.85rem;
}

.register-body a {
    text-decoration: none;
    transition: all 0.3s ease;
}

.register-body a:hover {
    color: var(--btn-color-hover) !important;
}

@media (max-width: 768px) {
    .register-header {
        padding: 30px 20px;
    }
    
    .register-body {
        padding: 20px;
    }
    
    .register-icon {
        width: 60px;
        height: 60px;
    }
    
    .register-icon i {
        font-size: 2rem;
    }
}
</style>
@endsection
