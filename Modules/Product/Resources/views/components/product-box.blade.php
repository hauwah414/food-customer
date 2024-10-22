<section class="detail_menu mt-3">
    <div class="row">
        <div class="col-12 col-lg-4 col-xl-4 d-flex flex-column">
            @if (isset($data['product']['multiple_photo'][0]) && $data['product']['multiple_photo'][0] != null)
                <div class="image_show" data-bs-toggle="modal" data-bs-target="#imageModal">
                    <img src="{{ $data['product']['image'] ?? '' }}" alt="{{ $data['product']['image'] ?? '' }}"
                        class="mb-3 image_square rounded-3">
                </div>
                <div class="carousel_ @if (count($data['product']['multiple_photo']) <= 2) justify-content-start @endif">
                    <div class="carousel_items active" data-id="1">
                        <img src="{{ $data['product']['image'] ?? '' }}" alt="">
                    </div>
                    @foreach ($data['product']['multiple_photo'] as $key => $MultiplePhoto)
                        <div class="carousel_items" data-id="{{ $key + 2 }}">
                            <img src="{{ $MultiplePhoto['url_photo_image'] ?? '' }}" alt="">
                        </div>
                    @endforeach
                </div>
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="background: transparent; border:0;">
                            <div class="modal-body">
                                <div class="carousel_modal">
                                    <div class="carousel_items_ active" data-id="1">
                                        <img src="{{ $data['product']['image'] ?? '' }}" alt="">
                                    </div>
                                    @foreach ($data['product']['multiple_photo'] as $key => $MultiplePhotoModal)
                                        <div class="carousel_items_" data-id="{{ $key + 2 }}">
                                            <img src="{{ $MultiplePhotoModal['url_photo_image'] ?? '' }}"
                                                alt="">
                                        </div>
                                    @endforeach
                                    <button class="btn btn_prev">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </button>
                                    <button class="btn btn_next">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <img src="{{ $data['product']['image'] ?? '' }}" alt="{{ $data['product']['image'] ?? '' }}"
                    class="mb-3 image_square rounded-3" data-bs-toggle="modal" data-bs-target="#imageModal">
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="background: transparent; border:0;">
                            <div class="modal-body">
                                <div class="carousel_modal">
                                    <div class="carousel_items_ active" data-id="1">
                                        <img src="{{ $data['product']['image'] ?? '' }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="detail_menu_product_image_main mt-2">
                <img class="image_square" src="{{ $data['product']['image'] ?? '' }}"
                    alt="{{ $data['product']['image'] ?? '' }}">
                <div class="d-flex flex-column ms-3">
                    <h4 class="mb-0">{{ $data['product']['outlet_name'] ?? '' }}</h4>
                    <div class="d-flex">
                        @for ($i = 0; $i < $data['product']['total_rating']; $i++)
                            <i class="fa-solid fa-star" style="color:gold;"></i>
                        @endfor
                        @for ($i = 0; $i < 5 - $data['product']['total_rating']; $i++)
                            <i class="fa-solid fa-star text-dark"></i>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-5 mt-3 mt-lg-0">
            <div class="detail_menu_product">
                <div class="d-flex flex-row justify-content-between">
                    <h2 class="mb-0 fw-bolder text-blue">{{ $data['product']['product_name'] ?? '' }}</h2>
                    @if (session('access_token'))
                        @if ($data['product']['favorite'] == true)
                            <button id="deleteFavorite" class="btn btn-link text-danger"
                                data-favorite="{{ $data['product']['id_product'] }}">
                                <h2 class="mb-0 fa-solid fa-heart">
                                </h2>
                            </button>
                        @else
                            <button id="addFavorite" class="btn btn-link"
                                data-favorite="{{ $data['product']['id_product'] }}">
                                <h2 class="mb-0 fa-regular fa-heart">
                                </h2>
                            </button>
                        @endif
                    @else
                        <button class="btn btn-link">
                            <h2 class="mb-0 fa-regular fa-heart">
                            </h2>
                        </button>
                    @endif
                </div>
                <h6 class="text-secondary">Terjual :
                    @if ($data['product']['sold'] != '')
                        {{ preg_replace('/[^0-9]/', '', $data['product']['sold']) }}
                    @else
                        0
                    @endif
                </h6>
                @if ($data['product']['outlet_is_closed'] == false)
                    <div class="alert alert-primary border-0 rounded-0 p-2 fw-bold fs-5" style="width: 64px"
                        role="alert">
                        Buka
                    </div>
                @else
                    <div class="alert alert-danger border-0 rounded-0 p-2 fw-bold fs-5" style="width: 72px"
                        role="alert">
                        Tutup
                    </div>
                @endif
                <hr style="margin:0.5rem 0; border-top:1px dotted;">
                <h5 class="fw-bolder">Detail Menu</h5>
                <hr style="margin:0.rem 0;">
                <p class="text-lg-start text-secondary fw-normal mb-0" style="text-align: justify;">
                    {{ $data['product']['product_description'] ?? '' }}
                </p>
            </div>
        </div>
        <div class="col-12 col-xl-3 mt-3 mt-lg-5 mt-xl-0">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-blue mb-3">Pesan Menu</h2>
                    <div class="d-flex flex-row justify-content-between">
                        <h5>Jumlah Pesanan</h5>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary btn_count"
                                onclick="var input = document.getElementById('quality'); var minValue = parseInt(input.min); var value = parseInt(input.value); if (value > minValue) { input.value = value - 1; }">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input min="{{ $data['product']['min_transaction'] }}" name="quantity" id="quality"
                                value="{{ $data['product']['qty'] }}" max="{{ $data['product']['stock_item'] }}"
                                type="number"
                                class="form-control form-quality text-center fw-bold form-control-sm mx-1 border-0">
                            <button class="btn btn-primary bg-blue btn_count"
                                onclick="document.getElementById('quality').value = parseInt(document.getElementById('quality').value) + 1;"
                                style="">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <h5 class="text-blue mt-3">Menu</h5>
                    @foreach ($data['product']['product_custom'] as $key => $product_custom)
                        <div class="row mt-3">
                            <div class="col-6 col-md-8 d-flex flex-column">
                                <label>{{ $product_custom['product_name'] ?? '' }}</label>
                                <label>Rp{{ number_format($product_custom['product_price'], 0, ',', '.') ?? '' }}</label>
                            </div>
                            <div class="col-6 col-md-4 text-end my-auto">
                                <input class="form-check-input" type="checkbox"
                                    data-id="{{ $product_custom['id_product'] ?? '' }}" name="product_custom"
                                    @if ($product_custom['select'] == true) checked @endif
                                    value="{{ $product_custom['id_product'] ?? '' }}" onclick="sumMethod()"
                                    id="product_custom{{ $key }}">
                            </div>
                        </div>
                    @endforeach
                    <h5 class="text-blue mt-3">Cara Penyajian</h5>
                    @foreach ($data['product']['serving_method'] as $key => $servingMethod)
                        <div class="row mt-3">
                            <div class="col-6 col-md-8 d-flex flex-column">
                                <label>{{ $servingMethod['serving_name'] ?? '' }}</label>
                                <label>Rp{{ number_format($servingMethod['unit_price'], 0, ',', '.') ?? '' }} /
                                    {{ $servingMethod['package'] }}</label>
                            </div>
                            <div class="col-6 col-md-4 text-end my-auto">
                                <input class="form-check-input" type="radio" name="serving_method"
                                    onclick="sumMethod()" @if ($servingMethod['select'] == true) checked @endif
                                    value="{{ $servingMethod['id_product_serving_method'] ?? '' }}"
                                    id="serving_method{{ $key }}">
                            </div>
                        </div>
                    @endforeach
                    @if ($data['product']['product_label_discount'] != 0)
                        <div class="d-flex flex-row justify-content-between mt-2">
                            <h6 class="text-secondary fw-bolder">Diskon</h6>
                            <h6 class="text-secondary fw-bolder ms-auto">Rp
                                {{ number_format($data['product']['product_label_discount'], 0, ',', '.') ?? '' }}
                            </h6>
                        </div>
                    @endif
                    <div class="d-flex flex-row justify-content-between mt-2">
                        <h6 class="text-secondary fw-bolder">Total Harga</h6>
                        <h6 class="text-secondary fw-bolder ms-auto" id="totalPrice"></h6>
                    </div>
                    @if (session('access_token'))
                        <button id="addOrder" class="btn btn-primary bg-blue mt-3"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif style="width:100%;">Tambah
                            Pesanan</button>
                        <button id="orderNow" class="btn btn-outline-primary mt-2 text-blue"style="width:100%;"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif>Pesan
                            Langsung</button>
                    @else
                        <a herf="{{ url('login') }}" class="btn btn-primary bg-blue mt-3"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif style="width:100%;">Tambah Pesanan</a>
                        <a herf="{{ url('login') }}"
                            class="btn btn-outline-primary mt-2 text-blue"style="width:100%;"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif>Pesan
                            Langsung</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        sumMethod()


        $('body').on('click', '.btn_count', _.debounce(function() {
            sumMethod()
        }, 3000));

        $('body').on('change', '#quality', function() {
            sumMethod()
        });

        function sumMethod() {
            var servingMethodRadios = document.getElementsByName("serving_method");
            var selectedServingMethod = null;
            var productCustomCheckboxes = document.getElementsByName("product_custom");
            var selectedProducts = [];

            let minTransaction = {{ $data['product']['min_transaction'] }};

            let id_product = {{ $data['product']['id_product'] }};
            let outlet = {{ $data['product']['id_outlet'] }};
            let quality = $('#quality').val();
            let token = $("meta[name='csrf-token']").attr("content");

            for (var i = 0; i < servingMethodRadios.length; i++) {
                if (servingMethodRadios[i].checked) {
                    selectedServingMethod = servingMethodRadios[i].value;
                    break;
                }
            }

            for (var i = 0; i < productCustomCheckboxes.length; i++) {
                if (productCustomCheckboxes[i].checked) {
                    selectedProducts.push(productCustomCheckboxes[i].value);
                }
            }

            if (quality >= minTransaction) {
                if (selectedServingMethod && selectedProducts.length > 0) {
                    $.ajax({
                        url: `/transaction/check`,
                        type: "POST",
                        cache: false,
                        data: {
                            "id_product": id_product,
                            "quality": quality,
                            "outlet": outlet,
                            "custom": 1,
                            "id_product_serving_method": selectedServingMethod,
                            "item_product": selectedProducts.join(", "),
                            "_token": token
                        },
                        success: function(response) {
                            document.getElementById('totalPrice').innerText = response.data.subtotal_text;
                            if (quality == 0) {
                                addOrder.disabled = true;
                                orderNow.disabled = true;
                            } else {
                                addOrder.disabled = false;
                                orderNow.disabled = false;
                            }
                        },
                    });
                } else {
                    addOrder.disabled = true;
                    orderNow.disabled = true;
                }
            } else {
                document.getElementById('totalPrice').innerText = '';
                let quality = $('#quality').val(minTransaction);
                Swal.fire({
                    icon: 'error',
                    title: `Minimal Pemesanan ` + minTransaction + ``,
                    showConfirmButton: false,
                    timer: 3000
                });
                sumMethod();
            }

        };

        $('body').on('click', '#orderNow', function() {
            var servingMethodRadios = document.getElementsByName("serving_method");
            var selectedServingMethod = null;
            var productCustomCheckboxes = document.getElementsByName("product_custom");
            var selectedProducts = [];

            let id_product = {{ $data['product']['id_product'] }};
            let outlet = {{ $data['product']['id_outlet'] }};
            let quality = $('#quality').val();
            let token = $("meta[name='csrf-token']").attr("content");
            let max = {{ $data['product']['stock_item'] }};

            for (var i = 0; i < servingMethodRadios.length; i++) {
                if (servingMethodRadios[i].checked) {
                    selectedServingMethod = servingMethodRadios[i].value;
                    break;
                }
            }

            for (var i = 0; i < productCustomCheckboxes.length; i++) {
                if (productCustomCheckboxes[i].checked) {
                    selectedProducts.push(productCustomCheckboxes[i].value);
                }
            }

            let minTransaction = {{ $data['product']['min_transaction'] }};

            if (quality >= minTransaction) {
                if (selectedServingMethod && selectedProducts.length > 0) {
                    $.ajax({
                        url: `/checkout/now/order`,
                        type: "POST",
                        cache: false,
                        data: {
                            "id_product": id_product,
                            "quality": quality,
                            "outlet": outlet,
                            "custom": 1,
                            "id_product_serving_method": selectedServingMethod,
                            "item_product": selectedProducts.join(", "),
                            "_token": token
                        },
                        success: function(response) {
                            window.location.href = "/checkout/now";
                        },
                    });
                } else {
                    addOrder.disabled = true;
                    orderNow.disabled = true;
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: `Minimal Pemesanan ` + minTransaction + ``,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });

        $('body').on('click', '#addOrder', function() {
            var servingMethodRadios = document.getElementsByName("serving_method");
            var selectedServingMethod = null;
            var productCustomCheckboxes = document.getElementsByName("product_custom");
            var selectedProducts = [];

            let id_product = {{ $data['product']['id_product'] }};
            let outlet = {{ $data['product']['id_outlet'] }};
            let quality = $('#quality').val();
            let token = $("meta[name='csrf-token']").attr("content");
            let max = {{ $data['product']['stock_item'] }};

            for (var i = 0; i < servingMethodRadios.length; i++) {
                if (servingMethodRadios[i].checked) {
                    selectedServingMethod = servingMethodRadios[i].value;
                    break;
                }
            }

            for (var i = 0; i < productCustomCheckboxes.length; i++) {
                if (productCustomCheckboxes[i].checked) {
                    selectedProducts.push(productCustomCheckboxes[i].value);
                }
            }
            let minTransaction = {{ $data['product']['min_transaction'] }};

            if (quality >= minTransaction) {
                if (selectedServingMethod && selectedProducts.length > 0) {
                    $.ajax({
                        url: `/cart/addOrder`,
                        type: "POST",
                        cache: false,
                        data: {
                            "id_product": id_product,
                            "quality": quality,
                            "outlet": outlet,
                            "custom": 1,
                            "id_product_serving_method": selectedServingMethod,
                            "item_product": selectedProducts.join(", "),
                            "_token": token
                        },
                        success: function(response) {
                            window.location.href = "/cart";
                        },
                    });
                } else {
                    addOrder.disabled = true;
                    orderNow.disabled = true;
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: `Minimal Pemesanan ` + minTransaction + ``,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });


        $('body').on('click', '#addFavorite', function() {
            let product_id = $(this).data('favorite');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/favorite/create`,
                type: "POST",
                cache: false,
                data: {
                    "product_id": product_id,
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
                },
            });
        });


        $('body').on('click', '#deleteFavorite', function() {
            let product_id = $(this).data('favorite');
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini dari list favorite!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/favorite/delete`,
                        type: "POST",
                        cache: false,
                        data: {
                            "product_id": product_id,
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
    </script>
@endpush
