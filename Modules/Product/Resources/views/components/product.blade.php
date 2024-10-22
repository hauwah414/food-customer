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
                        <div class="carousel_items @if (count($data['product']['multiple_photo']) <= 2) ms-2 @endif"
                            data-id="{{ $key + 2 }}">
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
            <div class="detail_menu_product_image_main mt-auto">
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
                <h4 class="fw-bolder">Rp {{ number_format($data['product']['product_price'], 0, ',', '.') ?? '' }}</h4>
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
                <hr style="margin: 0.5rem 0 ; border-top: 1px dotted;">
                <h5 class="fw-bolder">Detail Menu</h5>
                <hr style="margin:0.5rem 0;">
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
                                onclick="var input = document.getElementById('purchaseAmount'); var minValue = parseInt(input.min); var value = parseInt(input.value); if (value > minValue) { input.value = value - 1; }">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input min="{{ $data['product']['min_transaction'] }}" name="quantity"
                                id="purchaseAmount" value="{{ $data['product']['qty'] }}"
                                max="{{ $data['product']['stock_item'] }}" type="number"
                                class="form-control form-quality text-center fw-bold form-control-sm mx-1 border-0">
                            <button class="btn btn-primary bg-blue btn_count"
                                onclick="document.getElementById('purchaseAmount').value = parseInt(document.getElementById('purchaseAmount').value) + 1;"
                                style="">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    @if ($data['product']['product_label_discount'] != 0)
                        <div class="d-flex flex-row justify-content-between mt-2">
                            <h6 class="text-secondary fw-bolder">Diskon</h6>
                            <h6 class="text-secondary fw-bolder ms-auto">Rp
                                {{ number_format($data['product']['product_label_discount'], 0, ',', '.') ?? '' }}</h6>
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
                        <button id="orderNow" class="btn btn-outline-primary mt-2 text-blue"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif style="width:100%;">Pesan
                            Langsung</button>
                    @else
                        <a href="{{ url('login') }}" class="btn btn-primary bg-blue mt-3"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif style="width:100%;">Tambah Pesanan</a>
                        <a href="{{ url('login') }}" class="btn btn-outline-primary mt-2 text-blue"
                            @if ($data['product']['can_buy_own_product'] != true) disabled @endif
                            @if ($data['product']['outlet_is_closed'] != false) disabled @endif style="width:100%;">Pesan
                            Langsung</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', funCheck);
        funCheck()

        $('body').on('click', '.btn_count', _.debounce(function() {
            funCheck()
        }, 3000));


        $('body').on('change', '#purchaseAmount', function() {
            funCheck()
        });

        function funCheck() {
            let id_product = {{ $data['product']['id_product'] }};
            let outlet = {{ $data['product']['id_outlet'] }};
            let quality = $('#purchaseAmount').val();
            let minTransaction = {{ $data['product']['min_transaction'] }};
            let token = $("meta[name='csrf-token']").attr("content");

            if (quality >= minTransaction) {
                $.ajax({
                    url: `/transaction/check`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_product": id_product,
                        'quality': quality,
                        'outlet': outlet,
                        "_token": token
                    },
                    success: function(response) {
                        document.getElementById('totalPrice').innerText = response.data.subtotal_text;
                        var addOrder = document.getElementById("addOrder");
                        var orderNow = document.getElementById("orderNow");

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
                let quality = $('#purchaseAmount').val(minTransaction);
                Swal.fire({
                    icon: 'error',
                    title: `Minimal Pemesanan ` + minTransaction + ``,
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }

        $('body').on('click', '#orderNow', function() {
            let id_product = {{ $data['product']['id_product'] }};
            let outlet = {{ $data['product']['id_outlet'] }};
            let quality = $('#purchaseAmount').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let minTransaction = {{ $data['product']['min_transaction'] }};

            if (quality >= minTransaction) {
                $.ajax({
                    url: `/checkout/now/order`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_product": id_product,
                        'quality': quality,
                        'outlet': outlet,
                        "_token": token
                    },
                    success: function(response) {
                        window.location.href = "/checkout/now";
                    },
                });
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
            let id_product = {{ $data['product']['id_product'] }};
            let outlet = {{ $data['product']['id_outlet'] }};
            let quality = $('#purchaseAmount').val();
            let token = $("meta[name='csrf-token']").attr("content");
            let minTransaction = {{ $data['product']['min_transaction'] }};

            if (quality >= minTransaction) {
                $.ajax({
                    url: `/cart/addOrder`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_product": id_product,
                        'quality': quality,
                        "_token": token
                    },
                    success: function(response) {
                        window.location.href = "/cart";
                    },
                });
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
