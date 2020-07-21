<form class="form-submit" method="POST" action="{{ route('user_update') }}">
    @csrf
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
    </div>
    <div class="modal-body">
        
       
        <div class="row">
            <label for="name" class="col-md-12 col-form-label text-md-left">Name:</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus minlength="6">

                    <span class="invalid-feedback " role="alert">
                        <strong class='name-error error-msg'></strong>
                    </span>
                </div>
        </div>

        <div class="row">
            <label for="email" class="col-md-12 col-form-label text-md-left">E-Mail Address:</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

                    <span class="invalid-feedback " role="alert">
                        <strong class='email-error error-msg'></strong>
                    </span>
                </div>
        </div>

        <div class="row {{$user->is_waiter == 1 ? 'hide-removeme':''}}">
            <label for="permission_id" class="col-md-12 col-form-label text-md-left">Permission</label>

            <div class="col-md-12">
                <select class='form-control' name='permission_id' {{$user->is_waiter == 0 ? 'required="required"':''}} >
                    <option value="" disabled selected>-Select Permission-</option>
                    @foreach($permissions as $key => $value)
                        <option value="{{$value->permission_id}}" {{$user->permission_id == $value->permission_id ? 'selected' : '' }} >{{$value->permission_name}}</option>
                    @endforeach 
                </select>

                <span class="invalid-feedback " role="alert">
                    <strong class='permission_id-error error-msg'></strong>
                </span>
            </div>
        </div>
        
        <hr>
        <i><p>If you'd like to change your password type a new one. Otherwise leave it blank.</p></i>
        <div class="row">
            <label for="password" class="col-md-12 col-form-label text-md-left">Password:</label>

                <div class="col-md-12">
                    <input id="password" type="password" min="6" class="form-control password-update @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                    <span class="invalid-feedback " role="alert">
                        <strong class='password-error error-msg'></strong>
                    </span>
                </div>
        </div>

        <div class="row">
            <label for="password-confirm" class="col-md-12 col-form-label text-md-left">Confirm Password:</label>

                <div class="col-md-12">
                    <input id="password-confirm" min="6" type="password" class="form-control password-update" name="password_confirmation"  autocomplete="new-password">
                </div>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" type="submit">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>