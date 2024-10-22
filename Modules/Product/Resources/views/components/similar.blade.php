@foreach ($similar?? [] as $itemSimilar)
    <section class="main_menu">
        <div class="container">
            <h2>{{ $itemMainMenu['title'] ?? '' }}</h2>
            <div class="row">
                @foreach ($itemMainMenu['items'] ?? [] as $itemMenu)
                    <div class="col-md-6 col-xl-3 mt-3">
                        <a href="{{ $itemMenu['link'] ?? '' }}" class="card card_two">
                            <div class="card-body">
                                <img class="img-product" src="{{ $itemMenu['image'] ?? '' }}" alt="">
                                <div class="text_head text_head_main">
                                    <h5>{{ $itemMenu['product'] ?? '' }}</h5>
                                    <h5 class="mt-3 mt-md-0 ms-md-2">{{ $itemMenu['price'] ?? '' }}</h5>
                                </div>
                                <p>{{ $itemMenu['seller'] ?? '' }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endforeach
