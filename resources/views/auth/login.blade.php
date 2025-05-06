@extends('layouts.auth')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center mt-3"> {{-- Margin top 15px --}}
        <div class="col-lg-8 rounded-4 shadow p-4 d-flex flex-column flex-md-row align-items-center justify-content-between"
             style="background-color: #E5CBB7;"> {{-- Lebar form diperkecil --}}

            {{-- Form Login --}}
            <div class="col-md-6 px-4">
                <h2 class="text-center fw-bold mb-4 text-dark mt-2">Masuk</h2> {{-- Margin top 10px di atas H1 --}}

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark">Email</label>
                        <input id="email" type="email" name="email" placeholder="Masukan Email Anda"
                            value="{{ old('email') }}" required autofocus
                            class="form-control @error('email') is-invalid @enderror bg-white">

                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="form-label text-dark">Password</label>
                        <input id="password" type="password" name="password" placeholder="Masukan Password Anda"
                            required class="form-control @error('password') is-invalid @enderror bg-white">

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Login --}}
                    <div class="text-center mb-3">
                        <button type="submit" class="btn bg-light text-dark px-5">
                            Masuk
                        </button>
                    </div>
                </form>

                <p class="text-center text-muted small mt-3">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary">Daftar</a>
                </p>
            </div>

            {{-- Gambar --}}
            <div class="col-md-6 text-center mt-4 mt-md-0">
                <img src="{{ asset('images/kucing.png') }}" alt="Login Image" class="img-fluid" style="max-width: 250px;">
            </div>
        </div>
    </div>
</div>
@endsection
