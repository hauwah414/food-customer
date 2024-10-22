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
    <section class="banner_search">
        @if (session('detail_user') == null)
            <div class="nav_login nav_login_absolute">
                <div class="container">
                    <img src="{{ asset('images/itsfood21 landscape.png') }}"
                        alt="{{ asset('images/itsfood21 landscape.png') }}">
                    <div class="right_">
                        <a href="{{ url('signup') }}" class="btn btn-primary">Daftar</a>
                        <a href="{{ url('login') }}" class="btn btn-primary ms-3">Masuk</a>
                    </div>
                </div>
            </div>
        @endif
        <img src="{{ $data['background']['splash_screen_url'] ?? '' }}"
            alt="{{ $data['background']['splash_screen_url'] ?? '' }}">
        <div class="items_center">
            <div class="container">
                <div class="input">
                    <div class="search_">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" class="form-control" placeholder="Cari makanan" id="keySearch" autocomplete="off">
                    </div>
                    <div class="right_">
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                            data-bs-target="#modalSearchPrice">
                            <i class="fa-solid fa-coins me-2"></i>
                            Harga
                        </button>

                        <button class="btn btn-link ms-3" type="button" id="search" onclick="clickSearch()">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalSearchPrice" tabindex="-1" aria-labelledby="modalSearchPriceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="wrapper">
                        <div class="price-input">
                            <div class="field">
                                <span class="me-2">Min</span>
                                <input type="number" class="form-control input-min" value="0">
                            </div>
                            <div class="field">
                                <span class="mx-2">Max</span>
                                <input type="number" class="form-control input-max" value="500000">
                            </div>
                        </div>
                        <div class="slider">
                            <div class="progress"></div>
                        </div>
                        <div class="range-input">
                            <input type="range" class="range-min" id="startPrice" min="0" max="500000"
                                value="0" step="1000">
                            <input type="range" class="range-max" id="endPrice" min="0" max="500000"
                                value="500000" step="1000">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal"
                            onclick="clickSearch()">Pilih</button>
                    </div>

                </div>
            </div>
        </div>
    </div>


    @include('dashboard::components.banner')
    @include('dashboard::components.best')
    {{-- @include('dashboard::components.newest') --}}
    @include('dashboard::components.recommendation')
    @include('dashboard::components.products')
    @include('dashboard::components.outlet')
@endsection

@push('scripts')
    <script>
        $('body').on('keypress', '#keySearch', function() {
            if (event.key === "Enter") {
              clickSearch();
            }
        });

        function clickSearch() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            } else {
                alert('Browser Anda tidak mendukung geolocation');
            }

            let token = $("meta[name='csrf-token']").attr("content");

            function success(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                let key = $("#keySearch").val();
                let startPrice = $("#startPrice").val();
                let endPrice = $("#endPrice").val();


                $.ajax({
                    url: `/dashboard/search`,
                    type: "POST",
                    cache: false,
                    data: {
                        "key": key,
                        "min_value": startPrice,
                        "max_value": endPrice,
                        "longitude": longitude,
                        "latitude": latitude,
                        "_token": token
                    },
                    success: function(response) {
                        window.location.href = '/search'; 
                    },
                });
            }

            function error() {
                let key = $("#keySearch").val();
                let startPrice = $("#startPrice").val();
                let endPrice = $("#endPrice").val();

                $.ajax({
                    url: `/dashboard/search`,
                    type: "POST",
                    cache: false,
                    data: {
                        "key": key,
                        "min_value": startPrice,
                        "max_value": endPrice,
                        "_token": token
                    },
                    success: function(response) {
                        window.location.href = '/search';
                    },
                });
            }
        }
        const rangeInput = document.querySelectorAll(".range-input input"),
            priceInput = document.querySelectorAll(".price-input input"),
            range = document.querySelector(".slider .progress");
        let priceGap = 10000;

        priceInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = parseInt(priceInput[0].value),
                    maxPrice = parseInt(priceInput[1].value);

                if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                    rangeInput[0].value = minPrice;
                    rangeInput[1].value = maxPrice;
                    range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                    range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                }
            });
        });

        rangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minVal = parseInt(rangeInput[0].value),
                    maxVal = parseInt(rangeInput[1].value);

                if (maxVal - minVal < priceGap) {
                    rangeInput[0].value = maxVal - priceGap;
                } else {
                    priceInput[0].value = minVal;
                    priceInput[1].value = maxVal;
                    range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                    range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
                }
            });
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
