@extends('layouts.dynamic')
@section('container')
<section class="container">
    @include('sections.breadcrumb')
    <h1 class="fw-bolder mb-5">Pembayaran</h1>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-10 col-xl-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-6">
                            <p class="fs-5 mb-0">Total Pembayaran :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="fs-5 mb-0">Rp
                                {{ number_format($data['transaction']['amount'], 0, ',', '.') ?? '' }}
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="fs-5 mb-0">Jatuh Tempo :</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="fs-5 mb-0" id="expiration_date">
                                {{ $data['transaction']['expiration_date'] ?? '' }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-blue mt-3 mb-2 text-center">
                        {{ $data['transaction']['transaction_receipt_number'] ?? '' }}</strong>
                    </h4>
                    <h5 class="mb-3 text-center">Status :
                        <strong>{{ $data['transaction']['transaction_payment_status'] ?? '' }}</strong>
                    </h5>
                    <h5 class="text-center mb-3">BANK :
                        <strong>{{ str_replace("_", " ", $data['transaction']['type'])}}</strong>
                    </h5>
                    </h5>
                    <h5 class="text-center">Nomor Rekening : <br>
                        <strong>{{ $data['transaction']['account_number'] ?? '' }}</strong>
                        <input type="text" name="account" id="account" readonly hidden value="{{ $data['transaction']['account_number'] ?? '' }}">
                    </h5>
                    <div class="text-center">
                        <button id="copy" class="btn btn-primary">Copy</button>
                    </div>
                    <hr>
                    <p class="text-center">Silahkan transfer ke nomor virtual :
                        <strong>{{ $data['transaction']['account_number'] }}</strong>
                    </p>
                    <div id="countdown"></div>

                    {{-- <div class="py-3 d-flex flex-column"
                            style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <button id="confirm" class="btn btn-primary mx-auto fs-5" style="width:280px;">OK</button>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    const copyButton = document.getElementById('copy');
    const accountInput = document.getElementById('account');

    copyButton.addEventListener('click', function() {
        const accountValue = accountInput.value;
        navigator.clipboard.writeText(accountValue)
    });
</script>
@endpush