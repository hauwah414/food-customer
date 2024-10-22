@foreach ($data['items'] as $itemOrder)
    <tr>
        <td class="fw-bold fs-5" colspan="2">
            {{ $itemOrder['outlet_name'] }}
        </td>
    </tr> 
    @foreach ($itemOrder['items'] ?? [] as $item)
        <tr>
            <td class="fs-6" style="font-weight: 500;">
                {{ $item['product_name'] . ', ' . $item['qty'] }}pcs </td>
            <td class="fw-bolder text-end" id="result{{ $item['id_product'] }}">
                {{ $item['product_price_subtotal_text'] }}
            </td>
        </tr>
    @endforeach
@endforeach
<tr>
    <td></td>
    <td></td>
</tr>
<tr>
    <td class="fs-6 fw-bolder text-secondary">Total Harga</td>
    <td class="fw-bolder text-end" id="subtotal">
        Rp{{ number_format($data['subtotal'], 0, ',', '.') ?? '' }}</td>
</tr>
