@extends('layouts.user.appUser')

@section('title','Halaman Masuk')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <!-- Material form login -->
            <div class="card card-login d-flex">

                <h5 class="card-header bg-info white-text text-center py-4">
                <strong>{{ __('Login') }}</strong>
                </h5>
            
                <!--Card content-->
                <div class="card-body px-lg-5 pt-0 mt-5">
            
                <!-- Form -->
                <form class="text-center" style="color: #757575;" method="POST" action="{{ route('login') }}">
                    @csrf
            
                    <!-- Email -->
                    <div class="md-form mt-3">
                        <input placeholder="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            
                    <!-- Password -->
                    <div class="md-form mt-3">
                        <input placeholder="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
            
                    <div class="d-flex justify-content-around mt-3">
                    <div>
                        <!-- Remember me -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>


                    <div>
                        <!-- Forgot password -->
                        <a href="">Forgot password?</a>
                    </div>
                    </div>
            
                    <!-- Sign in button -->
                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" id="btn-login" type="submit"> {{ __('Login') }}</button>
            
                    <!-- Register -->
                    <p>Not a member?
                    <a href="{{ route('register') }}">Register</a>
                    </p>
            
                    <!-- Social login -->
                    <p>or sign in with:</p>
                    <a type="button" class="btn-floating btn-fb btn-sm">
                    <i class="fab fa-facebook-f"></i>
                    </a>
                    <a type="button" class="btn-floating btn-tw btn-sm">
                    <i class="fab fa-twitter"></i>
                    </a>
                    <a type="button" class="btn-floating btn-li btn-sm">
                    <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a type="button" class="btn-floating btn-git btn-sm">
                    <i class="fab fa-github"></i>
                    </a>
            
                </form>
                <!-- Form -->
            
                </div>
            
            </div>
            <!-- Material form login -->


        </div>
    </div>
</div>

@endsection
