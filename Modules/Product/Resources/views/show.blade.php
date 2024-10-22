@extends('layouts.dynamic')
@section('container') 
    <div class="container pt-3 pt-lg-5">
        @include('sections.breadcrumb')
        @if (!empty($data['product']['product_type'] == 'box'))
            @include('product::components.product-box')
        @else
            @include('product::components.product')
        @endif
        <hr class="mt-5 mt-md-3">
        @if ($data['product']['ratings'] != null)
            <h3 class="mb-3">Penilaian Produk</h3>
            @foreach ($data['product']['ratings'] ?? [] as $itemRatings)
                <div class="d-flex flex-row">
                    <img class="rounded-circle" style="aspect-ratio:1/1; object-fit: contain;" width="54px" height="54px"
                        src="{{ $itemRatings['user_photo'] ?? '' }}" alt="">
                    <div class="ms-3">
                        <h5 class="mb-0">{{ $itemRatings['user_name'] ?? '' }}</h5>
                        <h6>{{ $itemRatings['date'] }}</h6>
                        <div class="d-flex">
                            @for ($i = 0; $i < $itemRatings['rating_value']; $i++)
                                <i class="fa-solid fa-star" style="color:gold;"></i>
                            @endfor
                            @for ($i = 0; $i < 5 - $itemRatings['rating_value']; $i++)
                                <i class="fa-solid fa-star text-dark"></i>
                            @endfor
                        </div>
                        <p class="mt-3 mb-0">{{ $itemRatings['suggestion'] }}</p>
                        <p>
                            @foreach ($itemRatings['option_value'] as $option_value)
                                {{ $option_value }}
                            @endforeach
                        </p>
                        <div class="">
                            @foreach ($itemRatings['photos'] as $photos)
                                <img data-bs-toggle="modal" data-bs-target="#ModalPhoto" src="{{ $photos }}"
                                    style="width:80px; height:80px; object-fit:contain; aspect-ratio:1/1;" alt=""
                                    onclick="showImage('{{ $photos }}')">
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <hr class="mt-5">
        @endif
        {{-- @include('product::components.similar') --}}
    </div>


    <!-- Modal -->
    <div class="modal fade" id="ModalPhoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:transparent; border:0;">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        function showImage(imageSrc) {
            var modalBody = document.querySelector('#ModalPhoto .modal-body');
            modalBody.innerHTML = '<img src="' + imageSrc + '" style="max-width: 100%; max-height: 100%;" alt="">';
        }
    </script>
@endpush

@if (isset($data['product']['multiple_photo'][0]) && $data['product']['multiple_photo'][0] != null)
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const carouselItems = document.querySelectorAll(".carousel_items_");
                const btnNext = document.querySelector(".btn_next");
                const btnPrev = document.querySelector(".btn_prev");
                let currentIndex = 0;

                function showCarouselItem(index) {
                    carouselItems.forEach(item => {
                        item.classList.remove("active");
                    });
                    carouselItems[index].classList.add("active");
                }

                btnNext.addEventListener("click", function() {
                    currentIndex++;
                    if (currentIndex >= carouselItems.length) {
                        currentIndex = 0;
                    }
                    showCarouselItem(currentIndex);
                });

                btnPrev.addEventListener("click", function() {
                    currentIndex--;
                    if (currentIndex < 0) {
                        currentIndex = carouselItems.length - 1;
                    }
                    showCarouselItem(currentIndex);
                });
            });
        </script>
    @endpush
@endif
