@extends('layouts.main')
@section('container')
    <section class="auth my-lg-auto">
        <div class="container">
            <a href="{{ url('/') }}">
                <img class="logo__"src="{{ asset('images/itsfood21 landscape.png') }}" alt="">
            </a>
            <div class="card rounded-3 col-md-10 col-lg-8 col-xl-6" style="overflow: hidden;">
                <h3 class="py-3 mb-0 bg-warning fw-bold text-center">DAFTAR ITSFOOD</h3>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('registerPost') }}" class="d-flex flex-column" method="POST" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                                placeholder="Alamat Lengkap" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Handphone</label>
                                <input type="text" id="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                    placeholder="No. Handphone" value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birthday') is-invalid @enderror"
                                    name="birthday" placeholder="Tanggal Lahir" value="{{ old('birthday') }}" required>
                                @error('birthday')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <label class="form-label">Tanggal Lahir</label>
                        <div class="col-6 mb-3 mt-md-auto">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender" value="Male"
                                    checked>
                                <label class="form-check-label">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender" value="Female">
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Department</label>
                            <select class="form-select @error('id_department') is-invalid @enderror" name="id_department" required>
                                <option value="" selected>Pilih departement</option>
                                @foreach ($data['department'] ?? [] as $itemDepartement)
                                    <option value="{{ $itemDepartement['id_department'] }}"
                                        @if (old('id_department') == $itemDepartement['id_department']) selected @endif>
                                        {{ $itemDepartement['name_department'] }}</option>
                                @endforeach
                            </select>
                            @error('id_department')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" required>
                                @error('password')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ulangi Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" placeholder="Ulangi Password" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-3 mb-4">
                            <button type="submit" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" data-callback="onSubmit"
                                data-action="submit" class="btn btn-primary g-recaptcha px-5">Daftar</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="mb-2">Sudah memiliki akun ? <a href="{{ url('/login') }}"
                                class="text-success fw-bold text-decoration-none ">Login</a></p>
                    </div>
                    <div class="text-center  mb-4">
                        <a href="/" class="text-blue text-decoration-none font-bold">Bantuan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        Inputmask({
            "mask": "9999 9999 999999",
        }).mask("#phone_number");
    </script>
@endpush
