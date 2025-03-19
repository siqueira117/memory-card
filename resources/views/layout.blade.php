<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>memorycard - Para gamers de coração</title>
    <link rel="icon" href="{{ asset('img/icon.png') }}">    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
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
        function fetchNotifications() {
            fetch("{{ route('notifications') }}")
                .then(response => response.json())
                .then(data => {
                    let notificationCount = document.getElementById('notification-count');
                    let notificationList = document.getElementById('notification-list');
    
                    notificationCount.innerText = data.count;
                    notificationList.innerHTML = "";
    
                    if (data.notifications.length > 0) {
                        data.notifications.forEach(notification => {
                            let item = document.createElement('li');
                            let link = document.createElement('a');
                            link.className = "dropdown-item";

                            link.innerText = notification.description;
                            link.setAttribute('href', notification.model_uri);
                            link.setAttribute('style', "text-wrap: auto; font-size: smaller;");

                            item.appendChild(link);
                            notificationList.appendChild(item);
                        });
                    } else {
                        let empty = document.createElement('li');
                        empty.className = "dropdown-item text-muted";
                        empty.innerText = "Sem notificações";
                        notificationList.appendChild(empty);
                    }
                });
        }
    
        function markNotificationsAsRead() {
            fetch("{{ route('notifications.read') }}", { method: "POST", headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } })
                .then(response => response.json())
                .then(() => {
                    document.getElementById('notification-count').innerText = "0";
                });
        }
    
        document.addEventListener("DOMContentLoaded", fetchNotifications);
    </script>
    <script>
        document.getElementById("favorite-button").addEventListener("click", function() {
            let button = document.getElementById("favorite-button");
            let icon = document.getElementById("favorite-icon");
            let text = document.getElementById("favorite-text");
    
            fetch("{{ url('/favorite/'.$game['game_id']) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message.includes("adicionado")) {
                    button.classList.remove("btn-outline-warning");
                    button.classList.add("btn-danger");
                    icon.innerHTML = "❤️";
                    text.innerHTML = "Remover Favorito";
                } else {
                    button.classList.remove("btn-danger");
                    button.classList.add("btn-outline-warning");
                    icon.innerHTML = "⭐";
                    text.innerHTML = "Favoritar";
                }
            })
            .catch(error => console.error('Erro:', error));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>