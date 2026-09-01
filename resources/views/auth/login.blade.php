@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h4 class="fw-semibold mb-1">Selamat Datang!</h4>
                    <p class="text-muted small mb-4">Silakan login untuk melanjutkan</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>

                        <button type="submit" class="btn w-100 text-white" style="background-color: #8B6F5B;">
                            Login
                        </button>

                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a class="small" href="{{ route('password.request') }}" style="color: #6B4F3F;">Lupa password?</a>
                            </div>
                        @endif
                    </form>

                    <p class="text-center small text-muted mt-4 mb-0">
                        Belum punya akun?
                        <a href="{{ route('register') }}" style="color: #6B4F3F;">Daftar di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection