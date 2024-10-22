@extends('layouts.dynamic')
@section('container')
    <section class="py-3 py-lg-5">
        <div class="container">
            @include('sections.breadcrumb')
            @if ($data['notification']['total'] != '0')
                <div class="mt-3">
                    @foreach ($data['notification']['data'] ?? [] as $key => $itemNotification)
                        <a class=" @if ($itemNotification['status'] == 1) text-blue fw-bold @else text-dark @endif text-decoration-none fs-5"
                            href="{{ url('notification/detail/' . base64_encode($itemNotification['id_notification'])) }}">{{ $itemNotification['title'] ?? '' }}</a>
                        {{-- <p> --}}
                            {!! $itemNotification['description'] ?? '' !!}
                        {{-- </p> --}}
                        <hr>
                    @endforeach
                </div>
            @else 
                <div class="alert alert-warning mt-3" role="alert">
                    Anda tidak memiliki notifikasi </div>
            @endif
            @if ($data['notification']['total'] != '0')
                <div class="pagination_ mt-5 mt-0 py-0">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item @if (!isset($data['notification']['prev_page_url'])) disabled @endif ">
                                <a class="page-link"
                                    href="{{ url('notification/page=' . $data['notification']['current_page'] - 1) }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @if ($data['notification']['last_page'] >= 5)
                                @if ($data['notification']['last_page'] - $data['notification']['current_page'] >= 3)
                                    <li class="page-item  active">
                                        <a class="page-link"
                                            href="{{ url('notification/page=' . $data['notification']['current_page']) }}">{{ $data['notification']['current_page'] }}</a>
                                    </li>
                                @elseif ($data['notification']['last_page'] - $data['notification']['current_page'] <= 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ url('notification/page=1') }}">1</a>
                                    </li>
                                @endif
                                @php
                                    $lastPage = $data['notification']['last_page'];
                                    $currentPage = $data['notification']['current_page'];
                                    $maxPagesToShow = 3;
                                    $startPage = $currentPage + 1;
                                    if ($startPage + $maxPagesToShow > $lastPage) {
                                        $startPage = max($lastPage - $maxPagesToShow + 1, 1);
                                    }
                                @endphp
                                @for ($i = $startPage; $i <= min($startPage + $maxPagesToShow - 1, $lastPage); $i++)
                                    <li class="page-item @if ($currentPage == $i) active @endif">
                                        <a class="page-link"
                                            href="{{ url('notification/page=' . $i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            @else
                                @for ($i = 1; $i <= $data['notification']['last_page']; $i++)
                                    <li class="page-item @if ($data['notification']['current_page'] == $i) active @endif">
                                        <a class="page-link"
                                            href="{{ url('notification/page=' . $i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                            @endif
                            <li class="page-item @if (!isset($data['notification']['next_page_url'])) disabled @endif">
                                <a class="page-link"
                                    href="{{ url('notification/page=' . $data['notification']['current_page'] + 1) }}"
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
