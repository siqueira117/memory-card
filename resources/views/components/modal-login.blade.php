<div class="modal fade" id="userLogin" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="gameModalLabel">Login</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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