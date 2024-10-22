<hr>
<div class="">
    @foreach ($data['paylater']['data'] ?? [] as $key => $itemPaylater)
        <div class="col-12">
            @php
                $timestamp = strtotime($itemPaylater['transaction_group_date']);
                $formattedDate = date('d M Y', $timestamp);
            @endphp
            <h5 class="fw-bold mb-0 p-2" style="background: #E6F1FF !important">{{ $formattedDate ?? '' }}</h5>
            @if (isset($itemPaylater['transaction_receipt_number']))
                <p class="mb-0 p-2 pb-0">
                    <strong>Transaksi :</strong>
                    {{ $itemPaylater['transaction_receipt_number'] ?? '' }}
                </p>
            @else
                <p class="mb-0 p-2 pb-0">
                    <strong>Transaksi :</strong>
                    {{ $itemPaylater['transaction_payment_number'] ?? '' }}
                </p>
            @endif
            <p class="mb-0 p-2 pb-0 pt-0"><strong>Pada :</strong>
                {{ $itemPaylater['transaction_group_date'] }}
            </p>
            <p class="mb-2 p-2 pb-0 pt-0"><strong>Total :</strong>
                {{ $itemPaylater['transaction_grandtotal_text'] }}
            </p>
            <div class="d-flex flex-row p-3 pt-0">
                @if (isset($itemPaylater['transaction_receipt_number']))
                    <div class="cart_items_check">
                        <input class="form-check-input my-auto" type="checkbox" id="checkPaylater"
                            value="{{ $itemPaylater['transaction_receipt_number'] ?? '' }}">
                    </div>
                @endif
                @foreach ($itemPaylater['transactions'] ?? [] as $itemTransaction)
                    <div class="row w-100">
                        <div class="d-flex flex-column  w-100 @if (isset($itemTransaction['transaction_receipt_number'])) ms-3 @endif">
                            <div class="d-flex flex-row align-items-center mb-2 w-100">
                                <img src="{{ $itemTransaction['outlet_logo'] }}"
                                    style="width:32px; height:32px aspect-ratio:1/1; object-fit:cover " alt="">
                                <p class="mb-0 ms-2">
                                    <strong> {{ $itemTransaction['outlet_name'] }}
                                    </strong>
                                </p>
                            </div>
                            @foreach ($itemTransaction['product'] as $itemProduct)
                                <div class="row w-100 ps-2">
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
                            @if (isset($itemPaylater['transaction_payment_number']))
                                <a class="text-decoration-none text-blue"
                                    href="{{ url('paylater/detail/' . $itemPaylater['transaction_payment_number']) }}">Detail</a>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<div class="p-3 text-center d-none" id="showAmountPay">
    <hr>
    <h5 class="mb-0 text-blue">Jumlah untuk Dibayar</h5>
    <h5 id="totalPaylater"></h5>
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
                            <input class="form-check-input form_check_input" type="radio" name="paymentMethod"
                                id="paymentMethod" value="{{ $payment['payment_method'] }}"
                                @if ($key == 0) checked @endif>
                            <label class="fs-5">
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
            <li class="page-item @if (!isset($data['paylater']['prev_page_url'])) disabled @endif ">
                <button type="button" class="page-link" id="paginationPaylater"
                    data-page="{{ $data['paylater']['current_page'] - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>
            @if ($data['paylater']['last_page'] >= 5) 
                @if ($data['paylater']['last_page'] - $data['paylater']['current_page'] >= 3)
                    <li class="page-item  active">
                        <button type="button" class="page-link" id="paginationPaylater"
                            data-page="{{ $data['paylater']['current_page'] }}">{{ $data['paylater']['current_page'] }}</button>
                    </li>
                @elseif ($data['paylater']['last_page'] - $data['paylater']['current_page'] <= 3)
                    <li class="page-item">
                        <button type="button" class="page-link" id="paginationPaylater" data-page="1">1</button>
                    </li>
                @endif
                @php
                    $lastPage = $data['paylater']['last_page'];
                    $currentPage = $data['paylater']['current_page'];
                    $maxPagesToShow = 3;
                    $startPage = $currentPage + 1;
                    if ($startPage + $maxPagesToShow > $lastPage) {
                        $startPage = max($lastPage - $maxPagesToShow + 1, 1);
                    }
                @endphp
                @for ($i = $startPage; $i <= min($startPage + $maxPagesToShow - 1, $lastPage); $i++)
                    <li class="page-item @if ($currentPage == $i) active @endif">
                        <button type="button" class="page-link" id="paginationPaylater"
                            data-page="{{ $i }}">{{ $i }}</button>
                    </li>
                @endfor
            @else
                @for ($i = 1; $i <= $data['paylater']['last_page']; $i++)
                    <li class="page-item @if ($data['paylater']['current_page'] == $i) active @endif">
                        <button type="button" class="page-link" id="paginationPaylater"
                            data-page="{{ $i }}">{{ $i }}</button>
                    </li>
                @endfor
            @endif
            <li class="page-item @if (!isset($data['paylater']['next_page_url'])) disabled @endif">
                <button type="button" class="page-link" id="paginationPaylater"
                    data-page="{{ $data['paylater']['current_page'] + 1 }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </button>
            </li>
        </ul>
    </nav>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll("input[type='checkbox'][id='checkPaylater']");

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    const checkedCheckboxes = document.querySelectorAll(
                        "input[type='checkbox'][id='checkPaylater']:checked");
                    const checkedValues = Array.from(checkedCheckboxes).map(checkbox => checkbox
                        .value);
                    let showAmountPay = document.getElementById("showAmountPay");

                    if (checkedValues.length > 0) {
                        let token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: `/paylater/check`,
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
                                document.getElementById('totalPaylater').innerText =
                                    response.data;
                            },
                        });
                    } else {
                        if (showAmountPay.classList.contains("d-block")) {
                            showAmountPay.classList.remove("d-block");
                            showAmountPay.classList.add("d-none");
                        } else {
                            showAmountPay.classList.add("d-none");
                        }
                    }
                });
            });
        });

        $('body').on('click', '#payNow', function() {
            $('#modalPayNow').modal('show');

            const checkboxes = document.querySelectorAll(
                "input[type='checkbox'][id^='checkPaylater']:checked");
            const checkedValues = Array.from(checkboxes).map(checkbox => checkbox.value);


            let transaction_receipt_number = $(this).data('transaction');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/paylater/check`,
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
                "input[type='checkbox'][id^='checkPaylater']:checked");
            const checkedValues = Array.from(checkboxes).map(checkbox => checkbox.value);
            const paymentMethod = document.querySelector("input[name='paymentMethod']:checked");
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/paylater/confirm`,
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
                    location.reload();
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
