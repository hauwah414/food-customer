<section class="detail_menu mt-3">
    <div class="row">
        <div class="col-12 col-lg-4 col-xl-3 d-flex flex-column">
            <img class="detail_menu_product_image mb-lg-3" src="{{ $data['image'] ?? '' }}" alt="">
            <div class="detail_menu_product_image_main d-none d-lg-flex mt-auto">
                <img src="{{ asset('https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80') ?? '' }}"
                    alt="">
                <div class="d-flex flex-column ms-3">
                    <h4 class="mb-0">{{ $data['seller'] ?? '' }}</h4>
                    <p class="mb-0">
                        Lama Penyajian {{ $data['serving'] ?? '' }}
                    </p>
                    <div class="d-flex">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-6 mt-3 mt-lg-0">
            <div class="detail_menu_product">
                <div class="d-flex flex-row justify-content-between">
                    <h2 class="mb-0 fw-bolder">{{ $data['title'] ?? '' }}</h2>
                    <button class="btn btn-link">
                        <h2 class="mb-0 fa-regular fa-heart">
                            </>
                    </button>
                </div>
                <h5 class="text-secondary mb-2 mb-lg-3"><strong>Terjual</strong> 50</h5>
                <h2 class="fw-bolder">{{ $data['price'] ?? '' }}</h2>
                <hr>
                <h5 class="fw-bolder">Detail Menu</h5>
                <hr>
                <p class="text-lg-start text-secondary fw-normal mb-0" style="text-align: justify;">
                    {{ $data['detail'] ?? '' }}
                </p>
            </div>
        </div>
        <div class="col-12 col-xl-3 mt-3 mt-lg-5 mt-xl-0">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-blue mb-3">Pesan Menu</h2>
                    <div class="d-flex flex-row justify-content-between">
                        <h5>Jumlah Pesanan</h4>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-primary btn_count"
                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input min="0" name="quantity" id="jumlah" value="1" readonly
                                type="number" class="form-control form-quality text-center fw-bold form-control-sm mx-1 border-0">
                            <button class="btn btn-primary bg-blue btn_count"
                                onclick="this.parentNode.querySelector('input[type=number]').stepUp()" style="">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-link mt-3 text-secondary">
                        Tambah Catatan
                    </button> 
                    <h6 class="mt-2 text-secondary">Diskon</h6>
                    <div class="d-flex flex-row justify-content-between mt-2">
                        <h6 class="text-secondary fw-bolder">Total Harga</h5>
                        <h6 class="text-secondary fw-bolder ms-auto">Rp. 36.000</h5>
                    </div>
                    <a href="/" class="btn btn-primary bg-blue mt-3" style="width:100%;">Tambah Pesanan</a>
                    <a href="/" class="btn btn-outline-primary mt-2 text-blue"style="width:100%;">Pesan Langsung</a>
                </div>  
            </div>
        </div>
    </div>
</section>
