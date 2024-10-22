@extends('layouts.dynamic')
@section('container')
    <section class="container py-3 py-lg-5">
        @include('sections.breadcrumb')
        <h4 class="mb-5">Tambah Alamat</h4>
        <div class="card">
            <div class="card-body">
                <form action="{{ url('address/update/' . $data['detail']['id_user_address']) }}" method="PUT">
                    @csrf
                    @method('PUT')
                    <div class="row my-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama</label>
                            <input type="text" class="form-control @error('receiver_name') is-invalid @enderror"
                                name="receiver_name" id="receiver_name"
                                value="{{ $data['detail']['receiver_name'] ?? '' }}">
                            @error('receiver_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Telephone</label>
                            <input type="text" class="form-control @error('receiver_phone') is-invalid @enderror"
                                name="receiver_phone" id="receiver_phone"
                                value="{{ $data['detail']['receiver_phone'] ?? '' }}">
                            @error('receiver_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control @error('receiver_email') is-invalid @enderror"
                                name="receiver_email" id="receiver_email"
                                value="{{ $data['detail']['receiver_email'] ?? '' }}">
                            @error('receiver_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Kode Post</label>
                            <input type="number" class="form-control @error('postal_code') is-invalid @enderror"
                                name="postal_code" id="postal_code"value="{{ $data['detail']['postal_code'] ?? '' }}">
                            @error('postal_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Provinsi</label>
                            <select class="form-select @error('id_province') is-invalid @enderror" name="id_province"
                                id="id_province" data-placeholder="Pilih">
                                <option></option>
                                @foreach ($data['province'] ?? [] as $itemProvince)
                                    <option value="{{ $itemProvince['id_province'] }}"
                                        @if ($itemProvince['id_province'] == $data['detail']['id_province']) selected @endif>
                                        {{ $itemProvince['province_name'] }}</option>
                                @endforeach
                            </select>
                            @error('id_province')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kota</label>
                            <select class="form-select @error('id_city') is-invalid @enderror" name="id_city" id="id_city"
                                data-placeholder="Pilih">
                                <option></option>
                                @foreach ($data['city'] ?? [] as $itemCity)
                                    <option value="{{ $itemCity['id_city'] }}"
                                        @if ($itemCity['id_city'] == $data['detail']['id_city']) selected @endif>
                                        {{ $itemCity['city_name'] }}</option>
                                @endforeach
                            </select>
                            @error('id_city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kecamatan</label>
                            <select class="form-select @error('id_district') is-invalid @enderror" name="id_district"
                                id="id_district" data-placeholder="Pilih">
                                <option></option>
                                @foreach ($data['district'] ?? [] as $itemDistrict)
                                    <option value="{{ $itemDistrict['id_district'] }}"
                                        @if ($itemDistrict['id_district'] == $data['detail']['id_district']) selected @endif>
                                        {{ $itemDistrict['district_name'] }}</option>
                                @endforeach
                            </select>
                            @error('id_district')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kabupaten</label>
                            <select class="form-select @error('id_subdistrict') is-invalid @enderror" name="id_subdistrict"
                                id="id_subdistrict" data-placeholder="Pilih">
                                <option></option>
                                @foreach ($data['subdistrict'] ?? [] as $itemSubDistrict)
                                    <option value="{{ $itemSubDistrict['id_subdistrict'] }}"
                                        @if ($itemSubDistrict['id_subdistrict'] == $data['detail']['id_subdistrict']) selected @endif>
                                        {{ $itemSubDistrict['subdistrict_name'] }}</option>
                                @endforeach
                            </select>
                            @error('id_subdistrict')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" class="form-control @error('location_name') is-invalid @enderror"
                                name="location_name" id="location_name"value="{{ $data['detail']['address'] ?? '' }}">
                            @error('location_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3">{{ $data['detail']['address'] ?? '' }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude"
                        hidden id="latitude" value="{{ $data['detail']['latitude'] ?? '' }}">
                    <input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude"
                        hidden id="longitude"value="{{ $data['detail']['longitude'] ?? '' }}">
                    <div class="text-md-end">
                        <a href="{{ url('address') }}" class="btn btn-outline-secondary me-3">Kembali</a>
                        <button class="btn btn-primary" type="submit">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ ENV('GOOGLE_MAPS_KEY') }}&libraries=places"></script>
    <script>
        function initAutocomplete() {
            const input = document.getElementById('location_name');
            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                const address = document.getElementById('address');
                address.value = place.formatted_address;

                const latitude = document.getElementById('latitude');
                const longitude = document.getElementById('longitude');

                latitude.value = place.geometry.location.lat();
                longitude.value = place.geometry.location.lng();
            });
        }

        window.addEventListener('load', () => {
            initAutocomplete();
        });
        Inputmask({
            "mask": "9999 9999 999999",
        }).mask("#receiver_phone");

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
                url: `/address/ajaxCities`,
                type: "POST",
                cache: false,
                data: {
                    "id_province": selectedProvince,
                    "_token": token
                },
                success: function(response) {
                    $('#id_city').empty();
                    response.data.result.forEach(function(city) {
                        $('#id_city').append(`<option value="` + city.id_city + `">` + city.city_name +
                            `</option>`);
                    });
                    getDistrict();
                },
                error: function(xhr, status, error) {}
            });
        }

        $('#id_province').change(function() {
            getCity();
        });

        function getDistrict() {
            var selectedCity = $('#id_city').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({

                url: `/address/ajaxDistricts`,
                type: "POST",
                cache: false,
                data: {
                    "id_city": selectedCity,
                    "_token": token
                },
                success: function(response) {
                    $('#id_district').empty();
                    response.data.result.forEach(function(district) {
                        $('#id_district').append(`<option value="` + district.id_district + `">` +
                            district
                            .district_name +
                            `</option>`);
                    });
                    getsubDistric();

                },
                error: function(xhr, status, error) {}
            });
        }

        $('#id_city').change(function() {
            getDistrict();
        });

        function getsubDistric() {
            var selectedistric = $('#id_district').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({

                url: `/address/ajaxSubDistric`,
                type: "POST",
                cache: false,
                data: {
                    "id_district": selectedistric,
                    "_token": token
                },
                success: function(response) {
                    $('#id_subdistrict').empty();
                    response.data.result.forEach(function(subdistrict) {
                        $('#id_subdistrict').append(`<option value="` + subdistrict.id_subdistrict +
                            `">` +
                            subdistrict.subdistrict_name +
                            `</option>`);
                    });
                },
                error: function(xhr, status, error) {}
            });
        }

        $('#id_district').change(function() {
            getsubDistric();
        });
    </script>
@endpush
