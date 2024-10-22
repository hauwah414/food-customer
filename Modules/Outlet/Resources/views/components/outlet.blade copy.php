<div class="row">
    @foreach ($data['outlet'] ?? [] as $key => $itemOutlet)
        <div class="col-6 col-lg-3 mt-3 mt-md-4">
            <div class="card card_product shadow-sm">
                <div class="card-body">
                    <img src="{{ $itemOutlet['outlet_image_logo_portrait'] ?? '' }}"
                        alt="{{ $itemOutlet['outlet_name'] ?? '' }}">
                    <div class="row my-3 desc_">
                        <h5 class="text-center">
                            {{ $itemOutlet['outlet_name'] ?? '' }}
                        </h5>
                    </div>
                    <a href="{{ url('/outlet/' . $itemOutlet['outlet_code']) }}" class="btn btn-warning">
                        Lihat</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
