@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header text-center py-4">
                <h3 class="font-weight-light my-2">Login Mahasiswa</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mahasiswa.login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="small mb-1" for="email">Email</label>
                        <input type="email" class="form-control py-3 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="password">Password</label>
                        <input type="password" class="form-control py-3 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('mahasiswa.forgot.password.form') }}">Lupa Sandi?</a>
                        <button type="submit" class="btn btn-primary btn-block py-2">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection