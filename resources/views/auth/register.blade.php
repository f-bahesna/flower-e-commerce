@extends('layouts.user.appUser')

@section('title','Halaman Pendaftaran')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center ">
        <div class="col-md-5">
            <!-- Material form register -->
            <div class="card card-register d-flex">

                <h5 class="card-header bg-success white-text text-center py-4">
                    <strong>{{ __('Register') }}</strong>
                </h5>

                <!--Card content-->
                <div class="card-body px-lg-5 pt-0 mt-3">

                    <!-- Form -->
                    <form class="text-center form-register"  method="POST" style="color: #757575;" action="{{ route('user.register') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col">
                                <!-- name -->
                                <div class="md-form">
                                    <input placeholder="Nama" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="col">
                                <!-- Nomor HP -->
                                <div class="md-form">
                                    <input placeholder="Nomor HP" id="nomor_telepon" type="number" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required autofocus>
                                </div>

                                @error('nomor_telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <!-- E-mail -->
                        <div class="md-form mt-0 mt-3">
                            <input placeholder="email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="md-form mt-3">
                            <input placeholder="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <small id="materialRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                Minimal 8 kata dan 1 angka
                            </small>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="md-form">
                            <input placeholder="ulangi password" id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            <small id="materialRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                Ulangi password anda
                            </small>
                        </div>

                        <!-- Sign up button -->
                        <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" id="btn-register">{{ __('Register') }}</button>

                        <!-- Social register -->
                        <p>or sign up with:</p>

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

                        <hr>

                        <!-- Terms of service -->
                        <p>Setelah daftar anda setuju dengan
                            <a href="" target="_blank">aturan aturan yang berlaku</a>
                    </form>
                    <!-- Form -->

                </div>

            </div>
            <!-- Material form register -->
        </div>
    </div>
</div>
@endsection
