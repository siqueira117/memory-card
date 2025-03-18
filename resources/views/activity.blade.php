@extends('layout')

@section('content')
    <div class="container mt-5">
        <h1 class="fw-bold text-white mb-5">Registro de Logs</h1>

        @foreach ($logs as $log)
            <div class="bg-dark-custom p-3 rounded mb-2">
                <h4 class="text-success" style="font-family: FreeMono, monospace;">{{ $log->model_type }}</h4>
                <p>{{ $log->description }}</p>
                <small class="text-light">{{ $log->created_at->diffForHumans() }}</small>
            </div>
        @endforeach

        {{-- {{ $logs->links() }} --}}
    </div>
@endsection
