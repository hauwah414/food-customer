@extends('layouts.dynamic')
@section('container')
    <section class="container cart py-3 py-lg-5">
        @include('sections.breadcrumb')
        <h2 class="mt-3">{{ $data['title'] ?? '' }}</h2>
        @if (isset($data['cart']))
            <div class="row">
                <div class="col-12 col-lg-8 col-xl-7">
                    <div class="d-flex justify-content-start d-none" id="textDeleteMultiple">
                        <input class="form-check my-auto" type="checkbox" id="checkedAll" checked>
                        <p class="mb-0 ms-3"><span id="countSelect"></span> Produk Terpilih</p>
                        <a href="javascript:void(0)" class="text-danger fs-4 text-decoration-none fw-bold ms-auto"
                            id="btndeleteMultiple">HAPUS</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-8 col-xl-7">
                    @foreach ($data['cart']['items'] ?? [] as $key => $itemCart)
                        @if ($key == 0)
                            <hr style="margin:0.5rem 0; border-top: 1px dotted;">
                        @endif
                        <h4 class="fw-bolder">
                            {{ $itemCart['outlet_name'] ?? '' }}
                        </h4>
                        @foreach ($itemCart['items'] as $key => $cartProduct)
                            @if ($cartProduct['product_type'] == 'box')
                                <div class="cart_items" id="cartItem_{{ $cartProduct['id_product'] }}">
                                    <div class="cart_items_check">
                                        <input class="form-check-input my-auto" type="checkbox"
                                            value="{{ $cartProduct['id_product'] }}" checked>
                                    </div>
                                    <div class="cart_items_product">
                                        <img style="object-fit: cover;" src="{{ $cartProduct['image'] }}" alt="">
                                    </div>
                                    <div class="cart_items_desc" style="width: 100%;">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-9">
                                                <a class="fs-5 fw-bold text-decoration-none text-blue"
                                                    href="{{ url('product/' . base64_encode($cartProduct['id_product'])) }}"
                                                    class="mb-0">{{ $cartProduct['product_name'] }}</a>
                                            </div>
                                            <div class="col-3 text-end p-0">
                                                <button id="btnRemove" data-id="{{ $cartProduct['id_product'] }}"
                                                    class="btn btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <h5 class="mb-1 fw-bold">
                                            Rp{{ number_format($cartProduct['product_price'], 0, ',', '.') ?? '' }}
                                        </h5>
                                        @if (isset($cartProduct['serving_method']))
                                            <p class="mb-0"><strong>Penyajian :
                                                </strong>{{ $cartProduct['serving_method']['serving_name'] ?? '' }},
                                                Rp
                                                {{ number_format($cartProduct['serving_method']['unit_price'], 0, ',', '.') }}/
                                                {{ $cartProduct['serving_method']['package'] ?? '' }}
                                            </p>
                                            <p>
                                                <strong>Item : </strong>
                                                @foreach ($cartProduct['products'] ?? [] as $key => $productsCart)
                                                    @if ($key != 0)
                                                        ,
                                                    @endif {{ $productsCart['product_name'] ?? '' }}
                                                @endforeach
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="cart_footer" id="cartFooter_{{ $cartProduct['id_product'] ?? '' }}">
                                    <div class="cart_footer_input">
                                        <button class="btn btn-sm btn-outline-primary btn_count"
                                            data-product="{{ $cartProduct['id_product'] }}" id="stepDown"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown() ;">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input min="{{ $cartProduct['min_transaction'] }}"
                                            data-min="{{ $cartProduct['min_transaction'] }}"
                                            name="quantity{{ $cartProduct['id_product'] ?? '' }}" id="jumlah"
                                            data-serving="{{ $cartProduct['id_product_serving_method'] ?? '' }}"
                                            data-product="{{ $cartProduct['id_product'] ?? '' }}"
                                            value="{{ $cartProduct['qty'] ?? '' }}"
                                            data-items="@foreach ($cartProduct['products'] ?? [] as $key => $itemsProducts)
                                            @if ($key == 0){{ $itemsProducts['id_product'] }}@else,{{ $itemsProducts['id_product'] }}
                                            @endif @endforeach"
                                            type="number"
                                            class="form-control form-quality fw-bold text-center form-control-sm mx-1 border-0">
                                        <button class="btn btn-sm btn-primary bg-blue btn_count" id="stepUp"
                                            data-product="{{ $cartProduct['id_product'] }}"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp();"
                                            style="">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            @else
                                <div class="cart_items" id="cartItem_{{ $cartProduct['id_product'] }}">
                                    <div class="cart_items_check">
                                        <input class="form-check-input my-auto" type="checkbox"
                                            value="{{ $cartProduct['id_product'] }}" checked>
                                    </div>
                                    <div class="cart_items_product">
                                        <img style="object-fit: cover;" src="{{ $cartProduct['image'] }}" alt="">
                                    </div>
                                    <div class="cart_items_desc"style="width: 100%;">
                                        <div class="row" style="width: 100%;">
                                            <div class="col-9">
                                                <a class="fs-5 fw-bold text-decoration-none text-blue"
                                                    href="{{ url('product/' . base64_encode($cartProduct['id_product'])) }}"
                                                    class="mb-0">{{ $cartProduct['product_name'] }}</a>
                                            </div>
                                            <div class="col-3 text-end pe-0">
                                                <button id="btnRemove" data-id="{{ $cartProduct['id_product'] }}"
                                                    class="btn btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <h5 class="mb-1 fw-bold">
                                            Rp{{ number_format($cartProduct['product_price'], 0, ',', '.') ?? '' }}</h5>
                                    </div>
                                </div>
                                <div class="cart_footer" id="cartFooter_{{ $cartProduct['id_product'] }}">
                                    <div class="cart_footer_input">
                                        <button class="btn btn-sm btn-outline-primary btn_count" id="stepDown"
                                            data-product="{{ $cartProduct['id_product'] }}"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown() ;">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input min="{{ $cartProduct['min_transaction'] }}"
                                            data-min="{{ $cartProduct['min_transaction'] }}"
                                            name="quantity{{ $cartProduct['id_product'] }}" id="jumlah"
                                            data-product="{{ $cartProduct['id_product'] }}"
                                            value="{{ $cartProduct['qty'] }}" type="number"
                                            class="form-control form-quality fw-bold text-center form-control-sm mx-1 border-0">
                                        <button class="btn btn-sm btn-primary bg-blue btn_count" id="stepUp"
                                            data-product="{{ $cartProduct['id_product'] }}"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp();"
                                            style="">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <div class="col-12 col-lg-4 mt-5 mt-lg-0 offset-xl-1">
                    <div class="card border-blue">
                        <div class="card-body">
                            <h2 class="text-blue mb-3">
                                Total Pemesanan
                            </h2>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <tbody id="resultTotal">
                                        @foreach ($data['cart']['items'] ?? [] as $itemOrder)
                                            <tr>
                                                <td class="fw-bold fs-5" colspan="2">
                                                    {{ $itemOrder['outlet_name'] }}
                                                </td>
                                            </tr>
                                            @foreach ($itemOrder['items'] ?? [] as $item)
                                                <tr>
                                                    <td class="fs-6" style="font-weight: 500;">
                                                        {{ $item['product_name'] . ', ' . $item['qty'] }}pcs </td>
                                                    <td class="fw-bolder text-end" id="result{{ $item['id_product'] }}">
                                                        {{ $item['product_price_subtotal_text'] ?? '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="fs-6 fw-bolder text-secondary">Total Harga</td>
                                            <td class="fw-bolder text-end" id="subtotal">
                                                @if (isset($data['cart']['subtotal']))
                                                    Rp{{ number_format($data['cart']['subtotal'], 0, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button id="checkout" class="btn btn-primary bg-blue" style="width:100%">
                                Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-3" role="alert">
                Keranjang anda kosong, silahkan pesan dahulu
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        var buttons = document.getElementsByClassName("btn_count");

        for (var i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener("click", _.debounce(function(event) {
                var product = this.parentNode.querySelector('input[type=number]').getAttribute("data-product");
                var id_product_serving_method = this.parentNode.querySelector('input[type=number]')
                    .getAttribute(
                        "data-serving");
                var items = this.parentNode.querySelector('input[type=number]').getAttribute("data-items");
                var qty = this.parentNode.querySelector('input[type=number]').value;
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: `/cart/create`,
                    type: "POST",
                    cache: false,
                    data: {
                        "qty": qty,
                        "id_product": product,
                        "items": items,
                        "id_product_serving_method": id_product_serving_method,
                        "_token": token
                    },
                    success: function(response) {
                        $('#resultTotal').empty();
                        $('#resultTotal').prepend(response);
                    },
                    error: function(error) {}
                });
            }, 3000));
        }

        $('body').on('change', '#jumlah', function() {
            var product = $(this).data('product');
            var id_product_serving_method = $(this).data('serving');
            var items = $(this).data('items');
            var qty = $(this).val();
            var minTransaction = $(this).data('min');
            let token = $("meta[name='csrf-token']").attr("content");
            var checkout = document.getElementById("checkout");

            if (qty < minTransaction) {
                var qty = $(this).val(minTransaction);
                Swal.fire({
                    icon: 'error',
                    title: `Minimal Pemesanan ` + minTransaction + ``,
                    showConfirmButton: false,
                    timer: 3000
                });
                $.ajax({
                    url: `/cart/create`,
                    type: "POST",
                    cache: false,
                    data: {
                        "qty": minTransaction,
                        "id_product": product,
                        "items": items,
                        "id_product_serving_method": id_product_serving_method,
                        "_token": token
                    },
                    success: function(response) {
                        $('#resultTotal').empty();
                        $('#resultTotal').prepend(response);
                    },
                    error: function(error) {}
                });
            } else {
                $.ajax({
                    url: `/cart/create`,
                    type: "POST",
                    cache: false,
                    data: {
                        "qty": qty,
                        "id_product": product,
                        "items": items,
                        "id_product_serving_method": id_product_serving_method,
                        "_token": token
                    },
                    success: function(response) {
                        $('#resultTotal').empty();
                        $('#resultTotal').prepend(response);
                    },
                    error: function(error) {}
                });
            }
        });


        $('body').on('click', '.form-check-input', function() {

            var selectedItems = [];
            $('.form-check-input:checked').each(function() {
                selectedItems.push($(this).val());
            });

            let token = $("meta[name='csrf-token']").attr("content");
            var checkoutBtn = document.getElementById('checkout');

            var checkedCheckboxes = $('.form-check-input:checked').length;

            if (checkedCheckboxes > 1) {
                $('#textDeleteMultiple').removeClass('d-none');
                $('#countSelect').text(checkedCheckboxes);
                $('#btndeleteMultiple').removeClass('d-none');
            } else {
                $('#countSelect').text(checkedCheckboxes);
                $('#btndeleteMultiple').addClass('d-none');
            }

            var sumFormCheckInput = $('.form-check-input').length;

            if (checkedCheckboxes == sumFormCheckInput) {
                $('#checkedAll').prop('checked', true);

            } else {
                $('#checkedAll').prop('checked', false);

            }

            $.ajax({
                url: `/cart/checkbox`,
                type: "POST",
                cache: false,
                data: {
                    items: selectedItems,
                    "_token": token
                },
                success: function(response) {
                    checkoutBtn.disabled = false;
                    $('#resultTotal').empty();
                    $('#resultTotal').prepend(response);

                    $('.form-check-input').each(function() {
                        var value = $(this).val();
                        var isChecked = $(this).is(':checked');

                        if (isChecked) {
                            $('#stepDown[data-product="' + value + '"]').prop('disabled',
                                false);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', false);
                            $('#jumlah[data-product="' + value + '"]').prop('readonly', false);
                        } else {
                            $('#jumlah[data-product="' + value + '"]').prop('readonly', true);
                            $('#stepDown[data-product="' + value + '"]').prop('disabled', true);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', true);
                        }
                    });
                },
                error: function(error) {
                    $('#resultTotal').empty();
                    checkoutBtn.disabled = true;

                    $('.form-check-input').each(function() {
                        var value = $(this).val();
                        var isChecked = $(this).is(':checked');
                        if (isChecked) {
                            $('#stepDown[data-product="' + value + '"]').prop('disabled',
                                false);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', false);
                        } else {
                            $('#stepDown[data-product="' + value + '"]').prop('disabled', true);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', true);
                        }
                    });
                }
            });
        })

        $(document).ready(function() {
            var checkedCheckboxes = $('.form-check-input:checked').length;

            if (checkedCheckboxes > 1) {
                $('#textDeleteMultiple').removeClass('d-none');
                $('#countSelect').text(checkedCheckboxes);
            } else {
                $('#textDeleteMultiple').addClass('d-none');
            }
        });

        $('body').on('click', '#btndeleteMultiple', function() {

            var selectedItems = [];
            $('.form-check-input:checked').each(function() {
                selectedItems.push($(this).val());
            });

            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: `/cart/destroy/multiple`,
                        type: "POST",
                        cache: false,
                        data: {
                            items: selectedItems,
                            "_token": token
                        },
                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                        }
                    });
                }
            })
        })

        $('body').on('click', '#btnRemove', function() {

            let id_product = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: `/cart/destroy`,
                        type: "POST",
                        cache: false,
                        data: {
                            "id_product": id_product,
                            "_token": token
                        },
                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                        }
                    });
                }
            })
        });

        $('body').on('click', '#checkout', function() {
            window.location.href = "/checkout";
        });

        $('#checkedAll').on('change', function() {
            var isChecked = $(this).prop('checked');

            if (isChecked) {
                $('.form-check-input').prop('checked', true);
            } else {
                $('.form-check-input').prop('checked', false);
            }

            var selectedItems = [];
            $('.form-check-input:checked').each(function() {
                selectedItems.push($(this).val());
            });

            let token = $("meta[name='csrf-token']").attr("content");
            var checkoutBtn = document.getElementById('checkout');

            var checkedCheckboxes = $('.form-check-input:checked').length;

            if (checkedCheckboxes > 1) {
                $('#textDeleteMultiple').removeClass('d-none');
                $('#countSelect').text(checkedCheckboxes);
                $('#btndeleteMultiple').removeClass('d-none');
            } else {
                $('#countSelect').text(checkedCheckboxes);
                $('#btndeleteMultiple').addClass('d-none');
            }

            var sumFormCheckInput = $('.form-check-input').length;

            if (checkedCheckboxes == sumFormCheckInput) {
                $('#checkedAll').prop('checked', true);

            } else {
                $('#checkedAll').prop('checked', false);

            }

            $.ajax({
                url: `/cart/checkbox`,
                type: "POST",
                cache: false,
                data: {
                    items: selectedItems,
                    "_token": token
                },
                success: function(response) {
                    checkoutBtn.disabled = false;
                    $('#resultTotal').empty();
                    $('#resultTotal').prepend(response);

                    $('.form-check-input').each(function() {
                        var value = $(this).val();
                        var isChecked = $(this).is(':checked');

                        if (isChecked) {
                            $('#stepDown[data-product="' + value + '"]').prop('disabled',
                                false);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', false);
                            $('#jumlah[data-product="' + value + '"]').prop('readonly', false);
                        } else {
                            $('#jumlah[data-product="' + value + '"]').prop('readonly', true);
                            $('#stepDown[data-product="' + value + '"]').prop('disabled', true);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', true);
                        }
                    });
                },
                error: function(error) {
                    $('#resultTotal').empty();
                    checkoutBtn.disabled = true;

                    $('.form-check-input').each(function() {
                        var value = $(this).val();
                        var isChecked = $(this).is(':checked');
                        if (isChecked) {
                            $('#stepDown[data-product="' + value + '"]').prop('disabled',
                                false);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', false);
                        } else {
                            $('#stepDown[data-product="' + value + '"]').prop('disabled', true);
                            $('#stepUp[data-product="' + value + '"]').prop('disabled', true);
                        }
                    });
                }
            });
        });
    </script>
@endpush
