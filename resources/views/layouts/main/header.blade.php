<header>
    <div class="container-md">
        <div class="navbar_">
            <div class="navbar_brand">
                <a href="{{ url('/') }}">
                    <img class="navbar_brand_desktop" src="{{ asset('images/navbar-brand.png') }}" alt="">
                    <img class="navbar_brand_mobile" src="{{ asset('images/favicon.png') }}" alt="">
                </a>
            </div>

            @if (!Request::is('/') && !Request::is('search'))
                <div class="navbar_search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="form-control" placeholder="Cari makanan" id="searching" onkeydown="searching()">
                </div>
            @endif



            <div class="navbar_right">
                <a href="{{ url('/billpayment') }}" class="btn btn-link position-relative" id="Billpayment">
                    <i class="fa-solid fa-money-bills"></i>
                    <span class="position-absolute top-8 start-100 translate-middle text-light" style="font-size:12px;"
                        id="countBillpayment">
                        0
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                @if (session('total_favorite') == null)
                    <a href="{{ route('favorite') }}" class="btn btn-link position-relative">
                        <i class="fa-solid fa-heart"></i>
                        <span class="position-absolute top-8 start-100 translate-middle" style="font-size:12px;">
                            0
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                @else
                    <a href="{{ route('favorite') }}" class="btn btn-link position-relative text-danger">
                        <i class="fa-solid fa-heart"></i>
                        <span class="position-absolute top-8 start-100 translate-middle text-light"
                            style="font-size:12px;">
                            {{ session('total_favorite') }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                @endif
                <a href="{{ url('/notification') }}" class="btn btn-link position-relative" id="notification">
                    <i class="fa-solid fa-bell"></i>
                    <span class="position-absolute top-8 start-100 translate-middle text-light" style="font-size:12px;"
                        id="countNotification">
                        0
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <a href="{{ url('/cart') }}" class="btn btn-link position-relative" id="cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="position-absolute top-8 start-100 translate-middle text-light" style="font-size:12px;"
                        id="countCart">
                        0
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <div class="dropdown navbar_right_profile">
                    <button class="btn btn-link btn-link-profile" type="button" id="dropdownMenu2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if (!isset(session('detail_user')['photo']))
                            <img class="img-profile" src="{{ asset('images/avatar.jpg') }}">
                        @else
                            <img class="img-profile" src="{{ session('detail_user')['photo'] }}" alt="">
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ url('history') }}">History</a></li>
                        <li><a class="dropdown-item" href="{{ url('address') }}">Alamat</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                data-bs-target="#modalLogout">Logout</a></li>
                    </ul>
                </div>
                <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#canvasNavigation" aria-controls="canvasNavigation">
                    <i class="fa-solid fa-bars"></i> </button>
            </div>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="canvasNavigation" aria-labelledby="canvasNavigationLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="canvasNavigationLabel">Menu Utama</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="profile_image">
            @if (!isset(session('detail_user')['photo']))
                <img class="img-profile" src="{{ asset('images/avatar.jpg') }}">
            @else
                <img class="img-profile" src="{{ session('detail_user')['photo'] }}" alt="">
            @endif
            @if (isset(session('detail_user')['info']['name']))
                <h5>{{ session('detail_user')['info']['name'] }}</h5>
            @endif
        </div>
        <ul>
            <li>
                <a href="{{ url('profile') }}">Profile</a>
            </li>
            <li>
                <a href="{{ url('history') }}">History</a>
            </li>
            <li>
                <a href="{{ url('address') }}">Alamat</a>
            </li>
            <li>
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalLogout">Logout</a>
            </li>
            </li>
        </ul>
    </div>
</div>

<div class="navigation_bottom">
    <div class="container-md">
         <a href="{{ url('/') }}" class="btn btn-link position-relative" id="billpaymentMobile">
            <i class="fa-solid fa-home"></i> 
        </a>
        <a href="{{ url('/billpayment') }}" class="btn btn-link position-relative" id="billpaymentMobile">
            <i class="fa-solid fa-money-bills"></i>
            <span class="position-absolute top-8 start-100 translate-middle text-dark" style="font-size:12px;"
                id="countBillpaymentMobile">
                0
                <span class="visually-hidden">unread messages</span>
            </span>
        </a>
        @if (session('total_favorite') == null)
            <a href="{{ route('favorite') }}" class="btn btn-link position-relative">
                <i class="fa-solid fa-heart"></i>
                <span class="position-absolute top-8 start-100 translate-middle" style="font-size:12px;">
                    0
                    <span class="visually-hidden">unread messages</span>
                </span>
            </a>
        @else
            <a href="{{ route('favorite') }}" class="btn btn-link position-relative text-danger">
                <i class="fa-solid fa-heart"></i>
                <span class="position-absolute top-8 start-100 translate-middle text-dark" style="font-size:12px;">
                    {{ session('total_favorite') }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </a>
        @endif
        <a href="{{ url('/notification') }}" class="btn btn-link position-relative" id="notificationMobile">
            <i class="fa-solid fa-bell"></i>
            <span class="position-absolute top-8 start-100 translate-middle text-dark" style="font-size:12px;"
                id="countNotificationMobile">
                0
                <span class="visually-hidden">unread messages</span>
            </span>
        </a>
        <a href="{{ url('/cart') }}" class="btn btn-link position-relative" id="cartMobile">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="position-absolute top-8 start-100 translate-middle text-dark" style="font-size:12px;"
                id="countCartMobile">
                0
                <span class="visually-hidden">unread messages</span>
            </span>
        </a>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="icon_logout">
                    <i class="fa-solid fa-power-off"></i>
                </div>
                <h5>Pilih <strong class="text-blue">LOGOUT</strong> di bawah ini jika Anda siap untuk mengakhiri sesi
                    Anda saat ini.</h5>
                <div class="text-center d-flex flex-column align-items-center mt-3">
                    <a href="{{ route('logout') }}" class="btn btn-primary rounded-pill fw-bold bg-blue border-blue"
                        style="width:180px;">LOGOUT</a>
                    <button type="button" class="btn btn-light rounded-pill fw-bold mt-2 text-blue"
                        style="width:180px;" data-bs-dismiss="modal">BATAL</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        @if (!Request::is('/') && !Request::is('search'))

            function searching() {
                if (event.key === "Enter") {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(success, error);
                    } else {
                        alert('Browser Anda tidak mendukung geolocation');
                    }
                    let token = $("meta[name='csrf-token']").attr("content"); 

                    function success(position) {
                        let latitude = position.coords.latitude;
                        let longitude = position.coords.longitude;
                        let key = $("#searching").val();
                        let min_value = '0';
                        let max_value = '500000';


                        $.ajax({
                            url: `/dashboard/search`,
                            type: "POST",
                            cache: false,
                            data: {
                                "key": key,
                                "min_value": min_value,
                                "max_value": max_value,
                                "longitude": longitude,
                                "latitude": latitude,
                                "_token": token
                            },
                            success: function(response) {
                                window.location.href = '/search';
                            },
                        });
                    }

                    function error() {
                        let key = $("#searching").val();
                        let min_value = '0';
                        let max_value = '500000';

                        $.ajax({
                            url: `/dashboard/search`,
                            type: "POST",
                            cache: false,
                            data: {
                                "key": key,
                                "min_value": min_value,
                                "max_value": max_value,
                                "_token": token
                            },
                            success: function(response) {
                                window.location.href = '/search';
                            },
                        });
                    }
                }
            }
        @endif

        if (document.getElementById("cart")) {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/cart/count`,
                type: "POST",
                cache: false,
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.data != 0) {
                        const countCart = document.getElementById('countCart');
                        countCart.textContent = response.data;
                        const cartElement = document.getElementById('cart');
                        cartElement.classList.add('text-danger');

                        const countCartMobile = document.getElementById('countCartMobile');
                        countCartMobile.textContent = response.data;
                        const cartMobileElement = document.getElementById('cartMobile');
                        cartMobileElement.classList.add('text-danger');
                    }
                },
                error: function(xhr, status, error) {}
            });
        }

        if (document.getElementById("notification")) {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({

                url: `/notification/count`,
                type: "POST",
                cache: false,
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.data != 0) {
                        const countNotification = document.getElementById('countNotification');
                        countNotification.textContent = response.data;
                        const notificationElement = document.getElementById('notification');
                        notificationElement.classList.add('text-danger');


                        const countNotificationMobile = document.getElementById('countNotificationMobile');
                        countNotificationMobile.textContent = response.data;
                        const notificationMobileElement = document.getElementById('notificationMobile');
                        notificationMobileElement.classList.add('text-danger');
                    }
                },
                error: function(xhr, status, error) {}
            });
        }

         

        if (document.getElementById("billpayment")) {
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({

                url: `/billpayment/count`,
                type: "POST",
                cache: false,
                data: {
                    "_token": token
                },
                success: function(response) {
                    if (response.data != 0) {
                        const countBillpayment = document.getElementById('countBillpayment');
                        countBillpayment.textContent = response.data;
                        const billpayment = document.getElementById('billpayment');
                        billpayment.classList.add('text-danger');


                        const countBillpaymentMobile = document.getElementById('countBillpaymentMobile');
                        countBillpaymentMobile.textContent = response.data;
                        const paylaterMobileElement = document.getElementById('paylaterMobile');
                        paylaterMobileElement.classList.add('text-danger');
                    }
                },
                error: function(xhr, status, error) {}
            });
        }


        $('body').on('click', '#userDropdown', function() {
            const userDropdown = document.getElementById('userDropdown');
            const infoUserDropdown = document.getElementById('infoUserDropdown');

            if (userDropdown.classList.contains('show')) {
                userDropdown.classList.remove('show');
                infoUserDropdown.classList.remove('show');
            } else {
                userDropdown.classList.add('show');
                infoUserDropdown.classList.add('show');
            }
        });
    </script>
@endpush
