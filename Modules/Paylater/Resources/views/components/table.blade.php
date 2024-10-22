<div class="accordion accordion-flush" id="accordionPaylaterModal">
    @foreach ($data['transaction'] ?? [] as $key => $itemTransaction)
        @php
            $timestamp = strtotime($itemTransaction['transaction_group_date']);
            $formattedDate = date('d M Y', $timestamp);
        @endphp
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading{{ $key }}">
                <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapse{{ $key }}" aria-expanded="false"
                    aria-controls="flush-collapse{{ $key }}">
                    Pembelian Paylater {{ $itemTransaction['transaction_receipt_number'] }} Pada {{ $formattedDate }}
                </button>
            </h2>
            <div id="flush-collapse{{ $key }}" class="accordion-collapse collapse"
                aria-labelledby="flush-heading{{ $key }}" data-bs-parent="#accordionPaylaterModal">
                <div class="accordion-body px-2">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <td class="fs-6 fw-bolder text-secondary px-2 py-1">Biaya Pajak</td>
                                <td class="fw-bolder text-end px-2 py-1">{{ $itemTransaction['transaction_tax_text'] }}</td>
                            </tr>
                            <tr>
                                <td class="fs-6 fw-bolder text-secondary px-2 py-1">Biaya Service</td>
                                <td class="fw-bolder text-end px-2 py-1">{{ $itemTransaction['transaction_service_text'] }}</td>
                            </tr>
                            <tr>
                                <td class="fs-6 fw-bolder text-secondary px-2 py-1">Biaya Kirim</td>
                                <td class="fw-bolder text-end px-2 py-1">{{ $itemTransaction['transaction_shipment_text'] }}</td>
                            </tr>
                            <tr>
                                <td class="fs-6 fw-bolder text-secondary px-2 py-1">Total</td>
                                <td class="fw-bolder text-end px-2 py-1">{{ $itemTransaction['transaction_grandtotal_text'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach 
</div>

<hr style="margin:8px 0 0;"> 
<div class="table-responsive">
    <table class="table table-borderless align-middle">
        <tbody>
            @foreach ($data['summary'] as $key => $itemSummary)
                <tr>
                    <td class="fs-6 fw-bolder text-secondary px-2 py-1">{{ $itemSummary['name'] }}</td>
                    <td class="fw-bolder text-end px-2 py-1">{{ $itemSummary['value'] }}</td>
                </tr>
            @endforeach
            <tr class="bg-blue">
                <td class="fs-6 fw-bolder text-light px-2 py-1">Total</td>
                <td class="fw-bolder text-end text-light px-2 py-1">{{ $data['grandtotal_text'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
