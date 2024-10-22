<section class="pt-5 pt-md-5 pb-2">
    <div class="container">
        <h3 class="mb-2">Best Menu</h3>

        <div class="swiper swiperDasboard swiperBest">
            <div class="swiper-wrapper">
                @foreach ($data['best'] ?? [] as $key => $itemBest)
                    <div class="swiper-slide">
                        <div class="card shadow">
                            <img src="{{ $itemBest['image'] ?? '' }}" alt="{{ $itemBest['product_name'] ?? '' }}"
                                alt="{{ $itemBest['product_name'] }}">
                            <div class="card-body">
                                <div class="desc_">
                                    <h5>{{ substr($itemBest['product_name'], 0, 80) ?? '' }}</h5>
                                    <h5 class="">
                                        Rp{{ number_format($itemBest['product_price'], 0, ',', '.') ?? '' }}
                                    </h5>
                                </div>
                                <hr>
                                <div class="d-flex flex-row mt-2 mb-3">
                                    <span class="badge bg-light text-dark me-3">{{ $itemBest['text_preorder'] }}</span>
                                    <span class="badge bg-light text-dark">{{ $itemBest['text_min_order'] }}</span>
                                </div>
                                <a href="{{ url('/product/' . base64_encode($itemBest['id_product'])) }}" class="btn btn-warning">
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


        <div class="mt-3 text-center">
            <a href="{{ url('/product') }}" class="btn btn-warning px-5">
                <strong>
                    Tampilkan Lainnya
                </strong>
            </a>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        var swiper = new Swiper(".swiperBest", {
            slidesPerView: 1,
            spaceBetween: 30, 
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                575: {
                    slidesPerView: "auto",
                }
            },
        });
    </script>
@endpush
