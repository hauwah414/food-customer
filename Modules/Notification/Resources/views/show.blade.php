@extends('layouts.dynamic')
@section('container')
    <section class="py-3 py-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="text-blue mb-0 mb-3">{{ $data['notification']['title'] ?? '' }}</h4>
                    <h6>Tanggal : {{ substr($data['notification']['created_at'], 0, 10) }}</h6>
                    <h6 class="mb-2">Jam
                        : {{ substr($data['notification']['created_at'], 11) }} </h6>
                    <p>Deskripsi : {!! $data['notification']['description'] ?? '' !!}</p>
                    <div class="text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">KEMBALI</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
