<section class="pt-5 pt-md-5 pb-5">
    <div class="container">
        <h3 class="mb-2">Vendor Terdekat</h3>
        <div id="outletResult"></div>
        <div class="mt-3 text-center">
            <a href="{{ url('/outlet') }}" class="btn btn-warning px-5">
                <strong>
                    Tampilkan Lainnya
                </strong>
            </a>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function swapeVendor() {
            var swiper = new Swiper(".swiperVendor", {
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

        function getOutletNearest() {
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
                    url: `/dashboard/outlet/nearest`,
                    type: "POST",
                    cache: false,
                    data: {
                        "longitude": longitude,
                        "latitude": latitude,
                        "_token": token
                    },
                    success: function(response) {
                        $("#outletResult").html(response)
                    },
                });
            }

            function error() {
                $.ajax({
                    url: `/dashboard/outlet/nearest`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    success: function(response) {
                        $("#outletResult").html(response)
                    },
                });
            }
        }

        getOutletNearest();
    </script>
@endpush
