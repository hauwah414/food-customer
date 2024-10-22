<div class="col-12 mt-3 mt-lg-0">
    <div class="accordion rounded-2  shadow" id="accordionInfo">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfo"
                    aria-expanded="true" aria-controls="collapseInfo">
                    <h4 class="mb-0">Info Profil</h4>
                </button>
            </h2>
            <div id="collapseInfo" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionInfo">
                <form action="{{ route('profile-updateInfo') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold mb-0">Nama</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ $data['profile']['info']['name'] ?? '' }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold mb-0">Email</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ $data['profile']['info']['email'] ?? '' }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold">Telephone</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number" disabled
                                    value="0{{ $data['profile']['info']['phone'] ?? '' }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold">Kelamin</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0 d-flex">
                                <div class="form-check" style="width:unset;">
                                    <input class="form-check-input" type="radio" name="gender" value="Male"
                                        @if ($data['profile']['info']['gender'] == 'Male') checked @endif>
                                    <label class="form-check-label">
                                        Laki-Laki
                                    </label>
                                </div>
                                <div class="form-check ms-3" style="width:unset;">
                                    <input class="form-check-input" type="radio" name="gender" value="Female"
                                        @if ($data['profile']['info']['gender'] == 'Female') checked @endif>
                                    <label class="form-check-label">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-lg-end mt-3">
                            <button type="button" class="btn btn-secondary"
                                onClick="window.location.reload();">Batal</button>
                            <button type="submit" class="btn btn-primary bg-blue">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


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
    </script>
@endpush
