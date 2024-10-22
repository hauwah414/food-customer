@extends('layouts.dynamic')
@section('container')
    <section class="container cart">
        @include('sections.breadcrumb')
        <h1 class="fw-bold">Keranjang</h1>
        <h5 class="text-danger">
            Keranjang Kosong
        </h5> 
    </section>
@endsection
