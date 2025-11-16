@extends('layout')

@section('title', 'Nova Coleção - MemoryCard')

@section('style')
<link rel="stylesheet" href="{{ asset('css/collections.css') }}">
@endsection

@section('content')
<div class="collections-page py-5">
    <div class="container">
        <div class="collection-form-wrapper">
            <div class="collection-form-header text-center mb-4">
                <div class="collection-form-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <p class="eyebrow mb-1">Criação rápida</p>
                <h1>Nova Coleção</h1>
                <p class="text-muted">Monte listas personalizadas para organizar e compartilhar seus jogos favoritos.</p>
            </div>

            <div class="collection-form-card glass-panel">
                <form action="{{ route('collections.store') }}" method="POST">
                    @csrf

                    <div class="collection-form-section">
                        <label for="name" class="form-label">
                            <i class="fas fa-heading me-2"></i>Nome da coleção *
                        </label>
                        <input 
                            type="text" 
                            class="form-control form-control-modern @error('name') is-invalid @enderror" 
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
                        <small class="form-text text-muted">Máximo de 150 caracteres</small>
                    </div>

                    <div class="collection-form-section">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Descrição
                        </label>
                        <textarea 
                            class="form-control form-control-modern @error('description') is-invalid @enderror" 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Descreva a proposta da sua coleção"
                            maxlength="1000"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Máximo de 1000 caracteres</small>
                    </div>

                    <div class="collection-form-section">
                        <label class="form-label">
                            <i class="fas fa-eye me-2"></i>Visibilidade
                        </label>
                        <div class="visibility-options">
                            <label class="visibility-option">
                                <input 
                                    class="visibility-radio" 
                                    type="radio" 
                                    name="is_public" 
                                    id="public" 
                                    value="1" 
                                    {{ old('is_public', '1') == '1' ? 'checked' : '' }}
                                >
                                <div class="visibility-card">
                                    <div class="visibility-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div class="visibility-content">
                                        <strong>Pública</strong>
                                        <small>Qualquer pessoa pode ver e seguir</small>
                                    </div>
                                    <div class="visibility-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                            <label class="visibility-option">
                                <input 
                                    class="visibility-radio" 
                                    type="radio" 
                                    name="is_public" 
                                    id="private" 
                                    value="0"
                                    {{ old('is_public') == '0' ? 'checked' : '' }}
                                >
                                <div class="visibility-card">
                                    <div class="visibility-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="visibility-content">
                                        <strong>Privada</strong>
                                        <small>Apenas você pode visualizar</small>
                                    </div>
                                    <div class="visibility-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="collection-form-actions">
                        <a href="{{ route('collections.index') }}" class="btn btn-ghost">
                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-custom">
                            <i class="fas fa-save me-2"></i>Criar coleção
                        </button>
                    </div>
                </form>
            </div>

            <div class="collection-tip glass-panel mt-4">
                <div class="tip-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div>
                    <h6>Dica rápida</h6>
                    <p>Depois de salvar, você poderá adicionar jogos diretamente da página de detalhes de cada título.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
