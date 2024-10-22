@foreach ($data['main_menu'] ?? [] as $itemMainMenu)
    <section class="main_menu">
        <div class="container">
            <h2>{{ $itemMainMenu['title'] ?? '' }}</h2>
            <div class="row">
                @foreach ($itemMainMenu['items'] ?? [] as $itemMenu)
                    <div class="col-md-4 mt-3 mb-5 mb-lg-0">
                        <a href="{{ $itemMenu['link'] ?? '' }}" class="card">
                            <div class="card-body">
                                <img class="img-product" src="{{ $itemMenu['image'] ?? '' }}" alt="">
                                <div class="text_head">
                                    <h5>{{ $itemMenu['product'] ?? '' }}</h5>
                                    <h5>{{ $itemMenu['price'] ?? '' }}</h5>
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
