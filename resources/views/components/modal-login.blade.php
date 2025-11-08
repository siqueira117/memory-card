<div class="modal fade" id="userLogin" tabindex="-1" aria-labelledby="userLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal">
            <div class="modal-header border-0">
                <div class="w-100 text-center">
                    <div class="login-icon mb-3">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h4 class="modal-title fw-bold" id="userLoginLabel">Bem-vindo de volta!</h4>
                    <p class="text-secondary mb-0">Entre para continuar sua jornada</p>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form id="userLoginForm" action="{{ route('user.login') }}" method="post">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Usuário
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" class="form-control form-control-modern ps-5" name="userName" placeholder="Digite seu usuário" required>
                        </div>
                        @error('userName') 
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </span> 
                        @enderror
                    </div>
                
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fas fa-lock me-2"></i>Senha
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control form-control-modern ps-5" name="userPassword" placeholder="Digite sua senha" required>
                        </div>
                        @error('userPassword') 
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </span> 
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-custom w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>

                    <div class="text-center">
                        <p class="text-secondary mb-0">
                            Não tem uma conta? 
                            <a href="{{ route('user.registerView') }}" class="text-success fw-bold" data-bs-dismiss="modal">
                                Cadastre-se
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.login-modal {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.login-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: var(--btn-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(45, 150, 27, 0.4);
}

.login-icon i {
    font-size: 2.5rem;
    color: white;
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

.modal-body a {
    text-decoration: none;
    transition: all 0.3s ease;
}

.modal-body a:hover {
    color: var(--btn-color-hover) !important;
}
</style>
