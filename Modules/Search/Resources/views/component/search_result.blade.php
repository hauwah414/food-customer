@if (count($data['search']['data']) >= 1)
    @foreach ($data['search']['data'] ?? [] as $key => $itemSearch)
        @if ($key >= 1)
        <hr>
        @endif
        <h5 class="@if ($key >= 1) mt-md-4 @endif">{{ $itemSearch['outlet_name'] ?? '' }}</h5>
        <div class="row @if ($key >= 1) mt-3 @endif">
            @foreach ($itemSearch['products'] ?? [] as $key => $itemProduct)
                @if ($key == '0')
                    <div class="col-lg-6">
                    @elseif($key == '1')
                        <div class="col-lg-6 mt-3 mt-lg-0">
                        @elseif($key >= '2')
                            <div class="col-lg-6 mt-3">
                @endif
                <div class="card card-body" style="border: 1px solid #013880; height:100%">
                    <div class="row">
                        <div class="col-4">
                            <img class="rounded" width="100%" height="auto" style="aspect-ratio:1/1; object-fit:cover;"
                                src="{{ $itemProduct['image'] ?? '' }}" alt="{{ $itemProduct['product_name'] ?? '' }}">
                        </div>
                        <div class="col-8">
                            <div class="d-flex flex-row justify-content-between">
                            </div>
                            <a href="{{ url('/product/' . base64_encode($itemProduct['id_product'] ?? '')) }}"
                                class="fw-bold text-dark fs-5"
                                style="text-decoration: none;">{{ $itemProduct['product_name'] ?? '' }}</a>
                            <h5 class="mb-0">Rp
                                {{ $itemProduct['product_price'] ?? '' }}
                            </h5>
                            <h5 class="text-secondary fs-6">
                                Terjual {{ $itemProduct['sold'] ?? '' }}
                            </h5>
                            {{-- <h6 class="mb-0">Vendor : {{ $itemSearch['outlet_name'] ?? '' }}</h6> --}}
                            <p class='d-md-none'>
                                {{ substr($itemProduct['product_description'], 0, 50) }}...
                            </p>
                            <p class='d-none d-md-block'>
                                {{ substr($itemProduct['product_description'], 0, 40) }}...
                            </p>
                            <a href="{{ url('/product/' . base64_encode($itemProduct['id_product'] ?? '')) }}"
                                class="btn btn-warning px-4 fw-medium">
                                Lihat</a>
                        </div>
                    </div>
                </div>
        </div>
    @endforeach
    </div>
@endforeach
@if (isset($data['search']))
    <div class="pagination_ py-5">
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item @if (!isset($data['search']['prev_page_url'])) disabled @endif ">
                    <button type="button" class="page-link" id="paginationSearch"
                        data-page="{{ $data['search']['current_page'] - 1 }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </button>
                </li>
                @if ($data['search']['last_page'] >= 5)
                    @if ($data['search']['last_page'] - $data['search']['current_page'] >= 3)
                        <li class="page-item  active">
                            <button type="button" class="page-link" id="paginationSearch"
                                data-page="{{ $data['search']['current_page'] }}">{{ $data['search']['current_page'] }}</button>
                        </li>
                    @elseif ($data['search']['last_page'] - $data['search']['current_page'] <= 3)
                        <li class="page-item">
                            <button type="button" class="page-link" id="paginationSearch" data-page="1">1</button>
                        </li>
                    @endif
                    @php
                        $lastPage = $data['search']['last_page'];
                        $currentPage = $data['search']['current_page'];
                        $maxPagesToShow = 3;
                        $startPage = $currentPage + 1;
                        if ($startPage + $maxPagesToShow > $lastPage) {
                            $startPage = max($lastPage - $maxPagesToShow + 1, 1);
                        }
                    @endphp
                    @for ($i = $startPage; $i <= min($startPage + $maxPagesToShow - 1, $lastPage); $i++)
                        <li class="page-item @if ($currentPage == $i) active @endif">
                            <button type="button" class="page-link" id="paginationSearch"
                                data-page="{{ $i }}">{{ $i }}</button>
                        </li>
                    @endfor
                @else
                    @for ($i = 1; $i <= $data['search']['last_page']; $i++)
                        <li class="page-item @if ($data['search']['current_page'] == $i) active @endif">
                            <button type="button" class="page-link" id="paginationSearch"
                                data-page="{{ $i }}">{{ $i }}</button>
                        </li>
                    @endfor
                @endif
                <li class="page-item @if (!isset($data['search']['next_page_url'])) disabled @endif">
                    <button type="button" class="page-link" id="paginationSearch"
                        data-page="{{ $data['search']['current_page'] + 1 }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
@endif
@else
<h5 class="text-danger text-center">
    Pencarian tidak ditemukan
</h5>
@endif
