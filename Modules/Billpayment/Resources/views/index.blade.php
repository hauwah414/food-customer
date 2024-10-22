@extends('layouts.dynamic')
@section('container')
    <section class="container py-3 py-lg-5">
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
                    <a class="nav_link {{ Request::is('billpayment/order') ? 'active' : '' }}"
                        href="{{ url('/billpayment/order') }}">Pesanan</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link {{ Request::is('billpayment') ? 'active' : '' }}" href="{{ url('/billpayment') }}"
                        aria-current="page">Belum dibayar</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link {{ Request::is('billpayment/waiting') ? 'active' : '' }}"
                        href="{{ url('/billpayment/waiting') }}">Menunggu</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link {{ Request::is('billpayment/done') ? 'active' : '' }}"
                        href="{{ url('/billpayment/done') }}">Selesai</a>
                </li>
            </ul>
            <div class="" id="ResultBillpayment">
                @include('billpayment::components.detail')
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

            @if (Request::is('billpayment'))
                let type = 'billpayment';
            @elseif (Request::is('billpayment/waiting'))
                let type = 'waiting';
            @elseif (Request::is('billpayment/done'))
                let type = 'done';
            @elseif (Request::is('billpayment/order'))
                let type = 'order';
            @endif

            $.ajax({
                url: `/billpayment/filter`,
                type: "POST",
                cache: false,
                data: {
                    "dateStart": dateStart,
                    "dateEnd": dateEnd,
                    "type": type,
                    "_token": token
                },
                success: function(response) {
                    $("#ResultBillpayment").html(response)
                },
            });

        }

        $('body').on('click', '#paginationBillpayment', function() {
            let dateStart = $('#dateStart').val();
            let dateEnd = $('#dateEnd').val();
            let page = $(this).data('page');
            let token = $("meta[name='csrf-token']").attr("content");

            @if (Request::is('billpayment'))
                let type = 'billpayment';
            @elseif (Request::is('billpayment/waiting'))
                let type = 'waiting';
            @elseif (Request::is('billpayment/done'))
                let type = 'done';
            @endif

            $.ajax({
                url: `/billpayment/filter`,
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
                    $("#ResultBillpayment").html(response)
                },
            });
        });
    </script>
@endpush
