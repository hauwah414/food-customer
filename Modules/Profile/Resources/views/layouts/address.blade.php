<div class="col-12 mt-3 mt-md-4">
    <div class="accordion  rounded-2  shadow" id="accordionAddress">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseAddress" aria-controls="collapseAddress">
                    <h4 class="mb-0">Personal Info</h4>
                </button>
            </h2>
            <div id="collapseAddress" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionAddress">
                <form action="{{ route('profile-updateAddress') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold">Tanggal Lahir</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    name="birth_date" id="birth_date"
                                    value="{{ $data['profile']['personal_data']['birth_date'] ?? '' }}" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold">Kode Pos</label>
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0">
                                <input type="number"
                                    class="form-control @error('address_postal_code') is-invalid @enderror"
                                    name="address_postal_code" id="address_postal_code"
                                    value="{{ $data['profile']['personal_data']['address_postal_code'] ?? '' }}"
                                    required>
                                @error('address_postal_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row  mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold mb-0">Provinsi</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <select class="form-select @error('id_province') is-invalid @enderror"
                                    name="id_province" id="id_province" data-placeholder="Pilih">
                                    <option></option>
                                    @foreach ($data['province'] as $itemProvince)
                                        <option value="{{ $itemProvince['id_province'] }}"
                                            @if ($itemProvince['id_province'] == $data['profile']['personal_data']['id_province']) selected @endif>
                                            {{ $itemProvince['province_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('id_province')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold mb-0">Kota</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <select class="form-select @error('id_city') is-invalid @enderror" name="id_city"
                                    id="id_city" data-placeholder="Pilih">
                                    <option></option>
                                </select>
                                @error('id_city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold mb-0">Kecamatan</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <select class="form-select @error('id_district') is-invalid @enderror"
                                    name="id_district" id="id_district" data-placeholder="Pilih">
                                    <option></option>
                                </select>
                                @error('id_district')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold mb-0">Kabupaten</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <select class="form-select @error('id_subdistrict') is-invalid @enderror"
                                    name="id_subdistrict" id="id_subdistrict" data-placeholder="Pilih">
                                    <option></option>
                                </select>
                                @error('id_subdistrict')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 d-md-flex align-items-center">
                                <label class="fw-bold">Address</label>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <textarea class="form-control  @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ $data['profile']['personal_data']['address'] ?? '' }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div> 
                        <div class="text-lg-end mt-3 mt-md-5">
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
        $(document).ready(function() {
            $('#id_province').select2({
                theme: "bootstrap-5", 
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });
            $('#id_city').select2({
                theme: "bootstrap-5", 
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

            $('#id_district').select2({
                theme: "bootstrap-5", 
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });
            $('#id_subdistrict').select2({
                theme: "bootstrap-5", 
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

            function getCity() {
                var selectedProvince = $('#id_province').val();
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url: `/profile/ajaxCities`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_province": selectedProvince,
                        "_token": token
                    },
                    success: function(response) {
                        $('#id_city').empty();
                        let id = {{ $data['profile']['personal_data']['id_city'] ?? '0' }};

                        response.data.result.forEach(function(city) {
                            var option = '<option value="' + city.id_city + '">' + city
                                .city_name + '</option>'; 
                            if (city.id_city === id) {
                                option = '<option value="' + city.id_city + '" selected>' + city
                                    .city_name + '</option>';
                            }
                            $('#id_city').append(option);
                        });
                        getDistrict();
                    },
                    error: function(xhr, status, error) {
                        // console.log(error);
                    }
                });
            } 

            $('#id_province').change(function() {
                getCity();
            });

            getCity();

            function getDistrict() {
                var selectedCity = $('#id_city').val();
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({

                    url: `/profile/ajaxDistricts`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_city": selectedCity,
                        "_token": token
                    },
                    success: function(response) {
                        $('#id_district').empty(); 
                        let ids = {{ $data['profile']['personal_data']['id_district'] ?? '0' }};

                        response.data.result.forEach(function(district) {
                            var option = '<option value="' + district.id_district + '">' + district
                                .district_name + '</option>'; 
                            if (district.id_district === ids) {
                                option = '<option value="' + district.id_district + '" selected>' + district
                                    .district_name + '</option>';
                            }
                            $('#id_district').append(option);
                        });
                        getsubDistric();

                    },
                    error: function(xhr, status, error) {
                        // console.log(error);
                    }
                });
            }

            $('#id_city').change(function() {
                getDistrict();
            }); 

            function getsubDistric() {
                var selectedistric = $('#id_district').val();
                let token = $("meta[name='csrf-token']").attr("content");
                $.ajax({

                    url: `/profile/ajaxSubDistric`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_district": selectedistric,
                        "_token": token
                    },
                    success: function(response) {
                        $('#id_subdistrict').empty();
                        response.data.result.forEach(function(district) {
                            $('#id_subdistrict').append(`<option value="` + district
                                .id_subdistrict +
                                `" @if ($data['profile']['personal_data']['id_subdistrict'] == `+district.id_subdistrict+`) selected @endif>` +
                                district.subdistrict_name + `</option>`);
                        });
                    },
                    error: function(xhr, status, error) {
                        // console.log(error);
                    }
                });
            }

            $('#id_district').change(function() {
                getsubDistric();
            });
 
        });
    </script>
@endpush
