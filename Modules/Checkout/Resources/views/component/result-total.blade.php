<div class="table-responsive">
    <table class="table table-borderless align-middle">
        <tbody>
            @foreach ($data['items'] ?? [] as $itemsvalue)
                @foreach ($itemsvalue['items'] ?? [] as $productValue)
                    <tr>
                        <td class="fs-6 fw-bolder text-primary">
                            Outlet : {{ $itemsvalue['outlet_name'] ?? '' }}
                        </td>
                        <td></td>
                    </tr>
                    @if ($productValue['product_type'] == 'box')
                        @foreach ($productValue['products'] as $productValueBox)
                            <td class="fs-6 text-secondary">
                                {{ $productValueBox['product_name'] ?? '' }},
                                {{ $productValue['qty'] ?? '' }} pcs</td>
                            <td class="fw-bolder text-end">
                                Rp
                                {{ number_format($productValueBox['product_global_price'], 0, ',', '.') ?? '' }}
                            </td>
                            </tr>
                            @if ($productValue['product_discount'] != 0)
                                <tr>
                                    <td class="fs-6 fw-bolder text-secondary">
                                        Diskon</td>
                                    <td class="fw-bolder text-end">
                                        {{ $productValue['product_discount'] ?? '' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td class="fs-6 text-secondary">
                                {{ $productValue['product_name'] ?? '' }},
                                {{ $productValue['qty'] ?? '' }} pcs </td>
                            <td class="fw-bolder text-end">
                                {{ $productValue['product_price_text'] ?? '' }}</td>
                        </tr>
                        <tr style="border-top: 1px solid #6e767e69;">
                            <td class="fs-6 text-secondary">
                                Total </td>
                            <td class="fw-bolder text-end">
                                {{ $productValue['product_price_subtotal_text'] ?? '' }}</td>
                        </tr>
                        @if ($productValue['product_discount'] != 0)
                            <tr>
                                <td class="fs-6 fw-bolder text-secondary">
                                    Diskon</td>
                                <td class="fw-bolder text-end">
                                    {{ $productValue['product_discount'] ?? '' }}</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endforeach
            <tr></tr>
            <tr></tr>
            @foreach ($data['summary_order'] ?? [] as $summary_order)
                <tr>
                    <td class="fs-6 fw-bolder text-secondary">{{ $summary_order['name'] }}</td>
                    <td class="fw-bolder text-end">{{ $summary_order['value'] }}</td>
                </tr>
                @if ($summary_order['is_discount'] != 0)
                    <tr>
                        <td class="fs-6 fw-bolder text-secondary">Diskon</td>
                        <td class="fw-bolder text-end">{{ $summary_order['is_discount'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-footer border-0 py-2 bg-blue">
    <div class="table-responsive">
        <table class="table table-borderless align-middle">
            <tbody>
                <tr>
                    <td class="fs-4 text-light fw-bold  bg-transparent">
                        Grand Total</td>
                    <td class="fs-4 text-light  fw-bold text-end bg-transparent">
                        {{ $data['grandtotal_text'] ?? '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
