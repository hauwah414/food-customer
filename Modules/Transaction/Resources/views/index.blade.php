 @extends('layouts.dynamic')
@section('container')
    <section class="container  pt-3 pt-lg-5">
        @include('sections.breadcrumb')
        <div class="row px-2 px-md-0">
            <div class="card p-0" style="border-radius: 10px;">
                <div class="card-body p-md-4"> 
                     
                     @foreach ($data['transaction']['transaction_products'] ?? [] as $key => $transaction_products)
                        <div class="col-12 mt-3">
                            <div class="cart_items" style="width:100%;">
                                <div class="cart_items_product ms-0">
                                    <img style="object-fit: cover;"
                                        src="{{ $transaction_products['image'] ?? '' }}"alt="">
                                </div>
                                <div class="cart_items_desc">
                                    <h5 class="fw-bold mb-0 mt-0">{{ $transaction_products['product_name'] ?? '' }}
                                    </h5>
                                    <p class="mb-0"><strong>Jumlah :</strong>
                                        {{ $transaction_products['product_qty'] ?? '' }}</p>
                                    <p class="mb-0">
                                        {{ $transaction_products['product_total_price'] ?? '' }}</p>
                                    @if (isset($transaction_product['note']))
                                        <p class="mb-0">Catatan Pesanan :
                                            {{ $transaction_product['note'] ?? '' }}</p>
                                    @endif
                                </div>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <tbody>
                                @foreach ($data['transaction']['transaction_products'] ?? [] as $itemPrice)
                                    <tr>
                                        <td class="fs-6 fw-bolder text-secondary">{{ $itemPrice['product_name'] }},
                                            {{ $itemPrice['product_qty'] }} pcs</td>
                                        <td class="fw-bolder text-end">{{ $itemPrice['product_total_price'] }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($data['transaction']['payment_detail'] ?? [] as $payment_detail)
                                    <tr>
                                        <td class="fs-6 fw-bolder text-secondary">{{ $payment_detail['text'] }}</td>
                                        <td class="fw-bolder text-end">{{ $payment_detail['value'] }}</td>
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
                                        <td class="fs-4 text-light fw-bold bg-transparent">
                                            Total</td>
                                        <td class="fs-4 text-light  fw-bold text-end bg-transparent">
                                            {{ $data['transaction']['transaction_grandtotal'] ?? '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-5 d-flex flex-column">
                <p class="fw-5 fw-bold text-blue mb-3 mx-auto">{{ $data['transaction']['point_receive'] ?? '' }}</p>
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
                            data-transaction="{{ $data['transaction']['receipt_number_group'] ?? '' }}"
                            class="btn btn-danger rounded-pill fw-bold mt-2 " style="width:180px;"
                            data-bs-dismiss="modal">YA</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 