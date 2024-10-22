{{-- @extends('profile::layouts.master') --}}
@extends('layouts.dynamic')
@section('container')
    @if (session('error'))
        <div class="alert d-none" id="alertError">
            <p id="valueError">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="alert d-none" id="alertSuccess">
            <p id="valueSuccess">{{ session('success') }}</p>
        </div>
    @endif
    <div class="container py-3 py-lg-5">
        @include('sections.breadcrumb')
        <div class="row mt-3">
            <div class="col-lg-3">
                <div class="card shadow rounded-2 profile_image_card" style="border: 0;">
                    <form action="{{ route('profile-updatePhoto') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card-body  d-flex flex-column align-items-center">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' id="imageUpload" name="photo" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview ">
                                    @if ($data['profile']['photo'] == null)
                                        <div id="imagePreview"
                                            style="background-image: url({{ asset('images/avatar.jpg') }});"></div>
                                    @else
                                        <div id="imagePreview"
                                            style="background-image: url({{ $data['profile']['photo'] }});"></div>
                                    @endif
                                </div>
                                @error('photo')
                                    <p class="text-danger mt-3 text-center">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Ubah Photo
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-9 mt-3 mt-lg-0">
                <div class="row">
                    @include('profile::layouts.info')
                    @include('profile::layouts.address')
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection

@push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
        var alertSuccessElement = document.getElementById('alertSuccess');

        if (alertSuccessElement && alertSuccessElement.classList.contains('alert')) {
            var valueSuccess = document.getElementById('valueSuccess');
            Swal.fire({
                type: 'success',
                icon: 'success',
                title: valueSuccess,
                showConfirmButton: false,
                timer: 3000
            });
        }

        var alertErrorElement = document.getElementById('alertError');

        if (alertErrorElement && alertErrorElement.classList.contains('alert')) {
            var valueError = document.getElementById('valueError');
            Swal.fire({
                type: 'warning',
                icon: 'warning',
                title: valueError,
                showConfirmButton: false,
                timer: 3000
            });
        }
    </script>
@endpush
