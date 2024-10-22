@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.2/swiper-bundle.min.css"
        integrity="sha512-+i36IwpzfYLmCNRFtEnpEAie8PEyhO5GuK7W2Y0eDMVwT1pesCB86xuQlc5v1lfb69N/6hejJEW3EWeVkExTlQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
<section class="pt-5">
    <div class="container">
        <div class="swiper swiperBanner">
            <div class="swiper-wrapper">
                @foreach ($data['banner'] ?? [] as $key => $itemBanner)
                    <div class="swiper-slide">
                        <img src="{{ $itemBanner['image_url'] ?? '' }}" alt="{{ $itemBanner['image_url'] ?? '' }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.2/swiper-bundle.min.js"
        integrity="sha512-dPYTaB+Ip4gAl9vo6U0jSmI8v1AZKjPKH367mfo7pR5gLf1IKpjm3bIXIwm+MmYWEf0eiBEWSBqE+MdKUx0jfg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var swiper = new Swiper(".swiperBanner", {
            slidesPerView: "auto",
            loop: true,
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
            },
        });
    </script>
@endpush
