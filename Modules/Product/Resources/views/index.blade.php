@extends('layouts.dynamic')
@section('container')
    <section class="pt-3 pt-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            <div class="" id="resultProducts">

            </div>
        </div>
    </section>
@endsection



@push('scripts')
    <script>
        function getProducts() {
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
                    url: `/product/get-products`,
                    type: "POST",
                    cache: false,
                    data: {
                        "longitude": longitude,
                        "latitude": latitude,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultProducts").html(response)
                    },
                });
            }

            function error() {
                $.ajax({
                    url: `/product/get-products`,
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultProducts").html(response)
                    },
                });
            }
        }

        getProducts();

        $('body').on('click', '#addFavorite', function() {
            let product_id = $(this).data('favorite');
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/favorite/create`,
                type: "POST",
                cache: false,
                data: {
                    "product_id": product_id,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    location.reload();
                },
            });
        });

        $('body').on('click', '#deleteFavorite', function() {
            let product_id = $(this).data('favorite');
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini dari list favorite!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/favorite/delete`,
                        type: "POST",
                        cache: false,
                        data: {
                            "product_id": product_id,
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                        }
                    });
                }
            })
        });

        $('body').on('click', '#paginationProducts', function() {
            let id_page = $(this).data('page');
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
                    url: `/product/get-products`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_page": id_page,
                        "longitude": longitude,
                        "latitude": latitude,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultProducts").html(response)
                    },
                });
            }

            function error() {
                $.ajax({
                    url: `/product/get-products`,
                    type: "POST",
                    cache: false,
                    data: {
                        "id_page": id_page,
                        "_token": token
                    },
                    success: function(response) {
                        $("#resultProducts").html(response)
                    },
                });
            }
        });
    </script>
@endpush
