@extends('layouts.dynamic')
@section('container')
    <section class="container py-3 py-lg-5">
        @include('sections.breadcrumb')

        <div class="card history mt-3">
            <div class="mt-3 px-3">
                <div class="row">
                    <div class="col-lg-7 col-xl-6 mb-3">
                        <div class="row">
                            <div class="col-6 my-auto col-lg-4">
                                <label class="fw-bold">Nama Outlet :</label>
                            </div>
                            <div class="col-6 col-lg-7">
                                <input type="text" class="form-control" id="outlet_name" onkeyup="funCheck()">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 my-auto col-lg-4">
                                <label class="fw-bold">No Transaksi :</label>
                            </div>
                            <div class="col-6 col-lg-7">
                                <input type="text" class="form-control" id="transaction_receipt_number"
                                    onkeyup="funCheck()">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 my-auto col-lg-4">
                                <label class="fw-bold">No Transaksi Group :</label>
                            </div>
                            <div class="col-6 col-lg-7">
                                <input type="text" class="form-control" id="transaction_receipt_number_group"
                                    onkeyup="funCheck()">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 my-auto col-lg-4">
                                <label class="fw-bold">Tanggal Transaksi :</label>
                            </div>
                            <div class="col-6 col-lg-4 col-xl-3">
                                <input type="date" class="form-control" id="transaction_date" onchange="funCheck()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <ul class="nav_ py-0 ps-0 ps-md-3 my-0">
                {{-- <li class="nav_item">
                    <a class="nav_link" href="javascript:void(0)" aria-current="page" data-filter="2">Belum dibayar</a>
                </li> --}}
                <li class="nav_item">
                    <a class="nav_link active" href="javascript:void(0)" data-filter="3">Menunggu Konfirmasi</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link" href="javascript:void(0)" data-filter="4">Diproses</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link" href="javascript:void(0)" data-filter="5">Dikirim</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link" href="javascript:void(0)" data-filter="6">Selesai</a>
                </li>
                <li class="nav_item">
                    <a class="nav_link" href="javascript:void(0)" data-filter="1">Dibatalkan</a>
                </li>
            </ul>
            <div class="" id="ResultHistory">
                @include('history::components.accordion')
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function handleNavLinkClick(event) {
            event.preventDefault();
            var navLinks = document.querySelectorAll('.nav_link');

            navLinks.forEach(function(link) {
                link.classList.remove('active');
            });

            event.target.classList.add('active');

            var dataFilterValue = event.target.getAttribute('data-filter');
            funCheck()
        }

        var navLinks = document.querySelectorAll('.nav_link');
        navLinks.forEach(function(link) {
            link.addEventListener('click', handleNavLinkClick);
        });

        function funCheck() {

            var activeNavLink = document.querySelector('.nav_link.active');
            var dataFilterValue = activeNavLink.getAttribute('data-filter');
            dataFilter = dataFilterValue;

            let outlet_name = $('#outlet_name').val();
            let transaction_receipt_number = $('#transaction_receipt_number').val();
            let transaction_receipt_number_group = $('#transaction_receipt_number_group').val();
            let transaction_date = $('#transaction_date').val();
            let filter = $('#filter').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/history/filter`,
                type: "POST",
                cache: false,
                data: {
                    "outlet_name": outlet_name,
                    'transaction_date': transaction_date,
                    'transaction_receipt_number': transaction_receipt_number,
                    'transaction_receipt_number_group': transaction_receipt_number_group,
                    'filter': dataFilter,
                    "_token": token
                },
                success: function(response) {
                    $('#ResultHistory').empty();
                    $('#ResultHistory').prepend(response);
                },
            });
        }
    </script>
@endpush
