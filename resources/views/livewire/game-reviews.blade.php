<div class="mt-5 container">
    <h3 class="mb-3 text-center">Avaliações</h3>

    @auth
        <div class="mx-auto w-25">
            <button class="btn btn-custom btn-sm w-100" data-bs-toggle="modal" data-bs-target="#addReview">Adicionar review</button>
        </div>
        <x-modal-add-review />
    @else
        <p class="text-center">Faça login para escrever um review.</p>
    @endauth

    @if(session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Lista de Reviews -->
    <div class="mt-5">
        @foreach($reviews as $rev)
            <x-card-review :review="$rev" />
        @endforeach
    </div>
</div>
