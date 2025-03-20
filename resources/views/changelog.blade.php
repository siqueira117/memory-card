@extends('layout')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold text-white">Changelog</h1>
    <p class="text-muted">Últimas atualizações e melhorias do site.</p>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.5.1 - 20/03/2025</h4>
        <ul class="text-white">
            <li>Adicionando carousel de jogos relacionados</li>
        </ul>
    </div>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.5.0 - 20/03/2025</h4>
        <ul class="text-white">
            <li>Possibilide de adicionar um jogo a um status: Played, Playing, Backlog e Wishlist</li>
            <li>Adição de empresas envolvidas ao jogo</li>
        </ul>
    </div>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.4.0 - 18/03/2025</h4>
        <ul class="text-white">
            <li>Adicionando sistema de notificações</li>
            <li>Refatorando consultas ao banco, melhorando performance do site</li>
        </ul>
    </div>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.3.0 - 15/03/2025</h4>
        <ul class="text-white">
            <li>Visualização de screenshots e artworks</li>
            <li>Possibilidade de baixar manuais dos jogos</li>
        </ul>
    </div>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.2.0 - 12/03/2025</h4>
        <ul class="text-white">
            <li>Adicionado sistema de reviews para os jogos</li>
            <li>Melhorias na página de detalhes dos jogos</li>
            <li>Correção de bugs na listagem de plataformas</li>
        </ul>
    </div>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.1.0 - 05/03/2025</h4>
        <ul class="text-white">
            <li>Implementado sistema de filtros na busca de jogos</li>
            <li>Melhoria no layout da página inicial</li>
        </ul>
    </div>

    <div class="bg-dark-custom p-4 rounded mb-4">
        <h4 class="text-success" style="font-family: FreeMono, monospace">v1.0.0 - 28/02/2025</h4>
        <ul class="text-white">
            <li>Primeiro lançamento oficial do site</li>
            <li>Página de detalhes do jogo com downloads de ROMs</li>
        </ul>
    </div>
</div>
@endsection
