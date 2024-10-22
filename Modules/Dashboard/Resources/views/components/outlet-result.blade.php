<div class="swiper swiperDasboard swiperVendor">
    <div class="swiper-wrapper">
        @foreach ($data['otlet']['data'] ?? [] as $itemOutlet)
            <div class="swiper-slide">
                <div class="card shadow">
                    <img src="{{ $itemOutlet['outlet_image_logo_portrait'] ?? '' }}"
                        alt="{{ $itemOutlet['outlet_name'] ?? '' }}" alt="{{ $itemOutlet['outlet_name'] }}">
                    <div class="card-body">
                        <div class="desc_">
                            <h5 class="text-center">
                                {{ $itemOutlet['outlet_name'] ?? '' }}

                            </h5>
                        </div>
                        <a href="{{ url('/outlet/' . $itemOutlet['outlet_code']) }}" class="btn btn-warning">
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
    swapeVendor();
</script>
