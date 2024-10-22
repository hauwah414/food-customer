{{-- <section class="pt-5 pb-2">
    <div class="container">
        <h3 class="mb-0">Product Terdekat</h3>
        <div class="row" id="productsResult"></div>
    </div>
</section> --}}

<section class="pt-5 pt-md-5 pb-2">
    <div class="container">
        <h3 class="mb-2">Product Terdekat</h3>

        <div id="productsResult"></div>


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
        function swipeProduct() {
            var swiper = new Swiper(".swiperProduct", {
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
        }

        function getNearest() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(success, error);
            } else {
                alert('Browser Anda tidak mendukung geolocation');
            }
            let token = $("meta[name='csrf-token']").attr("content");

            function success(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                $.ajax({
                    url: `/dashboard/products/nearest`,
                    type: "POST",
                    cache: false,
                    data: {
                        "longitude": longitude,
                        "latitude": latitude,
                        "_token": token
                    },
                    success: function(response) {
                        $("#productsResult").html(response)
                    },
                });
            }

            function error() {
                $.ajax({
                    url: `/dashboard/products/nearest`,
                    type: "POST",
                    cache: false,
                    data: { 
                        "_token": token
                    },
                    success: function(response) {
                        $("#productsResult").html(response)
                    },
                });
            }
        }
        getNearest();
    </script>
@endpush
