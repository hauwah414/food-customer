<!doctype html>
<html lang="en">

<head>
    @include('layouts.main.head')
</head>

<body>

    @include('sweetalert::alert')
    @if (session('detail_user') != null)
        @include('layouts.main.header')
    @else
        @include('layouts.main.header-withoutlogin')
    @endif
    @yield('container')

    <button class="btn btn-floating" id="linkCs">
        <img src="{{ asset('images/whatsapp.png') }}" alt="{{ asset('images/whatsapp.png') }}">
    </button>

    @include('layouts.main.footer')
    <div class="modal fade" id="modalPermission" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="icon_logout text-danger">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h5 class="text-danger">Tolong aktifkan lokasi anda!!!</h5>
                    <div class="text-center d-flex flex-column align-items-center mt-3">
                        <button id="allowPermission" class="btn btn-primary rounded-pill fw-bold bg-blue border-blue"
                            style="width:180px;">AKTIFKAN</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $('body').on('click', '#allowPermission', function() {
                navigator.permissions.query({
                    name: 'geolocation'
                }).then(function(result) {
                    if (result.state == 'granted') {
                        $('#modalPermission').modal('hide');
                        location.reload();
                    } else if (result.state == 'prompt') {
                        location.reload();

                        function error() {
                            $('#modalPermission').modal('show');
                        }
                    } else {
                        $('#modalPermission').modal('show');
                    }
                });
            });
        </script>
    @endpush
    @include('layouts.main.script')


</body>

</html>
