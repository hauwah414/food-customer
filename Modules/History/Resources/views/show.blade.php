@extends('layouts.dynamic')
@section('container')
    <section class="container  py-3 py-lg-5">
        @include('sections.breadcrumb')
        <div class="row px-2 px-md-0">
            <div class="card p-0" style="border-radius: 10px;">
                <div class="card-body p-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
                        <h5 class="mb-0 @if ($data['history']['transaction_status_code'] == 2) text-danger @endif">
                            <strong class="fw-bold">Status Transaksi : </strong>
                            {{ $data['history']['transaction_status_text'] ?? '' }}
                        </h5>
                    </div>
                    <hr style="border-top: 2px dotted;">
                    <div class="mt-3 mb-3 row">
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-md-row">
                                <img class="mx-auto mx-md-0 mb-3 mb-md-0"
                                    src="{{ $data['history']['outlet']['url_outlet_image_logo_portrait'] }}"
                                    style=""width="90px" height="90px" alt="">
                                <div class="d-flex flex-column ms-md-2">
                                    <h5 class="mb-0"><strong>Outlet : </strong>
                                        {{ $data['history']['outlet']['outlet_name'] ?? '' }}
                                    </h5>
                                    <p class="mb-0">
                                        Hubungi lewat <a class="fw-bold text-decoration-none"
                                            href="{{ $data['history']['call'] ?? '' }}">Whatapp</a>
                                    </p>
                                    <p class="mb-0"><strong>Alamat :
                                        </strong>{{ $data['history']['outlet']['outlet_full_address'] ?? '' }}</p>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="accordion" id="deliveryTracking">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="deliveryTrackingAccor">
                                <button class="accordion-button collapsed fs-5 fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Informasi Pengiriman
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="deliveryTrackingAccor" data-bs-parent="#deliveryTracking">
                                <div class="accordion-body">
                                    @foreach ($data['history']['delivery']['delivery_tracking'] ?? [] as $deliveryTracking)
                                        @if ($deliveryTracking['attachment'] != null)
                                            <img style="object-fit:contain" width="120px" height="120px"
                                                src="{{ $deliveryTracking['attachment'] }}" alt="">
                                        @endif
                                        <h5 class="mb-0">{{ $deliveryTracking['date'] }}</h5>
                                        <p>{{ $deliveryTracking['description'] }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 2px dotted;">
                    @foreach ($data['history']['transaction_products'] ?? [] as $key => $transaction_products)
                        <div class="col-12 mt-3">
                            <div class="cart_items" style="width:100%;">
                                <div class="cart_items_product ms-0">
                                    <img style="object-fit: cover;" src="{{ $transaction_products['image'] ?? '' }}"alt="">
                                </div>
                                <div class="cart_items_desc">
                                    <h5 class="fw-bold mb-0 mt-0">{{ $transaction_products['product_name'] ?? '' }}
                                    </h5>
                                    <p class="mb-0"><strong>Jumlah :</strong>
                                        {{ $transaction_products['product_qty'] ?? '' }}</p>
                                    <p class="mb-0">
                                        {{ $transaction_products['product_total_price'] ?? '' }}</p>
                                    @if (isset($transaction_product['note']))
                                        <p class="mb-0">Catatan Pesanan :
                                            {{ $transaction_product['note'] ?? '' }}</p>
                                    @endif
                                </div>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                @foreach ($data['history']['transaction_products'] ?? [] as $itemPrice)
                                    <tr>
                                        <td class="fs-6 fw-bolder text-secondary">{{ $itemPrice['product_name'] }},
                                            {{ $itemPrice['product_qty'] }} pcs</td>
                                        <td class="fw-bolder text-end">{{ $itemPrice['product_total_price'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($data['history']['payment_detail'] ?? [] as $payment_detail)
                                    <tr>
                                        <td class="fs-6 fw-bolder text-secondary">{{ $payment_detail['text'] }}</td>
                                        <td class="fw-bolder text-end">{{ $payment_detail['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer border-0 py-2 bg-blue"
                        style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <tbody>
                                    <tr>
                                        <td class="fs-4 text-light fw-bold bg-transparent">
                                            Total</td>
                                        <td class="fs-4 text-light  fw-bold text-end bg-transparent">
                                            {{ $data['history']['transaction_grandtotal'] ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-5 d-flex flex-column">
                @if ($data['history']['transaction_status_code'] == 2)
                    <button id="typePayment" class="btn btn-primary mx-auto fs-5 text-center"
                        style="width:200px;">BAYAR</button>
                    <button id="cancelTransaction" class="btn btn-outline-danger mx-auto fs-5 mt-3"
                        style="width:170px;">BATAL</button>
                @endif
                @if ($data['history']['transaction_status_code'] == 5)
                    <button id="receivedTransaction" class="btn btn-primary mx-auto fs-5"
                        data-transaction="{{ $data['history']['transaction_receipt_number'] }}"
                        style="width:240px;">Selesaikan Transaksi</button>
                @endif
                @if ($data['history']['transaction_status_code'] == 6)
                    <a href="{{ url('rating/' . $data['history']['transaction_receipt_number']) }}"
                        class="btn btn-primary mx-auto fs-5" style="width:240px;">Berikan Rating</a>
                @endif
            </div>
        </div>

        @if ($data['history']['transaction_status_code'] == 2)
            @include('history::components.payment')
        @endif

    </section>

    <!-- Modal -->
    <div class="modal fade" id="cancelModalTransaction" tabindex="-1" aria-labelledby="modalLogoutLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="icon_logout text-danger">
                        <i class="fa-solid fa-question"></i>
                    </div>
                    <h5>Apakah anda ingin membatalkan transaksi ini ?</h5>
                    <div class="text-center d-flex flex-column align-items-center mt-3">
                        <button type="button" id="cencelTransactionTrue"
                            data-transaction="{{ $data['history']['receipt_number_group'] ?? '' }}"
                            class="btn btn-danger rounded-pill fw-bold mt-2 " style="width:180px;"
                            data-bs-dismiss="modal">YA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('body').on('click', '#cancelTransaction', function() {
            $('#cancelModalTransaction').modal('show');
        });
        $('body').on('click', '#cencelTransactionTrue', function() {
            let transaction = $(this).data('transaction');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/transaction/cancel`,
                type: "POST",
                cache: false,
                data: {
                    "transaction": transaction,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    window.location.href = "/history";
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: `${error.responseJSON.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
        $('body').on('click', '#receivedTransaction', function() {
            let transaction_receipt_number = $(this).data('transaction');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/transaction/received`,
                type: "POST",
                cache: false,
                data: {
                    "transaction_receipt_number": transaction_receipt_number,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    location.reload()
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: `Maaf transaksi gagal diselesaikan`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
    </script>
@endpush
