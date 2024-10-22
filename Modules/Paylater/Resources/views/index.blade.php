@extends('layouts.dynamic')
@section('container')
    <section class="container pt-3 pt-lg-5">
        @include('sections.breadcrumb')
        <div class="card history mt-3">
            <div class="mt-3 px-3 d-flex flex-column">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-4 col-lg-3 col-form-label fw-bold">Tanggal : </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="dateStart" onchange="filterDate()">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-4 col-lg-3 col-form-label fw-bold">Hingga : </label>
                            <div class="col-sm-8 ms-auto">
                                <input type="date" class="form-control " id="dateEnd" onchange="filterDate()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <ul class="nav_ p-0 my-0 p-0">
                <li class="nav_item">
                    <a class="nav_link {{ Request::is('paylater') ? 'active' : '' }}" href="{{ url('/paylater') }}"
                        aria-current="page">Belum dibayar</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link {{ Request::is('paylater/waiting') ? 'active' : '' }}"
                        href="{{ url('/paylater/waiting') }}">Menunggu Pembayaran</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link {{ Request::is('paylater/done') ? 'active' : '' }}"
                        href="{{ url('/paylater/done') }}">Selesai</a>
                </li>
            </ul>
            <div class="" id="ResultPaylater">
                @include('paylater::components.detail')
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        function filterDate() {
            let dateStart = $('#dateStart').val();
            let dateEnd = $('#dateEnd').val();
            let token = $("meta[name='csrf-token']").attr("content");

            @if (Request::is('paylater'))
                let type = 'paylater';
            @elseif (Request::is('paylater/waiting'))
                let type = 'waiting';
            @elseif (Request::is('paylater/done'))
                let type = 'done';
            @endif

            $.ajax({
                url: `/paylater/filter`,
                type: "POST",
                cache: false,
                data: {
                    "dateStart": dateStart,
                    "dateEnd": dateEnd,
                    "type": type,
                    "_token": token
                },
                success: function(response) {
                    $("#ResultPaylater").html(response)
                },
            });

        }

        $('body').on('click', '#paginationPaylater', function() {
            let dateStart = $('#dateStart').val();
            let dateEnd = $('#dateEnd').val();
            let page = $(this).data('page');
            let token = $("meta[name='csrf-token']").attr("content");

            @if (Request::is('paylater'))
                let type = 'paylater';
            @elseif (Request::is('paylater/waiting'))
                let type = 'waiting';
            @elseif (Request::is('paylater/done'))
                let type = 'done';
            @endif

            $.ajax({
                url: `/paylater/filter`,
                type: "POST",
                cache: false,
                data: {
                    "dateStart": dateStart,
                    "dateEnd": dateEnd,
                    "type": type,
                    "page": page,
                    "_token": token
                },
                success: function(response) {
                    $("#ResultPaylater").html(response)
                },
            });
        });
    </script>
@endpush
