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
    <div id="page-container">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>