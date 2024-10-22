<div class="row">
    @foreach ($data['products']['data'] ?? [] as $key => $itemProduct)
        <div class="col-sm-6 col-lg-3 mt-3 mt-md-4">
            <div class="card card_product shadow-sm">
                <div class="card-body">
                    <img src="{{ $itemProduct['image'] ?? '' }}" alt="{{ $itemProduct['product_name'] ?? '' }}"
                        alt="{{ $itemProduct['product_name'] }}">
                    <div class="row my-3 desc_">
                        <div class="col-md-6">
                            <h5>{{ substr($itemProduct['product_name'], 0, 80) ?? '' }}</h5>
                        </div>
                        <div class="col-md-6 d-flex">
                            <h5 class="ms-md-auto">
                                Rp{{ number_format($itemProduct['product_price'], 0, ',', '.') ?? '' }}
                            </h5>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-row mt-2 mb-3">
                        <span class="badge bg-light text-dark me-3">{{ $itemProduct['text_preorder'] }}</span>
                        <span class="badge bg-light text-dark ">{{ $itemProduct['text_min_order'] }}</span>
                    </div>
                    <a href="{{ url('/product/' . base64_encode($itemProduct['id_product'])) }}" class="btn btn-warning">
                        Lihat</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="pagination_ py-5">
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item @if (!isset($data['products']['prev_page_url'])) disabled @endif ">
                <button type="button" class="page-link" id="paginationProducts"
                    data-page="{{ $data['products']['current_page'] - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>
            @if ($data['products']['last_page'] >= 5)
                @if ($data['search']['last_page'] - $data['search']['current_page'] >= 3)
                    <li class="page-item  active">
                        <button type="button" class="page-link" id="paginationProducts"
                            data-page="{{ $data['products']['current_page'] }}">{{ $data['products']['current_page'] }}</button>
                    </li>
                @elseif ($data['search']['last_page'] - $data['search']['current_page'] <= 3)
                    <li class="page-item">
                        <button type="button" class="page-link" id="paginationProducts" data-page="1">1</button>
                    </li>
                @endif
                @php
                    $lastPage = $data['products']['last_page'];
                    $currentPage = $data['products']['current_page'];
                    $maxPagesToShow = 3;
                    $startPage = $currentPage + 1;
                    if ($startPage + $maxPagesToShow > $lastPage) {
                        $startPage = max($lastPage - $maxPagesToShow + 1, 1);
                    }
                @endphp
                @for ($i = $startPage; $i <= min($startPage + $maxPagesToShow - 1, $lastPage); $i++)
                    <li class="page-item @if ($currentPage == $i) active @endif">
                        <button type="button" class="page-link" id="paginationProducts"
                            data-page="{{ $i }}">{{ $i }}</button>
                    </li>
                @endfor
            @else
                @for ($i = 1; $i <= $data['products']['last_page']; $i++)
                    <li class="page-item @if ($data['products']['current_page'] == $i) active @endif">
                        <button type="button" class="page-link" id="paginationProducts"
                            data-page="{{ $i }}">{{ $i }}</button>
                    </li>
                @endfor
            @endif
            <li class="page-item @if (!isset($data['products']['next_page_url'])) disabled @endif">
                <button type="button" class="page-link" id="paginationProducts"
                    data-page="{{ $data['products']['current_page'] + 1 }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </button>
            </li>
        </ul>
    </nav>
</div>
