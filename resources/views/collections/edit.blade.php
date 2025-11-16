@extends('layout')

@section('title', 'Editar Coleção - MemoryCard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="edit-icon mb-3">
                    <i class="fas fa-edit"></i>
                </div>
                <h1 class="mb-2" style="color: var(--text-primary);">Editar Coleção</h1>
                <p class="lead" style="color: var(--text-secondary);">{{ $collection->name }}</p>
            </div>

            <!-- Formulário -->
            <div class="edit-form-card">
                <form action="{{ route('collections.update', $collection->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nome da Coleção -->
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">
                            <i class="fas fa-heading me-2"></i>Nome da Coleção *
                        </label>
                        <input 
                            type="text" 
                            class="form-control form-control-modern @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $collection->name) }}"
                            placeholder="Ex: Melhores RPGs dos Anos 90"
                            required
                            maxlength="150"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>Máximo de 150 caracteres
                        </small>
                    </div>

                    <!-- Descrição -->
                    <div class="form-group mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Descrição
                        </label>
                        <textarea 
                            class="form-control form-control-modern @error('description') is-invalid @enderror" 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Descreva sua coleção..."
                            maxlength="1000"
                        >{{ old('description', $collection->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>Máximo de 1000 caracteres
                        </small>
                    </div>

                    <!-- Tags -->
                    <div class="form-group mb-4">
                        <label for="tags" class="form-label">
                            <i class="fas fa-tags me-2"></i>Tags
                        </label>
                        <input 
                            type="text" 
                            class="form-control form-control-modern @error('tags') is-invalid @enderror" 
                            id="tags" 
                            name="tags" 
                            value="{{ old('tags', $collection->tags->pluck('name')->implode(', ')) }}"
                            placeholder="Ex: RPG, Aventura, Nostalgia"
                        >
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>Separe as tags com vírgulas
                        </small>
                    </div>

                    <!-- Imagem da Coleção -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fas fa-image me-2"></i>Imagem da Coleção
                        </label>

                        @if($collection->cover_image)
                        <div class="current-cover mb-3">
                            <img src="{{ str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/' . $collection->cover_image) }}" alt="{{ $collection->name }}" class="cover-preview">
                            <button type="button" class="btn btn-remove-cover" onclick="removeCover()">
                                <i class="fas fa-times me-2"></i>Remover Imagem
                            </button>
                        </div>
                        @endif

                        <div class="cover-upload-options">
                            <div class="upload-option">
                                <label for="cover_image" class="upload-label">
                                    <i class="fas fa-upload me-2"></i>
                                    Fazer Upload de Imagem
                                </label>
                                <input 
                                    type="file" 
                                    class="form-control form-control-modern @error('cover_image') is-invalid @enderror" 
                                    id="cover_image" 
                                    name="cover_image"
                                    accept="image/*"
                                    onchange="previewImage(this)"
                                >
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>JPG, PNG, GIF ou WebP - Máximo 2MB
                                </small>
                            </div>

                            @if($collection->games()->count() > 0)
                            <div class="text-center my-3">
                                <span class="text-muted">ou</span>
                            </div>

                            <button type="button" class="btn btn-custom-secondary w-100" onclick="autoGenerateCover()">
                                <i class="fas fa-magic me-2"></i>Gerar Automaticamente do Primeiro Jogo
                            </button>
                            @endif
                        </div>

                        <div id="imagePreview" class="image-preview mt-3" style="display: none;">
                            <img src="" alt="Preview" id="previewImg">
                        </div>
                    </div>

                    <!-- Visibilidade -->
                    <div class="form-group mb-4">
                        <label class="form-label mb-3">
                            <i class="fas fa-eye me-2"></i>Visibilidade
                        </label>
                        <div class="visibility-options">
                            <label class="visibility-option" for="public_edit">
                                <input 
                                    class="visibility-radio" 
                                    type="radio" 
                                    name="is_public" 
                                    id="public_edit" 
                                    value="1" 
                                    {{ old('is_public', $collection->is_public) == '1' ? 'checked' : '' }}
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
                            
                            <label class="visibility-option" for="private_edit">
                                <input 
                                    class="visibility-radio" 
                                    type="radio" 
                                    name="is_public" 
                                    id="private_edit" 
                                    value="0"
                                    {{ old('is_public', $collection->is_public) == '0' ? 'checked' : '' }}
                                >
                                <div class="visibility-card">
                                    <div class="visibility-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="visibility-content">
                                        <strong>Privada</strong>
                                        <small>Apenas você pode ver</small>
                                    </div>
                                    <div class="visibility-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-flex gap-3 pt-4 border-top" style="border-color: var(--border-color) !important;">
                        <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-custom-secondary flex-fill">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-custom flex-fill">
                            <i class="fas fa-save me-2"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>

            <!-- Zona de Perigo -->
            <div class="danger-zone">
                <div class="danger-zone-header">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Zona de Perigo</strong>
                </div>
                <div class="danger-zone-body">
                    <p>
                        Ao deletar esta coleção, todos os jogos associados serão removidos permanentemente. 
                        Esta ação não pode ser desfeita.
                    </p>
                    <button 
                        type="button" 
                        class="btn btn-danger-custom" 
                        onclick="deleteCollection()"
                    >
                        <i class="fas fa-trash me-2"></i>Deletar Coleção
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteCollection() {
    if (!confirm('Tem certeza que deseja deletar esta coleção? Esta ação não pode ser desfeita.')) {
        return;
    }

    if (!confirm('ÚLTIMA CONFIRMAÇÃO: Deletar "{{ $collection->name }}"?')) {
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("collections.destroy", $collection->slug) }}';

    const csrfField = document.createElement('input');
    csrfField.type = 'hidden';
    csrfField.name = '_token';
    csrfField.value = '{{ csrf_token() }}';

    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';

    form.appendChild(csrfField);
    form.appendChild(methodField);
    document.body.appendChild(form);
    form.submit();
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function autoGenerateCover() {
    if (!confirm('Gerar capa automaticamente usando o primeiro jogo da coleção?')) {
        return;
    }

    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Gerando...';

    fetch('{{ route("collections.auto-cover", $collection->slug) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Erro ao gerar capa', 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erro ao gerar capa', 'error');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function removeCover() {
    if (!confirm('Deseja remover a imagem atual?')) {
        return;
    }

    fetch('{{ route("collections.remove-cover", $collection->slug) }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erro ao remover capa', 'error');
    });
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed bottom-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.style.minWidth = '300px';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
/* Header Icon */
.edit-icon {
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

.edit-icon i {
    font-size: 2rem;
    color: white;
}

/* Form Card */
.edit-form-card {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
}

/* Radio Buttons Customizados */
.visibility-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.visibility-option {
    cursor: pointer;
    margin: 0;
}

.visibility-radio {
    display: none;
}

.visibility-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px;
    background: var(--input-color);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.visibility-card:hover {
    border-color: var(--btn-color);
    background: rgba(45, 150, 27, 0.1);
    transform: translateX(4px);
}

.visibility-radio:checked + .visibility-card {
    border-color: var(--btn-color);
    background: rgba(45, 150, 27, 0.15);
    box-shadow: 0 4px 12px rgba(45, 150, 27, 0.3);
}

.visibility-icon {
    width: 40px;
    height: 40px;
    min-width: 40px;
    background: var(--dark-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.visibility-radio:checked + .visibility-card .visibility-icon {
    background: var(--btn-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(45, 150, 27, 0.4);
}

.visibility-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.visibility-content strong {
    color: var(--text-primary);
    font-size: 1rem;
    margin-bottom: 2px;
}

.visibility-content small {
    color: var(--text-secondary);
    font-size: 0.85rem;
}

.visibility-check {
    color: var(--text-secondary);
    font-size: 1.5rem;
    opacity: 0;
    transition: all 0.3s ease;
}

.visibility-radio:checked + .visibility-card .visibility-check {
    color: var(--btn-color);
    opacity: 1;
}

/* Danger Zone */
.danger-zone {
    background: var(--card-gradient);
    border: 2px solid #ff4444;
    border-radius: 20px;
    overflow: hidden;
}

.danger-zone-header {
    background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
    color: white;
    padding: 16px 24px;
    font-size: 1.1rem;
    font-weight: 600;
}

.danger-zone-body {
    padding: 24px;
}

.danger-zone-body p {
    color: var(--text-secondary);
    margin-bottom: 20px;
    line-height: 1.6;
}

.btn-danger-custom {
    background: transparent;
    border: 2px solid #ff4444;
    color: #ff4444;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-danger-custom:hover {
    background: rgba(255, 68, 68, 0.1);
    border-color: #ff5555;
    color: #ff5555;
    transform: translateY(-2px);
}

/* Cover Image */
.current-cover {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--border-color);
}

.cover-preview {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.btn-remove-cover {
    width: 100%;
    padding: 10px;
    background: rgba(255, 68, 68, 0.1);
    border: 2px solid #ff4444;
    color: #ff4444;
    border-radius: 0;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-remove-cover:hover {
    background: rgba(255, 68, 68, 0.2);
}

.cover-upload-options {
    background: var(--input-color);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 20px;
}

.upload-option {
    margin-bottom: 0;
}

.upload-label {
    display: block;
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 10px;
}

.image-preview {
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--border-color);
}

.image-preview img {
    width: 100%;
    height: auto;
    max-height: 300px;
    object-fit: cover;
    display: block;
}

/* Responsive */
@media (max-width: 768px) {
    .edit-form-card {
        padding: 24px;
    }
}
</style>
@endsection
