@extends('layout')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="edit-profile-card">
                <div class="edit-profile-header">
                    <a href="{{ route('user.profile') }}" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Voltar ao Perfil
                    </a>
                    <h2 class="text-center mt-3 mb-2">
                        <i class="fas fa-user-edit me-2"></i>Editar Perfil
                    </h2>
                    <p class="text-center text-secondary mb-0">Personalize suas informações</p>
                </div>

                <div class="edit-profile-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-modern">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Ops!</strong> Corrija os erros abaixo:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-modern">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Section -->
                        <div class="avatar-section text-center mb-4">
                            <div class="current-avatar-wrapper">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.png') }}" 
                                     alt="Avatar" 
                                     class="current-avatar"
                                     id="avatarPreview">
                                <div class="avatar-overlay">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="avatar" class="btn btn-custom btn-sm">
                                    <i class="fas fa-upload me-2"></i>Escolher Foto
                                </label>
                                <input type="file" 
                                       id="avatar" 
                                       name="avatar" 
                                       class="d-none" 
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                <p class="text-secondary small mt-2 mb-0">
                                    <i class="fas fa-info-circle me-1"></i>Formatos: JPG, PNG, GIF (máx. 2MB)
                                </p>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Nome de Usuário
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" 
                                       class="form-control form-control-modern ps-5" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>E-mail
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" 
                                       class="form-control form-control-modern ps-5" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-align-left me-2"></i>Biografia
                            </label>
                            <textarea class="form-control form-control-modern" 
                                      name="bio" 
                                      rows="4" 
                                      placeholder="Conte um pouco sobre você e seus jogos favoritos..."
                                      maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                            <small class="form-text text-secondary">
                                <i class="fas fa-info-circle me-1"></i>Máximo 500 caracteres
                            </small>
                        </div>

                        <hr class="my-4">

                        <!-- Password Section -->
                        <h5 class="mb-3">
                            <i class="fas fa-key me-2"></i>Alterar Senha
                        </h5>
                        <p class="text-secondary small mb-3">Deixe em branco se não quiser alterar</p>

                        <div class="form-group mb-3">
                            <label class="form-label">
                                <i class="fas fa-lock me-2"></i>Nova Senha
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       class="form-control form-control-modern ps-5" 
                                       name="password" 
                                       placeholder="Digite a nova senha">
                            </div>
                            <small class="form-text text-secondary">
                                <i class="fas fa-shield-alt me-1"></i>Mínimo 6 caracteres
                            </small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirmar Nova Senha
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" 
                                       class="form-control form-control-modern ps-5" 
                                       name="password_confirmation" 
                                       placeholder="Digite novamente">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-custom flex-grow-1">
                                <i class="fas fa-save me-2"></i>Salvar Alterações
                            </button>
                            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
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
.edit-profile-card {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    overflow: hidden;
}

.edit-profile-header {
    background: rgba(45, 150, 27, 0.1);
    padding: 30px;
    border-bottom: 1px solid var(--border-color);
}

.edit-profile-header h2 {
    color: var(--text-primary);
    font-weight: 700;
}

.edit-profile-body {
    padding: 30px;
}

.avatar-section {
    padding: 20px;
    background: rgba(45, 150, 27, 0.05);
    border-radius: 16px;
    border: 1px solid var(--border-color);
}

.current-avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid var(--btn-color);
    box-shadow: 0 8px 24px rgba(45, 150, 27, 0.4);
}

.current-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.current-avatar-wrapper:hover .avatar-overlay {
    opacity: 1;
}

.avatar-overlay i {
    font-size: 2rem;
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

textarea.form-control-modern {
    padding-left: 16px !important;
}

.form-text {
    display: block;
    margin-top: 6px;
    font-size: 0.85rem;
}

.alert-modern {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.btn-outline-secondary {
    border-color: var(--border-color);
    color: var(--text-secondary);
}

.btn-outline-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: var(--text-secondary);
    color: var(--text-primary);
}

@media (max-width: 768px) {
    .edit-profile-header,
    .edit-profile-body {
        padding: 20px;
    }
    
    .current-avatar-wrapper {
        width: 120px;
        height: 120px;
    }
}
</style>
@endsection

@section('script')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

