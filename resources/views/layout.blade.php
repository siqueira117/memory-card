<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>memorycard - Para gamers de coração</title>
    <link rel="icon" href="{{ asset('img/icon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skeleton.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
    @yield('style')
    
    @livewireStyles
</head>
<body>
    <div id="container">
        <x-navbar />

        <div id="content-wrapper">
            @yield('content')
        </div>
    
        <x-modal-login />
        
        <!-- Modal: Nova Coleção -->
        @auth
        <div class="modal fade" id="newCollectionModal" tabindex="-1" aria-labelledby="newCollectionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content collection-modal">
                    <div class="modal-header border-0">
                        <div class="w-100 text-center">
                            <div class="collection-icon mb-3">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <h4 class="modal-title fw-bold" id="newCollectionModalLabel">Nova Coleção</h4>
                            <p class="text-secondary mb-0">Crie uma lista personalizada de jogos</p>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="newCollectionForm">
                        @csrf
                        <div class="modal-body px-4 pb-4">
                            <!-- Nome da Coleção -->
                            <div class="form-group mb-3">
                                <label for="collection_name" class="form-label">
                                    <i class="fas fa-heading me-2"></i>Nome da Coleção *
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-modern" 
                                    id="collection_name" 
                                    name="name" 
                                    placeholder="Ex: Melhores RPGs dos Anos 90"
                                    required
                                    maxlength="150"
                                >
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Máximo de 150 caracteres
                                </small>
                            </div>

                            <!-- Descrição -->
                            <div class="form-group mb-3">
                                <label for="collection_description" class="form-label">
                                    <i class="fas fa-align-left me-2"></i>Descrição
                                </label>
                                <textarea 
                                    class="form-control form-control-modern" 
                                    id="collection_description" 
                                    name="description" 
                                    rows="3"
                                    placeholder="Descreva sua coleção..."
                                    maxlength="1000"
                                ></textarea>
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Máximo de 1000 caracteres
                                </small>
                            </div>

                            <!-- Tags -->
                            <div class="form-group mb-3">
                                <label for="collection_tags" class="form-label">
                                    <i class="fas fa-tags me-2"></i>Tags
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-modern" 
                                    id="collection_tags" 
                                    name="tags" 
                                    placeholder="Ex: RPG, Aventura, Nostalgia"
                                >
                                <div class="invalid-feedback"></div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Separe as tags com vírgulas
                                </small>
                            </div>

                            <!-- Visibilidade -->
                            <div class="form-group mb-4">
                                <label class="form-label mb-3">
                                    <i class="fas fa-eye me-2"></i>Visibilidade
                                </label>
                                <div class="visibility-options">
                                    <label class="visibility-option" for="collection_public">
                                        <input 
                                            class="visibility-radio" 
                                            type="radio" 
                                            name="is_public" 
                                            id="collection_public" 
                                            value="1" 
                                            checked
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
                                    
                                    <label class="visibility-option" for="collection_private">
                                        <input 
                                            class="visibility-radio" 
                                            type="radio" 
                                            name="is_public" 
                                            id="collection_private" 
                                            value="0"
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
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-custom-secondary flex-fill" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-custom flex-fill" id="createCollectionBtn">
                                    <i class="fas fa-save me-2"></i>Criar Coleção
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newCollectionForm = document.getElementById('newCollectionForm');
            
            if (newCollectionForm) {
                newCollectionForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const submitBtn = document.getElementById('createCollectionBtn');
                    const originalBtnText = submitBtn.innerHTML;
                    
                    // Desabilitar botão e mostrar loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Criando...';
                    
                    // Limpar erros anteriores
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
                    
                    // Obter dados do formulário
                    const formData = new FormData(newCollectionForm);
                    
                    fetch('{{ route("collections.store") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fechar modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('newCollectionModal'));
                            modal.hide();
                            
                            // Limpar formulário
                            newCollectionForm.reset();
                            
                            // Mostrar toast de sucesso
                            showToast(data.message, 'success');
                            
                            // Redirecionar para a coleção criada
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1000);
                        } else {
                            // Mostrar erros de validação
                            if (data.errors) {
                                Object.keys(data.errors).forEach(key => {
                                    const input = document.querySelector(`[name="${key}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');
                                        const feedback = input.parentElement.querySelector('.invalid-feedback');
                                        if (feedback) {
                                            const errorMessage = Array.isArray(data.errors[key]) 
                                                ? data.errors[key][0] 
                                                : data.errors[key];
                                            feedback.textContent = errorMessage;
                                        }
                                    }
                                });
                            }
                            
                            showToast(data.message || 'Erro ao criar coleção', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Erro ao criar coleção. Tente novamente.', 'error');
                    })
                    .finally(() => {
                        // Re-habilitar botão
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
                });
                
                // Limpar formulário ao abrir modal
                document.getElementById('newCollectionModal').addEventListener('show.bs.modal', function() {
                    newCollectionForm.reset();
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
                });
            }
        });

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
        /* Modal de Coleção */
        .collection-modal {
            background: var(--card-gradient);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .collection-icon {
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

        .collection-icon i {
            font-size: 2.5rem;
            color: white;
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

        /* Form Control Modern */
        .form-control-modern {
            background: var(--input-color) !important;
            border: 2px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            padding: 12px 16px !important;
            border-radius: 10px !important;
            transition: all 0.3s ease !important;
        }

        .form-control-modern:focus {
            background: var(--input-color) !important;
            border-color: var(--btn-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(45, 150, 27, 0.25) !important;
            color: var(--text-primary) !important;
        }

        .form-control-modern::placeholder {
            color: var(--text-secondary);
            opacity: 0.7;
        }

        .form-control-modern.is-invalid {
            border-color: #ff4444 !important;
        }

        .invalid-feedback {
            color: #ff4444;
            font-size: 0.85rem;
            display: block;
            margin-top: 6px;
        }

        .form-text.text-muted {
            color: var(--text-secondary) !important;
            font-size: 0.8rem;
            margin-top: 6px;
        }

        .form-text.text-muted i {
            color: var(--btn-color);
        }

        /* Ajustes de botões no modal */
        .collection-modal .btn-custom,
        .collection-modal .btn-custom-secondary {
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            text-transform: none;
            letter-spacing: 0.3px;
        }

        .collection-modal .btn-custom-secondary {
            background: transparent;
            border: 2px solid var(--btn-color);
            color: var(--btn-color);
        }

        .collection-modal .btn-custom-secondary:hover {
            background: transparent;
            border-color: var(--btn-color);
            color: var(--btn-color);
            transform: translateY(-2px);
        }

        .collection-modal .gap-2 {
            gap: 12px !important;
        }
        </style>
        @endauth
        
        <x-footer />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.screenshot-thumbnail').forEach(item => {
                item.addEventListener('click', function () {
                    document.getElementById('modalImage').src = this.getAttribute('data-src');
                });
            });

            document.querySelectorAll('.artwork-thumbnail').forEach(item => {
                item.addEventListener('click', function () {
                    document.getElementById('modalImageArtwork').src = this.getAttribute('data-src');
                });
            });
        });
    </script>
    <script>
        function getNotificationIcon(type) {
            const icons = {
                'game': 'fa-gamepad',
                'review': 'fa-star',
                'comment': 'fa-comment',
                'favorite': 'fa-heart',
                'achievement': 'fa-trophy',
                'system': 'fa-info-circle',
                'default': 'fa-bell'
            };
            return icons[type] || icons['default'];
        }

        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            
            if (seconds < 60) return 'Agora mesmo';
            if (seconds < 3600) return `${Math.floor(seconds / 60)} min atrás`;
            if (seconds < 86400) return `${Math.floor(seconds / 3600)}h atrás`;
            if (seconds < 604800) return `${Math.floor(seconds / 86400)}d atrás`;
            
            return date.toLocaleDateString('pt-BR', { day: '2-digit', month: 'short' });
        }

        function fetchNotifications() {
            fetch("{{ route('notifications') }}")
                .then(response => response.json())
                .then(data => {
                    const notificationCount = document.getElementById('notification-count');
                    const notificationList = document.getElementById('notification-list');
                    
                    // Atualizar contador
                    if (data.count > 0) {
                        notificationCount.innerText = data.count > 99 ? '99+' : data.count;
                        notificationCount.style.display = 'flex';
                    } else {
                        notificationCount.style.display = 'none';
                    }
    
                    // Limpar lista mantendo o header
                    const header = notificationList.querySelector('.dropdown-header-custom');
                    notificationList.innerHTML = '';
                    if (header) {
                        notificationList.appendChild(header);
                    }
    
                    if (data.notifications.length > 0) {
                        data.notifications.forEach(notification => {
                            const li = document.createElement('li');
                            const link = document.createElement('a');
                            link.className = 'notification-item';
                            link.href = notification.model_uri || '#';
                            
                            // Determinar tipo de notificação baseado na descrição
                            let notifType = 'default';
                            if (notification.description.includes('jogo')) notifType = 'game';
                            if (notification.description.includes('avaliação') || notification.description.includes('review')) notifType = 'review';
                            if (notification.description.includes('comentário')) notifType = 'comment';
                            if (notification.description.includes('favorit')) notifType = 'favorite';
                            
                            link.innerHTML = `
                                <div class="notification-content">
                                    <div class="notification-icon">
                                        <i class="fa-solid ${getNotificationIcon(notifType)}"></i>
                                    </div>
                                    <div class="notification-text">
                                        <div class="notification-description">${notification.description}</div>
                                        <div class="notification-time">
                                            <i class="fa-regular fa-clock"></i>
                                            ${notification.created_at ? getTimeAgo(notification.created_at) : 'Recente'}
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            li.appendChild(link);
                            notificationList.appendChild(li);
                        });
                        
                        // Adicionar link "Ver todas"
                        if (data.count > 5) {
                            const seeAll = document.createElement('li');
                            seeAll.innerHTML = `
                                <a href="{{ route('logs.index') }}" class="dropdown-item text-center" style="border-top: 1px solid var(--border-color); margin-top: 0.5rem; padding-top: 0.75rem; color: var(--btn-color);">
                                    <i class="fa-solid fa-arrow-right me-2"></i>Ver todas as notificações
                                </a>
                            `;
                            notificationList.appendChild(seeAll);
                        }
                    } else {
                        const empty = document.createElement('li');
                        empty.innerHTML = `
                            <div class="notification-empty">
                                <i class="fa-solid fa-bell-slash"></i>
                                <p class="mb-0">Nenhuma notificação</p>
                                <small class="text-muted">Você está em dia! 🎮</small>
                            </div>
                        `;
                        notificationList.appendChild(empty);
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar notificações:', error);
                });
        }
    
        function markNotificationsAsRead() {
            fetch("{{ route('notifications.read') }}", { 
                method: "POST", 
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } 
            })
            .then(response => response.json())
            .then(() => {
                const notificationCount = document.getElementById('notification-count');
                notificationCount.style.display = 'none';
                
                // Remover classe "unread" das notificações
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                });
                
                // Feedback visual
                const btn = event.target.closest('button');
                if (btn) {
                    const originalIcon = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                    setTimeout(() => {
                        btn.innerHTML = originalIcon;
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Erro ao marcar notificações como lidas:', error);
            });
        }
    
        // Carregar notificações ao abrir o dropdown
        document.addEventListener("DOMContentLoaded", function() {
            fetchNotifications();
            
            // Atualizar a cada 60 segundos
            setInterval(fetchNotifications, 60000);
            
            // Atualizar ao abrir o dropdown
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.addEventListener('show.bs.dropdown', fetchNotifications);
            }
        });
    </script>

    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>