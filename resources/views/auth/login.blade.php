@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title-white text-center">Login</h5>
                    </div>
                    <div class="card-body">
                        @if(Session::has('errorMsg'))
                            <x-alert typeAlert="error" :message="Session::get('errorMsg')" />
                        @endif
                    
                        <form id="userLoginForm" action="{{ route('user.login')}}" method="post" >
                            @csrf
                            <div class="mb-4">
                                <input type="text" class="form-control" name="userName" placeholder="username*">
                                @error('userName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        
                            <div class="mb-4">
                                <input type="password" class="form-control" name="userPassword" placeholder="senha*">
                                @error('userPassword') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <input type="submit" class="btn btn-custom w-100" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection