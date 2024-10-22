<header class="navbar navbar-expand-lg navbar_two">
    <div class="container"> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('product') }}">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('outlet') }}">Seller</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">How to Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">ITSFOOD Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Review</a>
                </li>
            </ul>
        </div>
    </div>
</header>
@if (request()->is('/'))
@else
    <div class="nav_login">
        <div class="container">
            <img src="{{ asset('images/itsfood21 landscape.png') }}"
                alt="{{ asset('images/itsfood21 landscape.png') }}">
            <div class="right_">
                <a href="{{ url('signup') }}" class="btn btn-primary">Daftar</a>
                <a href="{{ url('login') }}" class="btn btn-primary ms-3">Masuk</a>
            </div>
        </div>
    </div>
@endif
