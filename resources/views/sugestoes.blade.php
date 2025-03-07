@extends('layout')

@section('content')
<div class="container mt-5 w-80 rounded-1 bg-dark p-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="fw-bold text-center title">Sugestões e Pedidos</h2>
            <p class="text-center subtitle">Tem um jogo que gostaria de ver aqui? Envie sua sugestão!</p>

            <!-- Mensagem de Sucesso -->
            @if(session('success'))
                <x-alert typeAlert="success" :message="session('success')" />
            @endif

            <!-- Formulário -->
            <form action="{{ route('suggestion.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome*</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail*</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="game" class="form-label">Tipo</label>
                    <select class="form-select @error('type') is-invalid @enderror" aria-label="tipoSugestao" name="type" required>
                        <option selected value="game">Adicionar jogo</option>
                        <option value="site">Melhoria no site</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Mensagem</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4" required></textarea>
                    @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-custom w-100">Enviar Sugestão</button>
            </form>
        </div>
    </div>
</div>
@endsection
