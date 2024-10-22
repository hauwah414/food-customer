<section class="main_menu py-3">
    <div class="container-md">
        <div class="heading">
            <h2>Menu Terbaru</h2>
            <a href="{{ url('/product') }}">Semua Menu</a>
        </div>
        <div class="row">
            @foreach ($data['newest'] ?? [] as $itemNewst)
                <div class="col-6 col-md-3 col-xl-3 mt-3">
                    <div class="card card_product">
                        <a href="{{ url('/product/' . $itemNewst['id_product']) }}" class="card_product_body">
                            <div class="image">
                                <img class="image_square" src="{{ $itemNewst['image'] ?? '' }}"
                                    alt="{{ $itemNewst['product_name'] ?? '' }}">
                            </div>
                            <div class="card_product_body_desc">
                                <h5>{{ cutTitle($itemNewst['product_name']) ?? '' }}</h5>
                                <p>
                                    Rp{{ number_format($itemNewst['product_price'], 0, ',', '.') ?? '' }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
