@extends('layouts.dynamic')
@section('container')
    @php
        function cutDesc($string, $length = 100)
        {
            if (strlen($string) <= $length) {
                return $string;
            } else {
                $pos = strrpos(substr($string, 0, $length), ' ');
                return substr($string, 0, $pos) . '...';
            }
        }
    @endphp
    <section class="py-3 py-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            <img class="outlet_detail_banner mt-3" style="width:100%;" src="{{ $data['outlet']['outlet_image_cover'] }}"
                alt="">
            <div class="outlet_detail_desc mt-3">
                <h2>{{ $data['outlet']['outlet_name'] ?? '' }}</h2>
                @if ($data['outlet']['product'] != null)
                    <h5>{{ preg_replace('/[^0-9]/', '', $data['outlet']['product'] ?? '') }} Product terjual </h5>
                @endif
                <p>{{ $data['outlet']['outlet_description'] ?? '' }}</p>
                @if ($data['outlet']['outlet_is_closed'] == 0)
                    <div class="alert alert-primary border-0 rounded-0 p-2 fw-bold fs-5" style="width: 64px" role="alert">
                        Buka
                    </div>
                @else
                    <div class="alert alert-danger border-0 rounded-0 p-2 fw-bold fs-5" style="width: 72px" role="alert">
                        Tutup
                    </div>
                @endif
            </div>

            @if (!empty($data['outlet']['product_newest']))
                <h4 class="text-gray-700 fs-4 fw-bold mt-3 mb-0">Terdekat</h4>
                @foreach ($data['outlet']['product_newest'] ?? [] as $key => $product_newest)
                    @if ($key != 0)
                        <hr>
                    @endif
                    <div class="mt-3 outlet_detail_items">
                        <a href="{{ url('product') . '/' . base64_encode($product_newest['id_product']) ?? '' }}"
                            class="outlet_detail_items_image">
                            <img class="rounded-3" src="{{ $product_newest['image'] ?? '' }}" alt="">
                        </a>
                        <div class="outlet_detail_items_desc">
                            <a class="fs-5"
                                href="{{ url('product') . '/' . base64_encode($product_newest['id_product']) ?? '' }}">{{ $product_newest['product_name'] ?? '' }}</a>
                            <div class="d-flex">
                                @for ($i = 0; $i < $product_newest['total_rating']; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - $product_newest['total_rating']; $i++)
                                    <i class="fa-solid fa-star text-dark"></i>
                                @endfor
                            </div>
                            <h6>{{ $product_newest['sold'] ?? '' }}</h6>
                            <h5>Rp {{ number_format($product_newest['product_price'], 0, ',', '.') ?? '' }}</h5>
                            <p>{{ cutDesc($product_newest['product_description']) ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            @endif

            @if (!empty($data['outlet']['product_best_seller']))
                <hr>
                <h4 class="text-gray-700 fs-4 fw-bold mt-3 mb-0">Best Seller</h4>
                @foreach ($data['outlet']['product_best_seller'] ?? [] as $key => $product_best_seller)
                    @if ($key != 0)
                        <hr>
                    @endif
                    <div class="mt-3 outlet_detail_items">
                        <a href="" class="outlet_detail_items_image">
                            <img src="{{ $product_best_seller['image'] ?? '' }}" alt="">
                        </a>
                        <div class="outlet_detail_items_desc">
                            <a class="fs-5"
                                href="{{ url('product') . '/' . base64_encode($product_best_seller['id_product']) ?? '' }}">{{ $product_best_seller['product_name'] ?? '' }}</a>
                            <div class="d-flex">
                                @for ($i = 0; $i < $product_best_seller['total_rating']; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - $product_best_seller['total_rating']; $i++)
                                    <i class="fa-solid fa-star text-dark"></i>
                                @endfor
                            </div>
                            <h6>{{ $product_best_seller['sold'] ?? '' }}</h6>
                            <h5>Rp {{ number_format($product_best_seller['product_price'], 0, ',', '.') ?? '' }}</h5>
                            <p>{{ cutDesc($product_best_seller['product_description']) ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection
