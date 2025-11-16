@extends('layout')

@section('title', 'Editar Coleção - MemoryCard')

@section('style')
<link rel="stylesheet" href="{{ asset('css/collections.css') }}">
@endsection

@section('content')
<div class="collections-page py-5">
    <div class="container">
        <div class="collection-form-wrapper">
            <div class="collection-form-header text-center mb-4">
                <div class="collection-form-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <p class="eyebrow mb-1">Editar coleção</p>
                <h1>Personalize os detalhes</h1>
                <p class="text-muted">{{ $collection->name }}</p>
            </div>

            <div class="collection-form-card glass-panel">
                <form action="{{ route('collections.update', $collection->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="collection-form-section">
                        <label for="name" class="form-label">
                            <i class="fas fa-heading me-2"></i>Nome da coleção *
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
                            placeholder="Descreva sua coleção..."
                            maxlength="1000"
                        >{{ old('description', $collection->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Máximo de 1000 caracteres</small>
                    </div>

                    <div class="collection-form-section">
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
                        <small class="form-text text-muted">Separe as tags com vírgulas</small>
                    </div>

                    <div class="collection-form-section">
                        <label class="form-label">
                            <i class="fas fa-image me-2"></i>Imagem de capa
                        </label>

                        @if($collection->cover_image)
                            <div class="cover-preview mb-3">
                                <img src="{{ \Illuminate\Support\Str::startsWith($collection->cover_image, ['http://', 'https://']) ? $collection->cover_image : asset('storage/' . $collection->cover_image) }}" alt="{{ $collection->name }}">
                                <button type="button" class="btn btn-ghost-danger" onclick="removeCover()">
                                    <i class="fas fa-trash me-2"></i>Remover capa atual
                                </button>
                            </div>
                        @endif

                        <div class="cover-upload-options">
                            <div class="upload-option mb-3">
                                <label for="cover_image" class="upload-label">Enviar nova imagem</label>
                                <input 
                                    type="file" 
                                    class="form-control form-control-modern @error('cover_image') is-invalid @enderror" 
                                    name="cover_image" 
                                    id="cover_image" 
                                    accept="image/png,image/jpeg,image/webp,image/gif"
                                    onchange="previewImage(this)"
                                >
                                @error('cover_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">JPG, PNG, GIF ou WebP • Máximo 2MB</small>
                            </div>

                            @if($collection->games()->count() > 0)
                                <button type="button" class="btn btn-custom-outline w-100" onclick="autoGenerateCover()">
                                    <i class="fas fa-magic me-2"></i>Gerar automaticamente pelo primeiro jogo
                                </button>
                            @endif
                        </div>

                        <div id="imagePreview" class="image-preview mt-3" style="display: none;">
                            <img src="" alt="Preview" id="previewImg">
                        </div>
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
                                    value="1" 
                                    {{ old('is_public', $collection->is_public ? '1' : '0') == '1' ? 'checked' : '' }}
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
                                    value="0"
                                    {{ old('is_public', $collection->is_public ? '1' : '0') == '0' ? 'checked' : '' }}
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

                    <div class="collection-form-actions mt-4">
                        <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-ghost">
                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-custom">
                            <i class="fas fa-save me-2"></i>Salvar alterações
                        </button>
                    </div>
                </form>
            </div>

            <div class="danger-zone glass-panel mt-4">
                <div class="danger-zone-header">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Zona de perigo
                </div>
                <div class="danger-zone-body">
                    <p>Deletar esta coleção removerá permanentemente todos os jogos associados. Esta ação não pode ser desfeita.</p>
                    <button type="button" class="btn btn-danger-custom" onclick="deleteCollection()">
                        <i class="fas fa-trash me-2"></i>Deletar coleção
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteCollection() {
    if (!confirm('Tem certeza que deseja deletar esta coleção?')) {
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
@endsection
