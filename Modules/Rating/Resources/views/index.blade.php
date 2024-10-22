@extends('layouts.dynamic')
@section('container')
    <div class="container pt-3 pt-lg-5">
        @include('sections.breadcrumb')

        @foreach ($data['transaction']['transaction_products'] ?? [] as $itemTransaction)
            <div class="card mt-3">
                <div class="card-body d-flex flex-row">
                    <img width="120px" height="120px" style=" aspect-ratio:1/1; object-fit:cover;"
                        src="{{ $itemTransaction['image'] ?? '' }}" alt="{{ $itemTransaction['image'] ?? '' }}">
                    <div class="ms-3 d-flex flex-column">
                        <h5 class="mb-0 fw-bold">{{ $itemTransaction['product_name'] ?? '' }}</h5>
                        <button id="showModal" class="btn btn-link p-0 fw-5 text-decoration-none"
                            data-transaction="{{ $data['transaction']['id_transaction'] }}" class="fw-bold"
                            data-product="{{ $itemTransaction['id_product'] }}">Berikan
                            Penilaian</button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="modal fade" id="modalRating" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4 class="text-blue">Berikan Ulasan anda</h4>
                        <hr>
                        <div class="rating_">
                            <label class="form-label fw-bold mb-0">Rating</label>
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" id="rating" value="5" />
                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                <input type="radio" id="star4" name="rating" id="rating" value="4" />
                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                <input type="radio" id="star3" name="rating" id="rating" value="3" />
                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                <input type="radio" id="star2" name="rating" id="rating" value="2" />
                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                <input type="radio" id="star1" name="rating" id="rating" value="1" />
                                <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                            </div>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-rating"></div>
                        </div>

                        <div class="form-group  mt-3">
                            <label class="form-label fw-bold">Saran</label>
                            <input type="text" class="form-control " name="suggestion" id="suggestion"
                                placeholder="Masukan saran anda">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-suggestion"></div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label fw-bold">Bagaimana menurutmu produk ini?</label>
                            <textarea type="text" class="form-control " name="option_value" id="option_value" placeholder="Tulis ulasan anda">Pelayanan Baik, Sikap Baik, Rapi, Cepat</textarea>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-option_value"></div>
                        </div>

                        <div class="mt-5 text-center">
                            <button id="SubmitRating" class="btn btn-primary mx-auto fs-5"
                                style="width:200px;">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $('[name=option_value]').tagify();

        $('#modalRating').on('hidden.bs.modal', function() {
            if ($('#alert-suggestion').hasClass('d-block')) {
                $('#alert-suggestion').addClass('d-none');
            }
            if ($('#alert-option_value').hasClass('d-block')) {
                $('#alert-option_value').addClass('d-none');
            }
            if ($('#alert-rating').hasClass('d-block')) {
                $('#alert-rating').addClass('d-none');
            }

            $('#suggestion').val('').attr('placeholder', 'Masukan saran anda');
            $('#option_value').val('Pelayanan Baik, Sikap Baik, Rapi, Cepat');

            var rating = document.getElementsByName("rating");

            for (var i = 0; i < rating.length; i++) {
                rating[i].checked = false;
            }

        });

        $('body').on('click', '#showModal', function() {
            let transaction = $(this).data('transaction');
            let product = $(this).data('product');

            $('#modalRating').modal('show');

            $('body').on('click', '#SubmitRating', function() {
                let token = $("meta[name='csrf-token']").attr("content");
                let suggestion = $("#suggestion").val();
                let option_value = $("#option_value").val();

                if (suggestion.trim() === '') {
                    $('#alert-suggestion').removeClass('d-none');
                    $('#alert-suggestion').addClass('d-block');
                    $('#alert-suggestion').html('Saran tidak boleh kosong');
                } else {
                    $('#alert-suggestion').addClass('d-none');
                }

                if (option_value.trim() === '') {
                    $('#alert-option_value').removeClass('d-none');
                    $('#alert-option_value').addClass('d-block');
                    $('#alert-option_value').html('Ulasan Produk tidak boleh kosong');
                } else {
                    $('#alert-option_value').addClass('d-none');
                }

                var rating = document.getElementsByName("rating");

                for (var i = 0; i < rating.length; i++) {
                    if (rating[i].checked) {
                        var ratings = rating[i].value;
                    }
                }

                if ($('input[name="rating"]:checked').length === 0) {
                    $('#alert-rating').removeClass('d-none');
                    $('#alert-rating').addClass('d-block');
                    $('#alert-rating').html('Rating tidak boleh kosong');
                } else {
                    $('#alert-rating').addClass('d-none');
                }

                if (suggestion.trim() !== '' && option_value.trim() !== '' && $(
                        'input[name="rating"]:checked').length != 0) {
                    Swal.fire({
                        title: 'Ulasan hanya dapat diberikan 1x',
                        text: "Apakah anda yakin mengirimkan ulasan ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'TIDAK',
                        confirmButtonText: 'YA'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/rating/create`,
                                type: "POST",
                                cache: true,
                                data: {
                                    "transaction": transaction,
                                    'product': product,
                                    'suggestion': suggestion,
                                    'rating': ratings,
                                    'option_value': option_value,
                                    "_token": token
                                },
                                success: function(response) {

                                    $('#modalRating').modal('hide');

                                    Swal.fire({
                                        type: 'success',
                                        icon: 'success',
                                        title: `${response.message}`,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                },
                                error: function(error) {
                                    $('#modalPayment').modal('hide');
                                    Swal.fire({
                                        icon: 'error',
                                        title: `Maaf anda gagal memberikan ulasan !`,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            });
                        }
                    })
                }
            });

        });
    </script>
@endpush
