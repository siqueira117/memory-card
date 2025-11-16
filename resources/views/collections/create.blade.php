@extends('layout')

@section('title', 'Nova Coleção - MemoryCard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-layer-group me-2"></i>
                    Nova Coleção
                </h1>
                <p class="lead text-muted">Crie uma lista personalizada de jogos</p>
            </div>

            <!-- Formulário -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('collections.store') }}" method="POST">
                        @csrf

                        <!-- Nome da Coleção -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-heading me-2"></i>Nome da Coleção *
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                placeholder="Ex: Melhores RPGs dos Anos 90"
                                required
                                maxlength="150"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Máximo de 150 caracteres
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2"></i>Descrição
                            </label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="4"
                                placeholder="Descreva sua coleção..."
                                maxlength="1000"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Máximo de 1000 caracteres
                            </div>
                        </div>

                        <!-- Visibilidade -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-eye me-2"></i>Visibilidade
                            </label>
                            <div class="form-check mb-2">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="is_public" 
                                    id="public" 
                                    value="1" 
                                    {{ old('is_public', '1') == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="public">
                                    <i class="fas fa-globe text-success me-2"></i>
                                    <strong>Pública</strong> - Qualquer pessoa pode ver e seguir
                                </label>
                            </div>
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="is_public" 
                                    id="private" 
                                    value="0"
                                    {{ old('is_public') == '0' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="private">
                                    <i class="fas fa-lock text-secondary me-2"></i>
                                    <strong>Privada</strong> - Apenas você pode ver
                                </label>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('collections.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Criar Coleção
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="alert alert-info mt-4">
                <i class="fas fa-lightbulb me-2"></i>
                <strong>Dica:</strong> Depois de criar a coleção, você poderá adicionar jogos diretamente da página de detalhes de cada jogo!
            </div>
        </div>
    </div>
</div>
@endsection

