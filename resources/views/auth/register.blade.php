@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="title-white text-center">Cadastre-se</h5>
                </div>
                <div class="card-body">
                    <form id="userRegisterForm" action="{{ route('user.register')}}" method="post" >
                        @csrf
                        <div class="mb-4">
                            <input type="text" class="form-control" name="userName" placeholder="username*">
                            @error('userName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="mb-4">
                            <input type="email" class="form-control" name="userEmail" placeholder="email*">
                            @error('userEmail') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="mb-4">
                            <input type="password" class="form-control" name="userPassword" placeholder="senha*">
                            @error('userPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    
                        <div class="mb-4">
                            <input type="password" class="form-control" name="userPassword_confirmation" placeholder="confirme sua senha*">
                        </div>
                        <input type="submit" class="btn btn-custom w-100" value="Cadastrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection