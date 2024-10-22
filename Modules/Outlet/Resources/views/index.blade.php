@extends('layouts.dynamic')
@section('container')
    <style>
        .btn_alpha.active {
            background: #013880 !important;
            color: #FFF !important;
        }
    </style>
    <section class="py-3 py-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            <div class="row">
                <div class="col-md-6">
                    <h3>
                        List Vendor Itsfood
                    </h3>
                </div>
                <div class="ms-md-auto col-md-4 col-lg-3">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari nama Vendor"
                            aria-describedby="button-addon2" name="search_key" id="search_key">
                        <button class="btn btn-outline-secondary" type="button" id="buttonSearch">Cari</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-md-3">
                    <select class="form-select" id="terbaru" name="terbaru">
                        <option value="1">Terbaru</option>
                        <option value="0">Terlama</option>
                    </select>
                </div>
            </div>

            @php
                $alphabet = range('A', 'Z');
            @endphp
            <div class="d-flex flex-row flex-wrap justify-content-start">
                <button type='button' id="buttonAlpa" data-alpha="#"
                    class='btn_alpha btn btn-outline-primary rounded-5 shadow-sm me-2 mt-3 d-flex justify-content-center align-content-center'
                    style="width:32px; height:32px;">#</button>
                @foreach ($alphabet as $letter)
                    <button type='button' id="buttonAlpa" data-alpha="{{ $letter }}"
                        class='btn_alpha btn btn-outline-primary rounded-5 shadow-sm me-2 mt-3 d-flex justify-content-center align-content-center'
                        style="width:32px; height:32px;">{{ $letter }}</button>
                @endforeach
            </div>
            <div id="resultOutlet">
                @include('outlet::components.outlet')
             </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function removeActiveClass() {
            $('.btn_alpha').removeClass('active');
        }

        $('body').on('click', '#buttonAlpa', function() {
            removeActiveClass();

            $(this).addClass('active');

            let search_key = $(this).data('alpha');
            let terbaru = $('#terbaru').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/outlet/search`,
                type: "POST",
                cache: false,
                data: {
                    "search_key": search_key,
                    "terbaru": terbaru,
                    'page': '1',
                    "_token": token
                },
                success: function(response) {
                    $("#resultOutlet").html(response)
                },
            });
        });

        $('body').on('change', '#terbaru', function() {
            let search_key = $('#search_key').val();
            let terbaru = $('#terbaru').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/outlet/search`,
                type: "POST",
                cache: false,
                data: {
                    "search_key": search_key,
                    "terbaru": terbaru,
                    'page': '1',
                    "_token": token
                },
                success: function(response) {
                    $("#resultOutlet").html(response)
                },
            });
        });

        $('body').on('click', '#buttonSearch', function() {
            let search_key = $('#search_key').val();
            let terbaru = $('#terbaru').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/outlet/search`,
                type: "POST",
                cache: false,
                data: {
                    "search_key": search_key,
                    "terbaru": terbaru,
                    'page': '1',
                    "_token": token
                },
                success: function(response) {
                    $("#resultOutlet").html(response)
                },
            });

        });
    </script>
@endpush
