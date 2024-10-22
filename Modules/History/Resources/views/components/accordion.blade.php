<div class="accordion accordion-flush mt-3 history_accordion" id="accordionHistory">
    @php
        $no = 0;
    @endphp

    @foreach ($data['history'] ?? [] as $key => $itemHistory)
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button @if ($key != 0) collapsed @endif" type="button"
                    data-bs-toggle="collapse" data-bs-target="#flush-{{ $key }}" aria-expanded="false"
                    aria-controls="flush-{{ $key }}">
                    Transaksi Tanggal : {{ $itemHistory['date'] }}
                </button>
            </h2>
            <div id="flush-{{ $key }}"
                class="accordion-collapse collapse @if ($key == 0) show @endif "
                aria-labelledby="flush-headingOne" data-bs-parent="#accordionHistory">
                <div class="accordion-body">
                    @foreach ($itemHistory['transactions'] as $key => $transaction)
                        @if ($key != 0)
                            <hr style="border-top:1px dotted;">
                        @endif
                        <div class="d-flex flex-row history_card">
                            <img class="history_card_image" src="{{ $transaction['outlet_logo'] ?? '' }}"
                                alt="">
                            <div class="history_card_content">
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-8 order-2 order-md-1">
                                        <p class="fs-5 mb-0"><strong>{{ $transaction['outlet_name'] ?? '' }}</strong></p>
                                        <h5 class="mb-0">{{ $transaction['product_name'] ?? '' }}</h5>
                                        <p class="mb-0"><strong>No Transaksi :</strong>
                                            {{ $transaction['transaction_receipt_number'] ?? '' }}</p>
                                        <p class="mb-0"><strong>No Transaksi Group :</strong>
                                            {{ $transaction['transaction_receipt_number_group'] ?? '' }}</p>

                                        @foreach ($transaction['product'] as $key => $itemProduct)
                                            @if ($key > 0)
                                                <hr class="d-lg-none my-1">
                                            @endif
                                            <div class="row w-100 ps-2">
                                                <p class="mb-0 col-lg-4">
                                                    <strong>Menu
                                                    </strong>
                                                    {{ $itemProduct['product_name'] }}
                                                </p>
                                                <p class="mb-0 col-lg-4 ms-auto">
                                                    <strong>Qty
                                                    </strong>
                                                    {{ $itemProduct['transaction_product_qty'] }}
                                                </p>
                                                <p class="mb-0 col-lg-4 ms-auto">
                                                    <strong>Harga
                                                    </strong> Rp
                                                    {{ str_replace('.00', '', $itemProduct['transaction_product_price']) }}
                                                </p>
                                            </div>
                                        @endforeach
                                        <hr class="d-lg-none my-1">
                                        <p class="mb-0"><strong>Total :</strong> Rp.
                                            {{ number_format($transaction['transaction_grandtotal'], 0, ',', '.') ?? '' }}
                                        </p>
                                        <a class="text-decoration-none text-blue"
                                            href="{{ url('history/' . $transaction['transaction_receipt_number']) }}">Detail</a>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-4 order-1 order-md-2 text-md-end">
                                        <div class="alert @if ($transaction['transaction_status_text'] == 'Belum dibayar') alert-warning @elseif($transaction['transaction_status_text'] == 'Dibatalkan') alert-danger  @elseif($transaction['transaction_status_text'] == 'Menunggu Konfirmasi') alert-info @else alert-secondary @endif ms-md-auto py-1"
                                            role="alert" style="width:max-content !important;">
                                            {{ $transaction['transaction_status_text'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
