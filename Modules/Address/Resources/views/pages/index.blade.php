@extends('layouts.dynamic')
@section('container')
    @if (session('error'))
        <div class="alert d-none" id="alertError">
            <p id="valueError">{{ session('error') }}</p>
        </div>
    @endif

    @if (session('success'))
        <div class="alert d-none" id="alertSuccess">
            <p id="valueSuccess">{{ session('success') }}</p>
        </div>
    @endif
    <section class="container py-3 py-lg-5">
        @include('sections.breadcrumb') 
        <div class="row mb-5">
            <div class="col-md-6">
                <h3 class="mb-0">Daftar Alamat</h3>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ url('address/create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>
        <div class="row">
            @foreach ($data['address'] ?? [] as $key => $itemAddress)
                <div class="col-12 @if ($key != 0) mt-3 @endif card"
                    id="card_{{ $itemAddress['id_user_address'] }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-0 text-blue"><strong>Penerima : </strong>{{ $itemAddress['receiver_name'] }}
                                </h5>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0 text-md-end">
                                @if ($itemAddress['main_address'] == 1)
                                    <button class="btn btn-success">Utama</button>
                                @else
                                    <button class="btn btn-outline-secondary" id="setMainAddress"
                                        data-id={{ $itemAddress['id_user_address'] }}>Jadikan Utama</button>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <p class="mb-0">{{ $itemAddress['receiver_phone'] }}</p>
                        <p class="mb-0">{{ $itemAddress['receiver_email'] }}</p>
                        <p class="mb-0">{{ $itemAddress['address'] }}</p>
                        <div class="text-end mt-3 mt-md-0">
                            <button id="btn-remove" data-id="{{ $itemAddress['id_user_address'] }}"
                                @if ($itemAddress['main_address'] == 1) disabled @endif class="btn btn-danger me-3">Hapus</button>
                            <a href="{{ url('address/show/' . $itemAddress['id_user_address']) }}"
                                class="btn btn-warning">Ubah</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('body').on('click', '#setMainAddress', function() {

            let id_user_address = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({

                url: `/address/mainAddress/`,
                type: "POST",
                cache: false,
                data: {
                    "id_user_address": id_user_address,
                    "_token": token
                },
                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    window.location.reload();
                }
            });

        });

        $('body').on('click', '#btn-remove', function() {

            let id_user_address = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({

                        url: `/address/destroy/`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "id_user_address": id_user_address,
                            "_token": token
                        },
                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            $(`#card_${id_user_address}`).remove();
                        }
                    });
                }
            })

        });

        var alertSuccessElement = document.getElementById('alertSuccess');

        if (alertSuccessElement && alertSuccessElement.classList.contains('alert')) {
            var valueSuccess = document.getElementById('valueSuccess');
            Swal.fire({
                icon: 'success',
                title: valueSuccess,
                showConfirmButton: false,
                timer: 3000
            });
        }

        var alertErrorElement = document.getElementById('alertError');

        if (alertErrorElement && alertErrorElement.classList.contains('alert')) {
            var valueError = document.getElementById('valueError');
            Swal.fire({
                icon: 'warning',
                title: valueError,
                showConfirmButton: false,
                timer: 3000
            });
        }
    </script>
@endpush
