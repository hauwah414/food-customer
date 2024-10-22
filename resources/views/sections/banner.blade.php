<section class="banner">
    <div class="container-md">
        <div id="carouselBanner" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($data['banners'] as $itemBanner)
                    <div class="carousel-item {{ $itemBanner['class'] }}"
                        data-bs-interval="{{ $itemBanner['interval'] }}">
                        <img src="{{ $itemBanner['img'] }}" class="d-block w-100" alt="">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
