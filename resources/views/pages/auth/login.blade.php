@extends('layouts.main')
@section('container')
    <section class="auth my-auto">
        <div class="container d-flex flex-column">
            <a href="{{ url('/') }}">
                <img class="logo__ mb-3 mb-md-5"src="{{ asset('images/itsfood21 landscape.png') }}" alt="">
            </a>
            <div class="card rounded-3 col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4 mx-auto" style="overflow: hidden;">
                <h3 class="py-3 mb-0 bg-warning fw-bold text-center">MASUK</h3>
                <div class="card-body shadow-lg p-3 p-md-4">
                    <form action="{{ route('loginCheck') }}" class="d-flex flex-column" method="POST" id="form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email / Phone</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                                name="username" placeholder="Masukan email atau phone" value="{{ old('username') }}">
                            @error('email')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Masukan Password" value="{{ old('password') }}">
                            @error('password')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <a href="/" class="text-danger text-end text-decoration-none mb-3">Lupa Password
                            ?</a>
                        <button type="submit" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onSubmit"
                            data-action="submit"
                            class="btn btn-primary btn-custom mb-3 mb-md-5 fw-bold bg-blue g-recaptcha">Masuk</button>
                        <p class="mb-3">Belum punya akun ? <a href="{{ url('/signup') }}"
                                class="text-success text-decoration-none fw-bold">Daftar</a></p>
                    </form>
                    <div class="text-center  my-4">
                        <a href="/" class="text-blue text-decoration-none font-bold">Bantuan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
