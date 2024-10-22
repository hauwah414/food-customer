<footer class="mt-auto pb-5 pb-md-0">
    <div class="container">
        <div class="row">
            <div class="mb-3 mb-md-0 col-12 col-md-4">
                <div class="items text-center text-md-start">
                    <h4>Link</h4>
                    <a href="{{ url('/') }}">Dashboard</a>
                    <a href="{{ url('/product') }}">Product</a> 
                    <a href="{{ url('/outlet') }}">Vendor</a> 
                </div>
            </div>
            <div class="mb-3 mb-md-0 col-12 col-md-4">
                <div class="items text-center text-start">
                    <h4>Bantuan</h4>
                    <a href="{{ url('/faq') }}">FAQ</a>
                    <a href="{{ url('/contact') }}">Hubungi Kami</a>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <img class="mx-auto d-flex" src="{{ asset('images/footer-logo.png') }}" alt="">
            </div>
        </div>
    </div>
</footer>
