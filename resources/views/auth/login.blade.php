@extends('auth.layout')

@section('content')
<div class="login-card card-block auth-body m-auto">
    <form method="POST" action="{{ route('login') }}">
         @csrf
        <div class="text-center text-white">
        </div>
        
           
        <div class="auth-box">
            <div class="row m-b-20">
                <div class="col-md-12">
                    <h3 class="text-center">Ordering System</h3>
                    <h3 class="text-left txt-primary">{{ __('Login') }}</h3>
                </div>
            </div>
            <hr/>

            <div class="input-group">
                <input type="email"  name="email" value="{{ old('email') }}" class="form-control form-control @error('email') is-invalid @enderror" placeholder="Your Email Address" required autocomplete="email" autofocus>
                
                <span class="md-line"></span>
            </div>
            <div class="input-group">
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                
                <span class="md-line"></span>
            </div>
            <div class="row  m-b-20 text-center">
                <div class="col-md-12">
                @error('email')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('password')
                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>
            <div class="row m-t-25 text-left">
                <div class="col-sm-7 col-xs-12 pl-18">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span class="text-inverse">Remember me</span>
                        </label>
                    </div>
                </div>
               <!--  <div class="col-sm-5 col-xs-12 forgot-phone text-right">
                    <a href="{{ route('password.request') }}" class="text-right f-w-600 text-inverse"> Forgot Your Password?</a>
                </div> -->
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign in</button>
                </div>
            </div>
            <hr/>
            

        </div>
    </form>
    <!-- end of form -->
</div>

@endsection
