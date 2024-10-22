@extends('layouts.dynamic')
@section('container')
    <section class="container py-3 py-lg-5">
        @include('sections.breadcrumb')
        @if ($data['checkout']['available_checkout'] == false)
            <div class="alert alert-danger" role="alert">
                {{ $data['checkout']['error_messages'] }}
            </div>
        @endif
        <div class="row px-2 px-md-0">
            <div class="card p-0" style="border-radius: 10px;">
                <div class="card-body p-md-4">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="row">
                                <div class="col-6 my-auto col-lg-4">
                                    <label class="fw-bold">Tujuan Pembelian :
                                    </label>
                                </div>
                                <div class="col-6 col-lg-7">
                                    <input type="text" class="form-control" id="purchase_purpose">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="row">
                                <div class="col-6 my-auto col-lg-4">
                                    <label for="inputPassword" class="fw-bold">Sumber Dana :
                                    </label>
                                </div>
                                <div class="col-6 col-lg-7">
                                    <select class="form-select" id="sumber_dana">
                                        @foreach ($data['dana'] ?? [] as $itemDana)
                                            <option value="{{ $itemDana }}">{{ $itemDana }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($data['checkout']['items'] ?? [] as $items)
                        <h3 class="text-blue fw-bold">Outlet : {{ $items['outlet_name'] ?? '' }}</h3>
                        <hr style="border-top: 1px dotted;">
                        <div class="row mb-2">
                            <div class="col-4 col-md-6 my-auto">
                                <h5 class="mb-0">Tanggal : </h5>
                            </div>
                            <div class="col-8 col-md-6 d-flex justify-content-end">
                                <input type="date" class="form-control" style="width: 200px;" min="{{ date('Y-m-d') }}"
                                    id="dateOutlet" data-outlet='{{ $items['id_outlet'] ?? '' }}'>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 col-md-6 my-auto">
                                <h5 class="mb-0">Jam : </h5>
                            </div>
                            <div class="col-8 col-md-6 d-flex flex-column align-items-end">
                                <input type="time" class="form-control" style="width: 200px;" id="timeOutlet"
                                    min="{{ $items['open'] ?? '' }}" max="{{ $items['close'] ?? '' }}"
                                    data-name="{{ $items['outlet_name'] ?? '' }}"data-outlet='{{ $items['id_outlet'] ?? '' }}'>
                                <small>Jam Buka : {{ $items['open'] ?? '' }} - {{ $items['close'] ?? '' }} </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 my-auto">
                                <h5 class="mb-0">Alamat : </h5>
                            </div>
                            <div class="col-6 text-end my-auto">
                                <button class="btn btn-outline-primary" id="selectAddress"
                                    data-outlet="{{ $items['id_outlet'] ?? '' }}">
                                    Alamat Lain
                                </button>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0 col-md-6">
                            <p class="mb-0" id="textReceiver" data-outlet='{{ $items['id_outlet'] ?? '' }}'>
                                <strong>Penerima : </strong>{{ $items['address']['receiver_name'] ?? '' }}
                            </p>
                            <p class="mb-0" id="textAddress" data-outlet='{{ $items['id_outlet'] ?? '' }}'>
                                <strong>Alamat : {{ $items['address']['address'] ?? '' }} </strong>
                            </p>
                            <input type="text" id="address" hidden readonly
                                data-outlet='{{ $items['id_outlet'] ?? '' }}'
                                value="{{ $items['address']['id_user_address'] ?? '' }}">
                        </div>
                        @foreach ($items['items'] ?? [] as $key => $itemProduct)
                            @if ($itemProduct['product_type'] == 'box')
                                <div class="col-12 mt-3">
                                    <div class="cart_items" style="width:100%;">
                                        <div class="cart_items_product ms-0">
                                            <img style="object-fit: cover;" src="{{ $itemProduct['image'] }}"
                                                alt="">
                                        </div>
                                        <div class="cart_items_desc">
                                            <h5 class="fw-bold mb-0 mt-0">{{ $itemProduct['product_name'] ?? '' }}
                                            </h5>
                                            <p class="mb-0"><strong>Jumlah :</strong>
                                                {{ $itemProduct['qty'] ?? '' }}</p>
                                            <p class="mb-0">
                                                {{ $itemProduct['product_price_text'] ?? '' }}</p>
                                            <p class="mb-0"><strong>Items :</strong>
                                                @foreach ($itemProduct['products'] as $key => $products)
                                                    @if ($key != 0)
                                                        ,
                                                    @endif {{ $products['product_name'] ?? '' }}
                                                @endforeach
                                            </p>
                                            <p class="fs-6 mb-0">Penyajian :
                                                {{ $itemProduct['serving_method']['serving_name'] ?? '' }},
                                                {{ $itemProduct['serving_method']['unit_price'] ?? '' }}/
                                                {{ $itemProduct['serving_method']['package'] ?? '' }}</p>
                                            <div class="col-12 col-md-6">
                                                <button
                                                    class="btn btn-link text-blue p-0 fs-6 text-decoration-none fw-bold note-button">Tambah
                                                    Catatan</button>
                                                <textarea class="form-control mt-2  d-none note-textarea" id="note"
                                                    data-product="{{ $itemProduct['id_product'] ?? '' }}" data-outlet="{{ $items['id_outlet'] ?? '' }}"
                                                    rows="1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @else
                                <div class="col-12 mt-3">
                                    <div class="cart_items" style="width:100%;">
                                        <div class="cart_items_product ms-0">
                                            <img style="object-fit: cover;" src="{{ $itemProduct['image'] }}"
                                                alt="">
                                        </div>
                                        <div class="cart_items_desc">
                                            <h5 class="fw-bold mb-0 mt-0">{{ $itemProduct['product_name'] ?? '' }}
                                            </h5>
                                            <p class="mb-0"><strong>Jumlah :</strong>
                                                {{ $itemProduct['qty'] ?? '' }}</p>
                                            <p class="mb-0">Harga satuan : {{ $itemProduct['product_price_text'] ?? '' }}
                                            </p>
                                            <p class="mb-0">Total :
                                                {{ $itemProduct['product_price_subtotal_text'] ?? '' }}</p>
                                            <div class="col-12 col-md-6">
                                                <button
                                                    class="btn btn-link text-blue p-0 fs-6 text-decoration-none fw-bold note-button">Tambah
                                                    Catatan</button>
                                                <textarea class="form-control mt-2 d-none note-textarea" id="note"
                                                    data-product="{{ $itemProduct['id_product'] ?? '' }}" data-outlet="{{ $items['id_outlet'] ?? '' }}"
                                                    rows="1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                    <div class="" id="ResultTotal">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <tbody>
                                    @foreach ($data['checkout']['items'] ?? [] as $itemsvalue)
                                        <tr>
                                            <td class="fs-6 fw-bolder text-primary">
                                                Outlet : {{ $itemsvalue['outlet_name'] ?? '' }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        @foreach ($itemsvalue['items'] ?? [] as $productValue)
                                            @if ($productValue['product_type'] == 'box')
                                                @foreach ($productValue['products'] as $productValueBox)
                                                    <td class="fs-6 text-secondary">
                                                        {{ $productValueBox['product_name'] ?? '' }},
                                                        {{ $productValue['qty'] ?? '' }} pcs</td>
                                                    <td class="fw-bolder text-end">
                                                        Rp
                                                        {{ number_format($productValueBox['product_global_price'], 0, ',', '.') ?? '' }}
                                                    </td>
                                                    </tr>
                                                    @if ($productValue['product_discount'] != 0)
                                                        <tr>
                                                            <td class="fs-6 fw-bolder text-secondary">
                                                                Diskon</td>
                                                            <td class="fw-bolder text-end">
                                                                {{ $productValue['product_discount'] ?? '' }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                <tr style="border-top: 1px solid #6e767e69;">
                                                    <td class="fs-6 text-secondary">
                                                        Total
                                                    <td class="fw-bolder text-end">
                                                        {{ $productValue['product_price_subtotal_text'] ?? '' }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="fs-6 text-secondary">
                                                        {{ $productValue['product_name'] ?? '' }},
                                                        {{ $productValue['qty'] ?? '' }} pcs </td>
                                                    <td class="fw-bolder text-end">
                                                        {{ $productValue['product_price_text'] ?? '' }}</td>
                                                </tr>
                                                <tr style="border-top: 1px solid #6e767e69;">
                                                    <td class="fs-6 text-secondary">
                                                        Total
                                                    <td class="fw-bolder text-end">
                                                        {{ $productValue['product_price_subtotal_text'] ?? '' }}</td>
                                                </tr>
                                                @if ($productValue['product_discount'] != 0)
                                                    <tr>
                                                        <td class="fs-6 fw-bolder text-secondary">
                                                            Diskon</td>
                                                        <td class="fw-bolder text-end">
                                                            {{ $productValue['product_discount'] ?? '' }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <tr></tr>
                                    <tr></tr>
                                    @foreach ($data['checkout']['summary_order'] ?? [] as $summary_order)
                                        <tr>
                                            <td class="fs-6 fw-bolder text-secondary">{{ $summary_order['name'] }}</td>
                                            <td class="fw-bolder text-end">{{ $summary_order['value'] }}</td>
                                        </tr>
                                        @if ($summary_order['is_discount'] != 0)
                                            <tr>
                                                <td class="fs-6 fw-bolder text-secondary">Diskon</td>
                                                <td class="fw-bolder text-end">{{ $summary_order['is_discount'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer border-0 py-2 bg-blue">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <tbody>
                                        <tr>
                                            <td class="fs-4 text-light fw-bold  bg-transparent">
                                                Grand Total</td>
                                            <td class="fs-4 text-light  fw-bold text-end bg-transparent">
                                                {{ $data['checkout']['grandtotal_text'] ?? '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="py-5 d-flex flex-column" id="cardButtonPay"
                        style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <button id="order" @if ($data['checkout']['available_checkout'] != true) disabled @endif
                            class="btn btn-primary mx-auto fs-5" style="width:280px;">Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalAddress" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 my-auto">
                            <h4 class="text-blue mb-0">Pilih Alamat</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ url('address/create') }}" class="btn ms-3 btn-outline-primary">
                                Tambah Alamat
                            </a>
                        </div>
                    </div>
                    <hr>
                    @foreach ($data['address'] ?? [] as $key => $address)
                        <div class="form_check mt-2">
                            <input class="form-check-input form_check_input" type="radio" name="addressRadio"
                                id="addressRadio" value="{{ $address['id_user_address'] }}"
                                data-address="{{ $address['address'] }}" data-receiver="{{ $address['receiver_name'] }}"
                                @if ($address['main_address'] == 1) checked @endif>
                            <label>
                                <p class="mb-0">Penerima : {{ $address['receiver_name'] }}</p>
                                <p class="mb-0">Alamat
                                    {{ $address['address'] }}
                                </p>
                            </label>
                        </div>
                    @endforeach
                    <div class="mt-3 text-center">
                        <button id="confirmationAddress" class="btn btn-primary mx-auto fs-5"
                            style="width:200px;">Pilih</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const timeInputs = document.querySelectorAll("input[type='time']");

            timeInputs.forEach(function(timeInput) {
                timeInput.addEventListener("change", function() {
                    const selectedTime = timeInput.value;
                    const minTime = timeInput.getAttribute("min");
                    const maxTime = timeInput.getAttribute("max");
                    let name = $(this).data('name');

                    if (selectedTime < minTime || selectedTime > maxTime) {
                        Swal.fire({
                            icon: 'error',
                            title: `Outlet ` + name + ` Buka jam ` + minTime + `-` +
                                maxTime + ``,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            });
        });


        var noteButtons = document.getElementsByClassName('note-button');
        for (var i = 0; i < noteButtons.length; i++) {
            noteButtons[i].addEventListener('click', function() {
                var parentDiv = this.parentNode;
                var textarea = parentDiv.querySelector('.note-textarea');

                if (textarea.classList.contains('d-block')) {
                    textarea.classList.remove('d-block');
                    textarea.classList.add('d-none');
                    textarea.value = "";
                    this.innerHTML = 'Tambah Catatan';
                } else {
                    textarea.classList.remove('d-none');
                    textarea.classList.add('d-block');
                    this.innerHTML = 'Hapus Catatan';
                }
            });
        }


        $('body').on('click', '#selectAddress', function() {
            var outlet = $(this).data('outlet');
            $('#modalAddress').modal('show');

            $('body').on('click', '#confirmationAddress', function() {
                var addressRadio = $('input[name="addressRadio"]:checked');
                var receiver = addressRadio.data('receiver');
                var address = addressRadio.data('address');
                let token = $("meta[name='csrf-token']").attr("content");

                var addressInput = $('[id="address"][data-outlet="' + outlet + '"]');
                var textAddress = $('#textAddress[data-outlet="' + outlet + '"]');
                var textReceiver = $('#textReceiver[data-outlet="' + outlet + '"]');

                addressInput.val(addressRadio.val());
                textAddress.html('<strong>Alamat : ' + address + '</strong>');
                textReceiver.html('<strong>Alamat : ' + receiver + '</strong>');

                $('#modalAddress').modal('hide');

                funCheckPrice();
                outlet = null;
            });
        });



        function funCheckPrice() {
            let token = $("meta[name='csrf-token']").attr("content");
            var transactionDate = {};
            $('input[id="dateOutlet"]').each(function() {
                var outlet = $(this).data('outlet');
                var transactionDateValue = $(this).val();
                transactionDate[outlet] = transactionDateValue;
            });
            var transactionTime = {};
            $('input[id="timeOutlet"]').each(function() {
                var outlet = $(this).data('outlet');
                var transactionTimeValue = $(this).val();
                transactionTime[outlet] = transactionTimeValue;
            });

            var addressData = {};
            $('input[id="address"]').each(function() {
                var outlet = $(this).data('outlet');
                var addressValue = $(this).val();
                addressData[outlet] = addressValue;
            });

            $.ajax({
                url: `/checkout/address/change`,
                type: "POST",
                cache: true,
                data: {
                    'address': addressData,
                    'date': transactionDate,
                    'time': transactionTime,
                    "_token": token
                },
                success: function(response) {
                    $('#ResultTotal').empty();
                    $('#ResultTotal').prepend(response);

                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: `Maaf gagal silahkan ulangi lagi`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        }

        $('body').on('click', '#order', function() {
            let token = $("meta[name='csrf-token']").attr("content");
            let sumber_dana = $('#sumber_dana').val();
            let purchase_purpose = $('#purchase_purpose').val();

            var dateOutlet = {};

            $('input[id="dateOutlet"]').each(function() {
                var outlet = $(this).data('outlet');
                var dateOutletValue = $(this).val();
                dateOutlet[outlet] = dateOutletValue;
            });

            var timeOutlet = {};

            $('input[id="timeOutlet"]').each(function() {
                var outlet = $(this).data('outlet');
                var timeOutletValue = $(this).val();
                timeOutlet[outlet] = timeOutletValue;
            });

            const transactionDate = {};

            for (const key in dateOutlet) {
                if (timeOutlet.hasOwnProperty(key)) {
                    transactionDate[key] = `${dateOutlet[key]} ${timeOutlet[key]}`;
                }
            }

            var addressData = {};
            $('input[id="address"]').each(function() {
                var outlet = $(this).data('outlet');
                var addressValue = $(this).val();
                addressData[outlet] = addressValue;
            });

            var noteData = {};
            $('textarea[id^="note"]').each(function() {
                var outlet = $(this).data('outlet');
                var product = $(this).data('product');
                var noteValue = $(this).val();

                if (!noteData[outlet]) {
                    noteData[outlet] = {};
                }

                if (!noteData[outlet][product]) {
                    noteData[outlet][product] = [];
                }

                noteData[outlet][product].push(noteValue);
            });
            $.ajax({
                url: `/checkout/payment/new`,
                type: "POST",
                cache: true,
                data: {
                    'sumber_dana': sumber_dana,
                    'purchase_purpose': purchase_purpose,
                    'address': addressData,
                    'date': transactionDate,
                    'note': noteData,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // window.location.href = "/transaction/" + response.data; 
                    window.location.href = "/billpayment/order/detail/" + response.data;
                },
                error: function(error) {
                    $('#modalPayment').modal('hide');
                    if (error.responseJSON.message != null) {
                        Swal.fire({
                            icon: 'error',
                            title: `${error.responseJSON.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: `Tujuan pembelian belum diisi`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });
        });
    </script>
@endpush
