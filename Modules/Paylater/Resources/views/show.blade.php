@extends('layouts.dynamic')
@section('container')
    <section class="container  pt-3 pt-lg-5">
        @include('sections.breadcrumb')
        <div class="row px-2 px-md-0">
            <div class="card p-0" style="border-radius: 10px;">
                <div class="card-body p-md-4">
                    <h5>
                        <strong class="fw-bold">Status Transaksi : </strong>
                        {{ $data['detail']['transaction_payment_status'] ?? '' }} 
                    </h5>
                    <h6 class="mb-0">Nomor VA : {{ $data['detail']['account_number'] }}</h6>
                    @if ($data['detail']['expiration_date'] != null)
                        @php
                            $expiration_date = strtotime($data['detail']['expiration_date']);
                            $exDate = date('d M Y', $expiration_date);
                            $exTime = date('H:i', $expiration_date);
                        @endphp
                        <h6>Jatuh tempo : {{ $exDate }}, Jam : {{ $exTime }} </h6>
                    @endif
                    <hr style="border-top: 2px dotted;">
                    <h5 class="text-blue fw-bold mb-3">Detail</h5>
                    @foreach ($data['detail']['payments'] as $key => $payment)
                        @if ($key != 0)
                            <hr>
                        @endif
                        @php
                            $timestamp = strtotime($payment['transaction_group_date']);
                            $formattedDate = date('d M Y', $timestamp);
                        @endphp
                        <div class="px-2">
                            <h6 class="mb-0 text-blue fw-bold">{{ $formattedDate }}</h6>
                            <p class="mb-0">Pembelian Paylater - {{ $payment['transaction_receipt_number'] }}</p>
                        </div>
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                <tr>
                                    <td class="fs-6 fw-bolder text-secondary px-2 py-1">Sub Total</td>
                                    <td class="fw-bolder text-end px-2 py-1">{{ $payment['transaction_subtotal_text'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-bolder text-secondary px-2 py-1">Biaya Pajak</td>
                                    <td class="fw-bolder text-end px-2 py-1">{{ $payment['transaction_tax_text'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-bolder text-secondary px-2 py-1">Biaya Service</td>
                                    <td class="fw-bolder text-end px-2 py-1">{{ $payment['transaction_service_text'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-bolder text-secondary px-2 py-1">Biaya Kirim</td>
                                    <td class="fw-bolder text-end px-2 py-1">{{ $payment['transaction_shipment_text'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fs-6 fw-bolder text-secondary px-2 py-1">Total</td>
                                    <td class="fw-bolder text-end px-2 py-1">{{ $payment['transaction_grandtotal_text'] }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                    <hr style="border-top: 2px dotted;">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                @foreach ($data['detail']['summary'] ?? [] as $summary)
                                    <tr>
                                        <td class="fs-6 fw-bolder text-secondary">{{ $summary['name'] }}</td>
                                        <td class="fw-bolder text-end">{{ $summary['value'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer border-0 py-2 bg-blue"
                        style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <tbody>
                                    <tr>
                                        <td class="fs-4 text-light fw-bold ">
                                            Total</td>
                                        <td class="fs-4 text-light  fw-bold text-end">
                                            {{ $data['detail']['transaction_grandtotal_text'] ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Modal -->
    <div class="modal fade" id="cancelModalTransaction" tabindex="-1" aria-labelledby="modalLogoutLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="icon_logout text-danger">
                        <i class="fa-solid fa-question"></i>
                    </div>
                    <h5>Apakah anda ingin membatalkan transaksi ini ?</h5>
                    <div class="text-center d-flex flex-column align-items-center mt-3">
                        <button type="button" id="cencelTransactionTrue"
                            data-transaction="{{ $data['detail']['receipt_number_group'] ?? '' }}"
                            class="btn btn-danger rounded-pill fw-bold mt-2 " style="width:180px;"
                            data-bs-dismiss="modal">YA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
