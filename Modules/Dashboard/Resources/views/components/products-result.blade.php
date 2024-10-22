<div class="swiper swiperDasboard swiperProduct">
    <div class="swiper-wrapper">
        @foreach ($data['nearest']['data'] ?? [] as $itemNearest)
            <div class="swiper-slide">
                <div class="card shadow">
                    <img src="{{ $itemNearest['image'] ?? '' }}" alt="{{ $itemNearest['product_name'] ?? '' }}"
                        alt="{{ $itemNearest['product_name'] }}">
                    <div class="card-body">
                        <div class="desc_">
                            <h5>{{ substr($itemNearest['product_name'], 0, 80) ?? '' }}</h5>
                            <h5 class="">
                                Rp{{ number_format($itemNearest['product_price'], 0, ',', '.') ?? '' }}
                            </h5>
                        </div>
                        <hr>
                        <div class="d-flex flex-row mt-2 mb-3">
                            <span class="badge bg-light text-dark me-3">{{ $itemNearest['text_preorder'] }}</span>
                            <span class="badge bg-light text-dark">{{ $itemNearest['text_min_order'] }}</span>
                        </div>
                        <a href="{{ url('/product/' . base64_encode($itemNearest['id_product'])) }}" class="btn btn-warning">
                            Lihat</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-button-next">
        <i class="fa-solid fa-chevron-right"></i>
    </div>
    <div class="swiper-button-prev">
        <i class="fa-solid fa-chevron-left"></i>
    </div>
</div>

<script>
    swipeProduct();
</script>
