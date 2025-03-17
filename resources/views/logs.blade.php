@extends('layout')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Registro de Logs</h2>

        @foreach ($logs as $log)
            <div class="bg-dark-custom p-3 rounded mb-2">
                <h4 class="text-success" style="font-family: FreeMono, monospace;">{{ $log->model_type }}</h4>
                <p>{{ $log->description }}</p>
                <small class="text-light">{{ $log->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
        

        {{-- <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Modelo</th>
                    <th>ID</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->model_type }}</td>
                        <td>{{ $log->model_id }}</td>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}

        {{ $logs->links() }}
    </div>
@endsection
