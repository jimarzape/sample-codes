<form class="form-submit" method="POST" action="{{ route('user_save') }}">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">Create User</h4>
        </div>
        <div class="modal-body">
            
          
            <div class="row">
                <label for="name" class="col-md-12 col-form-label text-md-left">Name:</label>

                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" minlength="6" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        <span class="invalid-feedback " role="alert">
                            <strong class='name-error error-msg'></strong>
                        </span>
                    </div>
            </div>

            <div class="row">
                <label for="email" class="col-md-12 col-form-label text-md-left">E-Mail Address:</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        <span class="invalid-feedback " role="alert">
                            <strong class='email-error error-msg'></strong>
                        </span>
                    </div>
            </div>

            <div class="row">
                <label for="password" class="col-md-12 col-form-label text-md-left">Password:</label>

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        <span class="invalid-feedback " role="alert">
                            <strong class='password-error error-msg'></strong>
                        </span>
                    </div>
            </div>

            <div class="row ">
                <label for="password-confirm" class="col-md-12 col-form-label text-md-left">Confirm Password:</label>

                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
            </div>

         
            <div class="row div-premission">
                <label for="permission_id" class="col-md-12 col-form-label text-md-left">Permission</label>

                <div class="col-md-12">
                    <select class='form-control' id="permission_id" name='permission_id' required="required">
                        <option value="" disabled selected>-Select Permission-</option>
                        @foreach($permissions as $key => $value)
                            <option value="{{$value->permission_id}}">{{$value->permission_name}}</option>
                        @endforeach 
                    </select>

                    <span class="invalid-feedback " role="alert">
                        <strong class='permission_id-error error-msg'></strong>
                    </span>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" type="submit">Register</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>