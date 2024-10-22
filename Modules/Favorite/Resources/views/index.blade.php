@extends('layouts.dynamic')
@section('container')
    @php
        function cutTitle($string, $length = 30)
        {
            if (strlen($string) <= $length) {
                return $string;
            } else {
                $pos = strrpos(substr($string, 0, $length), ' ');
                return substr($string, 0, $pos) . '...';
            }
        }
    @endphp
    <section class="pt-3 pt-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            @if ($data['favorite']['total'] != '0')
                <div class="row">
                    @foreach ($data['favorite']['data'] ?? [] as $key => $itemProduct)
                        <div class="col-sm-6 col-lg-3 mt-3 mt-md-4">
                            <div class="card card_product shadow-sm">
                                <div class="card-body">
                                    <img src="{{ $itemProduct['image'] ?? '' }}"
                                        alt="{{ $itemProduct['product_name'] ?? '' }}"
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
                                        <span
                                            class="badge bg-light text-dark me-3">{{ $itemProduct['text_preorder'] }}</span>
                                        <span class="badge bg-light text-dark ">{{ $itemProduct['text_min_order'] }}</span>
                                    </div>
                                    <a href="{{ url('/product/' . base64_encode($itemProduct['id_product'])) }}"
                                        class="btn btn-warning">
                                        Lihat</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning mt-3" role="alert">
                    Anda belum memiliki menu favorite </div>
            @endif
            @if ($data['favorite']['total'] != '0')
                <div class="pagination_ py-5">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item @if (!isset($data['favorite']['prev_page_url'])) disabled @endif ">
                                <a class="page-link"
                                    href="{{ url('favorite/page=' . $data['favorite']['current_page'] - 1) }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @if ($data['favorite']['last_page'] >= 5)
                                @if ($data['favorite']['last_page'] - $data['favorite']['current_page'] >= 3)
                                    <li class="page-item  active">
                                        <a class="page-link"
                                            href="{{ url('favorite/page=' . $data['favorite']['current_page']) }}">{{ $data['favorite']['current_page'] }}</a>
                                    </li>
                                @elseif ($data['favorite']['last_page'] - $data['favorite']['current_page'] <= 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ url('favorite/page=1') }}">{{ 1 }}</a>
                                    </li>
                                @endif
                                @php
                                    $lastPage = $data['favorite']['last_page'];
                                    $currentPage = $data['favorite']['current_page'];
                                    $maxPagesToShow = 3;
                                    $startPage = $currentPage + 1;
                                    if ($startPage + $maxPagesToShow > $lastPage) {
                                        $startPage = max($lastPage - $maxPagesToShow + 1, 1);
                                    }
                                @endphp
                                @for ($i = $startPage; $i <= min($startPage + $maxPagesToShow - 1, $lastPage); $i++)
                                    <li class="page-item @if ($currentPage == $i) active @endif">
                                        <a class="page-link"
                                            href="{{ url('favorite/page=' . $i) }}">{{ $i }}</a>

                                    </li>
                                @endfor
                            @else
                                @for ($i = 1; $i <= $data['favorite']['last_page']; $i++)
                                    <li class="page-item @if ($data['favorite']['current_page'] == $i) active @endif">
                                        <a class="page-link"
                                            href="{{ url('favorite/page=' . $i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            @endif
                            <li class="page-item @if (!isset($data['favorite']['next_page_url'])) disabled @endif">
                                <a class="page-link"
                                    href="{{ url('favorite/page=' . $data['favorite']['current_page'] + 1) }}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('body').on('click', '#deleteFavorite', function() {
            let product_id = $(this).data('favorite');
            let token = $("meta[name='csrf-token']").attr("content");
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini dari list favorite!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/favorite/delete`,
                        type: "POST",
                        cache: false,
                        data: {
                            "product_id": product_id,
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            location.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
