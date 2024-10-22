<hr>
<div class="">
    @foreach ($data['billpayment']['data'] ?? [] as $key => $itemBillPayment)
        <div class="col-12">
            @php
                $timestamp = strtotime($itemBillPayment['transaction_group_date']);
                $formattedDate = date('d M Y', $timestamp);
            @endphp
            <h5 class="fw-bold mb-0 p-2" style="background: #E6F1FF !important">{{ $formattedDate ?? '' }}</h5>
            <div class="p-3">
                @if (isset($itemBillPayment['transaction_receipt_number']))
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0">
                                <strong>Transaksi :</strong>
                                {{ $itemBillPayment['transaction_receipt_number'] ?? '' }}
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <a class="mb-0 fw-bold text-decoration-none text-blue"
                                href="{{ url('/billpayment/order/detail/' . $itemBillPayment['transaction_receipt_number']) }}">DETAIL</a>
                        </div>
                    </div>
                @else
                    <p class="mb-0">
                        <strong>Transaksi :</strong>
                        {{ $itemBillPayment['transaction_payment_number'] ?? '' }}
                    </p>
                @endif
                <p class="mb-0 pt-0"><strong>Pada :</strong>
                    {{ $itemBillPayment['transaction_group_date'] }}
                </p>
                <p class="mb-2 pt-0"><strong>Total :</strong>
                    {{ $itemBillPayment['transaction_grandtotal_text'] }}
                </p>
                @if (isset($itemBillPayment['transaction_receipt_number']))
                @else
                    <div class="d-flex flex-row px-2">
                        <a href="{{ url('billpayment/detail/' . $itemBillPayment['transaction_payment_number'] ?? '') }}"
                            class="btn btn-primary">Detail</a>
                        <a href="{{ $itemBillPayment['url_file_rekap'] ?? '' }}"
                            class="btn btn-secondary ms-3">Download</a>
                    </div>
                @endif
                <div class="d-flex flex-row">
                    @if (isset($itemBillPayment['transaction_receipt_number']))
                        <div class="cart_items_check me-3 align-items-start">
                            <input class="form-check-input checkPlayBill" type="checkbox" id="checkBillpayment"
                                value="{{ $itemBillPayment['transaction_receipt_number'] ?? '' }}">
                        </div>
                    @endif
                    <div class="d-flex flex-column flex-fill overflow-hidden">
                        @foreach ($itemBillPayment['transactions'] ?? [] as $key => $itemTransaction)
                            <div class="row w-100 @if ($key != 0) mt-3 @endif">
                                @if ($key != 0)
                                    <hr>
                                @endif
                                <div class="d-flex flex-column  w-100 @if (isset($itemTransaction['transaction_receipt_number']))  @endif">
                                    <div class="d-flex flex-row align-items-center mb-2 w-100">
                                        <img src="{{ $itemTransaction['outlet_logo'] }}"
                                            style="width:32px; height:32px aspect-ratio:1/1; object-fit:cover "
                                            alt="">
                                        <p class="mb-0 ms-2">
                                            <strong> {{ $itemTransaction['outlet_name'] }}
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                                @foreach ($itemTransaction['product'] as $itemProduct)
                                    <div class="row d-flex flex-row w-100">
                                        <p class="mb-0 col-4">
                                            <strong>Menu
                                            </strong>
                                            {{ $itemProduct['product_name'] }}
                                        </p>
                                        <p class="mb-0 col-4 ms-auto">
                                            <strong>Qty
                                            </strong>
                                            {{ $itemProduct['transaction_product_qty'] }}
                                        </p>
                                        <p class="mb-0 col-4 ms-auto">
                                            <strong>Harga
                                            </strong>
                                            {{ str_replace('.00', '', $itemProduct['transaction_product_price']) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            @if (isset($itemBillPayment['transaction_payment_number']))
                                <a class="text-decoration-none text-blue"
                                    href="{{ url('billpayment/detail/' . $itemBillPayment['transaction_payment_number']) }}">Detail</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="p-3 text-center d-none" id="showAmountPay">
    <hr>
    <h5 class="mb-0 text-blue">Jumlah untuk Dibayar</h5>
    <h5 id="totalBillpayment"></h5>
    <button id="payNow" class="btn btn-primary mx-auto fs-5" style="width:240px;">Bayar Sekarang</button>
    <hr>
</div>

<div class="modal fade" id="modalPayNow" tabindex="-1" aria-labelledby="modalPayNowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-blue" id="modalPayNowLabel">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="resultPayment">
                </div>
                <div class="text-center mt-3">
                    <button type="button" id="paymentMethodButton" class="btn btn-primary">Metode Pembayaran</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentMethodModalLabel">Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    @foreach ($data['payment'] ?? [] as $key => $payment)
                        <div class="form_check mt-2">
                            <input class="form-check-input" style="width:22px; height:22px;" type="radio"
                                name="paymentMethod" id="paymentMethod" value="{{ $payment['payment_method'] }}"
                                @if ($key == 0) checked @endif>
                            <label class="fs-5 form-check-label">
                                {{ $payment['text'] }}
                            </label>
                        </div>
                    @endforeach
                    <div class="mt-3">
                        <button type="button" id="confirmationPaymentMethod"
                            class="btn btn-primary">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="pagination_ mt-5 mt-0 py-0 mb-3">
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item @if (!isset($data['billpayment']['prev_page_url'])) disabled @endif ">
                <button type="button" class="page-link" id="paginationBillpayment"
                    data-page="{{ $data['billpayment']['current_page'] - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>
            @if ($data['billpayment']['last_page'] >= 5)
                @if ($data['billpayment']['last_page'] - $data['billpayment']['current_page'] >= 3)
                    <li class="page-item  active">
                        <button type="button" class="page-link" id="paginationBillpayment"
                            data-page="{{ $data['billpayment']['current_page'] }}">{{ $data['billpayment']['current_page'] }}</button>
                    </li>
                @elseif ($data['billpayment']['last_page'] - $data['billpayment']['current_page'] <= 3)
                    <li class="page-item">
                        <button type="button" class="page-link" id="paginationBillpayment"
                            data-page="1">1</button>
                    </li>
                @endif
                @php
                    $lastPage = $data['billpayment']['last_page'];
                    $currentPage = $data['billpayment']['current_page'];
                    $maxPagesToShow = 3;
                    $startPage = $currentPage + 1;
                    if ($startPage + $maxPagesToShow > $lastPage) {
                        $startPage = max($lastPage - $maxPagesToShow + 1, 1);
                    }
                @endphp
                @for ($i = $startPage; $i <= min($startPage + $maxPagesToShow - 1, $lastPage); $i++)
                    <li class="page-item @if ($currentPage == $i) active @endif">
                        <button type="button" class="page-link" id="paginationBillpayment"
                            data-page="{{ $i }}">{{ $i }}</button>
                    </li>
                @endfor
            @else
                @for ($i = 1; $i <= $data['billpayment']['last_page']; $i++)
                    <li class="page-item @if ($data['billpayment']['current_page'] == $i) active @endif">
                        <button type="button" class="page-link" id="paginationBillpayment"
                            data-page="{{ $i }}">{{ $i }}</button>
                    </li>
                @endfor
            @endif
            <li class="page-item @if (!isset($data['billpayment']['next_page_url'])) disabled @endif">
                <button type="button" class="page-link" id="paginationBillpayment"
                    data-page="{{ $data['billpayment']['current_page'] + 1 }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </button>
            </li>
        </ul>
    </nav>
</div>
<style>
    #paymentMethod.form-check-input:checked {
        background-color: #013880;
        border-color: #013880;
    }
</style>
@push('scripts')
    <script>
        $('body').on('click', '.checkPlayBill', function() {

            var checkedValues = [];
            $('.checkPlayBill:checked').each(function() {
                checkedValues.push($(this).val());
            });

            let token = $("meta[name='csrf-token']").attr("content");
            var checkoutBtn = document.getElementById('checkout');

            var checkedCheckboxes = $('.checkPlayBill:checked').length;

            if (checkedCheckboxes >= 1) {
                let showAmountPay = document.getElementById("showAmountPay");
                $.ajax({
                    url: `/billpayment/check`,
                    type: "POST",
                    cache: false,
                    data: {
                        "transaction_receipt_number": checkedValues,
                        "_token": token
                    },
                    success: function(response) {
                        if (showAmountPay.classList.contains("d-none")) {
                            showAmountPay.classList.remove("d-none");
                            showAmountPay.classList.add("d-block");
                        } else {
                            showAmountPay.classList.add("d-block");
                        }
                        document.getElementById('totalbillpayment').innerText =
                            response.data;
                    },
                    error: function(error) {
                        if (showAmountPay.classList.contains("d-block")) {
                            showAmountPay.classList.remove("d-block");
                            showAmountPay.classList.add("d-none");
                        } else {
                            showAmountPay.classList.add("d-none");
                        }
                    }
                });
            } else {

            }


        })

        $('body').on('click', '#payNow', function() {
            $('#modalPayNow').modal('show');

            const checkboxes = document.querySelectorAll(
                "input[type='checkbox'][id^='checkBillpayment']:checked");
            const checkedValues = Array.from(checkboxes).map(checkbox => checkbox.value);


            let transaction_receipt_number = $(this).data('transaction');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/billpayment/check`,
                type: "POST",
                cache: false,
                data: {
                    "transaction_number": checkedValues,
                    "_token": token
                },
                success: function(response) {
                    $('.resultPayment').empty();
                    $('.resultPayment').prepend(response);
                },
            });
        });



        $('body').on('click', '#paymentMethodButton', function() {
            $('#modalPayNow').modal('hide');
            $('#paymentMethodModal').modal('show');
        });

        $('body').on('click', '#confirmationPaymentMethod', function() {
            const checkboxes = document.querySelectorAll(
                "input[type='checkbox'][id^='checkBillpayment']:checked");
            const checkedValues = Array.from(checkboxes).map(checkbox => checkbox.value);
            const paymentMethod = document.querySelector("input[name='paymentMethod']:checked");
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/billpayment/confirm`,
                type: "POST",
                cache: false,
                data: {
                    "transaction_number": checkedValues,
                    "payment_method": paymentMethod.value,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#paymentMethodModal').modal('hide');
                    // location.reload();
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
