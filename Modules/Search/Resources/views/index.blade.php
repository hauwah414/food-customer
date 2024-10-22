@extends('layouts.dynamic')
@section('container')
    <section class="py-3 py-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            <div class="row">
                <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
                    <div class="card" style="border: 1px solid #013880;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="text-blue">Search</h5>
                            <input type="search" class="form-control" id="keySearch"
                                @if (isset(session('search')['key'])) value="{{ session('search')['key'] }}" @endif
                                placeholder="Search">
                            <h5 class="text-blue mt-3">Harga</h5>

                            <div class="wrapper">
                                <div class="price-input flex-column mt-0 mb-3">
                                    <div class="field">
                                        <span class="me-2">Min</span>
                                        <input type="number" class="form-control input-min"
                                            @if (isset(session('search')['min_value'])) value="{{ session('search')['min_value'] }}"@else value="0" @endif>
                                    </div>
                                    <div class="field">
                                        <span class="me-2">Max</span>
                                        <input type="number" class="form-control input-max"
                                            @if (isset(session('search')['max_value'])) value="{{ session('search')['max_value'] }}" @else value="500000" @endif>
                                    </div>
                                </div>
                                <div class="slider">
                                    <div class="progress"></div>
                                </div>
                                <div class="range-input">
                                    <input type="range" class="range-min" id="startPrice" min="0" max="500000"
                                        @if (isset(session('search')['min_value'])) value="{{ session('search')['min_value'] }}" @else value="0" @endif
                                        step="1000">
                                    <input type="range" class="range-max" id="endPrice" min="0" max="500000"
                                        @if (isset(session('search')['max_value'])) value="{{ session('search')['max_value'] }}" @else value="500000" @endif
                                        step="1000">
                                </div>
                            </div>
                            <button class="btn btn-primary mt-4" onclick="clickSearch()">Cari</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-8 col-lg-9" id="resultSearch">
                    @include('search::component.search_result')
                </div>
            </div>

        </div>
    </section>
@endsection



@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rangeInput = document.querySelectorAll(".range-input input"),
                priceInput = document.querySelectorAll(".price-input input"),
                range = document.querySelector(".slider .progress");
            let priceGap = 10000;

            function setRangeStyle() {
                let minPrice = parseInt(priceInput[0].value),
                    maxPrice = parseInt(priceInput[1].value);

                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }

            setRangeStyle();
            priceInput.forEach((input) => {
                input.addEventListener("input", (e) => {
                    let minPrice = parseInt(priceInput[0].value),
                        maxPrice = parseInt(priceInput[1].value);

                    if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                        rangeInput[0].value = minPrice;
                        rangeInput[1].value = maxPrice;
                        setRangeStyle();
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
                        setRangeStyle();
                    }
                });
            });

        });


        function clickSearch() {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            } else {
                alert('Browser Anda tidak mendukung geolocation');
            }
            let token = $("meta[name='csrf-token']").attr("content");
            let key = $("#keySearch").val();
            let startPrice = $("#startPrice").val();
            let endPrice = $("#endPrice").val();

            function success(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                $.ajax({
                    url: `/search`,
                    type: "POST",
                    cache: false,
                    data: {
                        "longitude": longitude,
                        "latitude": latitude,
                        "key": key,
                        "min_value": startPrice,
                        "max_value": endPrice,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultSearch").html(response)
                    },
                });
            }

            function error() {
                $.ajax({
                    url: `/search`,
                    type: "POST",
                    cache: false,
                    data: {
                        "key": key,
                        "min_value": startPrice,
                        "max_value": endPrice,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultSearch").html(response)
                    },
                });
            }
        }

        $('body').on('click', '#paginationSearch', function() {

            let id_page = $(this).data('page');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            } else {
                alert('Browser Anda tidak mendukung geolocation');
            }
            let token = $("meta[name='csrf-token']").attr("content");
            let key = $("#keySearch").val();
            let startPrice = $("#startPrice").val();
            let endPrice = $("#endPrice").val();

            function success(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                $.ajax({
                    url: `/search/pagination`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_page": id_page,
                        "longitude": longitude,
                        "latitude": latitude,
                        "key": key,
                        "min_value": startPrice,
                        "max_value": endPrice,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultSearch").html(response)
                    },
                });
            }

            function error() {
                $.ajax({
                    url: `/search/pagination`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_page": id_page,
                        "key": key,
                        "min_value": startPrice,
                        "max_value": endPrice,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultSearch").html(response)
                    },
                });
            }
        });
    </script>
@endpush
