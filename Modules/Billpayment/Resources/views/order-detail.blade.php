@extends('layouts.dynamic')
@section('container')
    <section class="container py-3 py-lg-5">
        @include('sections.breadcrumb')
        <div class="history">
            <ul class="nav_ mb-3 justify-content-start ps-0 w-100" id="pills-tab" role="tablist">
                <li class="nav_item" role="presentation">
                    <button class="nav_link btn active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">Detail Pemesanan</button>
                </li>
                @foreach ($data['billpayment']['transaction'] as $itemTransaction)
                    <li class="nav_item" role="presentation">
                        <button class="nav_link btn" id="pills-{{ $itemTransaction['id_transaction'] }}-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-{{ $itemTransaction['id_transaction'] }}"
                            type="button" role="tab" aria-controls="pills-{{ $itemTransaction['id_transaction'] }}"
                            aria-selected="false">{{ $itemTransaction['outlet_name'] }}</button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content border p-3" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <h3>Transaction Info</h3>
                    <hr style="border-top:2px dotted">
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="mb-0">
                                Receipt Number
                            </p>
                        </div>
                        <div class="col-6 col-md-5">
                            <p class="mb-0">
                                <strong>:{{ $data['billpayment']['group']['transaction_receipt_number'] ?? '' }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="mb-0">
                                Jenis Pembayaran
                            </p>
                        </div>
                        <div class="col-6 col-md-5">
                            <p class="mb-0"><strong>:
                                @if ($data['billpayment']['group']['transaction_payment_type'])
                                Tagihan
                                @else
                                {{ $data['billpayment']['group']['transaction_payment_type'] ?? '' }} 
                                @endif
                                
                            </strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="mb-0">
                                Status Pembayaran
                            </p>
                        </div>
                        <div class="col-6 col-md-5">
                            <p class="mb-0"><strong>:
                                    {{ $data['billpayment']['group']['transaction_payment_status'] ?? '' }}</strong>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="mb-0">
                                Tujuan Pembelian
                            </p>
                        </div>
                        <div class="col-6 col-md-5">
                            <p class="mb-0"><strong>:
                                    {{ $data['billpayment']['group']['tujuan_pembelian'] ?? '' }}</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-4">
                            <p class="mb-0">
                                Sumber Dana
                            </p>
                        </div>
                        <div class="col-6 col-md-5">
                            <p class="mb-0"><strong>: {{ $data['billpayment']['group']['sumber_dana'] ?? '' }}</strong>
                            </p>
                        </div>
                    </div>

                    <h3 class="mt-3">PAYMENT</h3>
                    <hr style="border-top:2px dotted">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0">
                                Subtotal
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            Rp {{ number_format($data['billpayment']['group']['transaction_subtotal'], 0, ',', '.') ?? '' }}
                            </p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0">
                                Total Biaya Pengiriman
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0">
                                Rp
                                {{ number_format($data['billpayment']['group']['transaction_shipment'], 0, ',', '.') ?? '' }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0">
                                <strong>GRAND TOTAL</strong>
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0">
                                <strong>
                                    Rp
                                    {{ number_format($data['billpayment']['group']['transaction_grandtotal'], 0, ',', '.') ?? '' }}
                                </strong>
                            </p>
                        </div>
                    </div>

                    <h3 class="mt-5">TRANSACTION</h3>
                    <hr style="border-top:2px dotted">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Transaksi Vendor</th>
                                    <th>Nama Vendor</th>
                                    <th>Nama Pemesan</th>
                                    <th>Tanggal Pengantaran</th>
                                    <th>Subtotal</th>
                                    <th>Biaya Pengiriman</th>
                                    <th>Grandtotal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['billpayment']['outlet'] as $itemTransacionDetail)
                                    <tr>
                                        <td>{{ $itemTransacionDetail['transaction_receipt_number'] }}</td>
                                        <td>{{ $itemTransacionDetail['outlet_name'] }}</td>
                                        <td>
                                            {{ $itemTransacionDetail['user_name'] }}<br>
                                            {{ $itemTransacionDetail['user_phone'] }} <br>
                                            {{ $itemTransacionDetail['user_email'] }}
                                        </td>
                                        <td>{{ $itemTransacionDetail['transaction_date'] }}</td>
                                        <td>
                                            Rp
                                            {{ number_format($itemTransacionDetail['transaction_subtotal'], 0, ',', '.') ?? '' }}
                                        </td>
                                        <td>
                                            Rp
                                            {{ number_format($itemTransacionDetail['transaction_shipment'], 0, ',', '.') ?? '' }}
                                        </td>
                                        <td>
                                            Rp
                                            {{ number_format($itemTransacionDetail['transaction_grandtotal'], 0, ',', '.') ?? '' }}
                                        </td>
                                        <td>{{ $itemTransacionDetail['transaction_status_text'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

                @foreach ($data['billpayment']['transaction'] as $itemTransactionDesc)
                    <div class="tab-pane fade" id="pills-{{ $itemTransactionDesc['id_transaction'] }}" role="tabpanel"
                        aria-labelledby="pills-{{ $itemTransactionDesc['id_transaction'] }}-tab">
                        <h3>Transaction Info</h3>
                        <hr style="border-top:2px dotted">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <p class="mb-0">
                                    Receipt Number
                                </p>
                            </div>
                            <div class="col-6 col-md-5">
                                <p class="mb-0">
                                    <strong>
                                        :
                                        {{ $itemTransactionDesc['transaction_receipt_number'] ?? '' }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <p class="mb-0">
                                    Order Status
                                </p>
                            </div>
                            <div class="col-6 col-md-5">
                                <p class="mb-0">
                                    <strong>
                                        : {{ $itemTransactionDesc['transaction_status_text'] ?? '' }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <p class="mb-0">
                                    Time & date
                                </p>
                            </div>
                            <div class="col-6 col-md-5">
                                <p class="mb-0">
                                    <strong>: {{ $itemTransactionDesc['transaction_date'] ?? '' }}</strong>
                                </p>
                            </div>
                        </div>
                        <h3 class="mt-5">Product</h3>
                        <hr style="border-top:2px dotted">
                        @foreach ($itemTransactionDesc['transaction_products'] as $key => $itemProduct)
                            @if ($key != 0)
                                <hr>
                            @endif
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-0">
                                        {{ $itemProduct['product_name'] }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">
                                        {{ $itemProduct['product_base_price'] }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">
                                        Quality {{ $itemProduct['product_qty'] }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-0">
                                        <strong>{{ $itemProduct['product_total_price'] }}</strong>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script></script>
@endpush
