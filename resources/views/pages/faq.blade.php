@extends('layouts.dynamic')
@section('container')
    <div class="container pt-3 pt-lg-5">
        @include('sections.breadcrumb')
        <h3 class="mb-3 fw-bold text-blue">FAQ</h3>
        <div class="accordion" id="accordionFaq">
            @foreach ($data['faq'] ?? [] as $key => $itemFaq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $key }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $key }}" aria-controls="collapse{{ $key }}">
                            {{ $itemFaq['question'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $key }}" class="accordion-collapse collapse  "
                        aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionFaq">
                        <div class="accordion-body">
                            {{ $itemFaq['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
