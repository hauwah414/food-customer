<div class="modal fade" id="modalPayment" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-blue">Metode Pembayaran</h4>
                <hr>
                @foreach ($data['payment'] ?? [] as $key => $payment)
                    <div class="form_check mt-2">
                        <input class="form-check-input form_check_input" type="radio" name="paymentMethod"
                            id="paymentMethod" value="{{ $payment['payment_method'] }}"
                            @if ($key == 0) checked @endif>
                        <label class="fs-5">
                            {{ $payment['text'] }}
                        </label>
                    </div>
                @endforeach
                <div class="mt-3 text-center">
                    <button id="confirmationPayment" class="btn btn-primary mx-auto fs-5"
                        style="width:200px;">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('body').on('click', '#typePayment', function() {
            $('#modalPayment').modal('show');
        });

        $('body').on('click', '#confirmationPayment', function() {
            var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            let token = $("meta[name='csrf-token']").attr("content");
            let id_transaction_group = {{ $data['history']['id_transaction_group'] }};
            $.ajax({
                url: `/history/payment/confirmation`,
                type: "POST",
                cache: false,
                data: {
                    "paymentMethod": paymentMethod,
                    "id_transaction_group": id_transaction_group,
                    "_token": token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    window.location.href = "/transaction/" + response.data;
                },
                error: function(error) {
                    $('#modalPayment').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: `${error.responseJSON.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
    </script>
@endpush
