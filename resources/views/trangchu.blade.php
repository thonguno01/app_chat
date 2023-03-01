@extends('layouts.app')
@section('title', 'Trang Chủ ')
@section('content')
    <div class="w-100">
        <h1 class="text-center">Trang chủ website</h1>
        <h5 class="text-center"><a href="{{ route('home.chat') }}">Click để nhắn tin</a></h5>

    </div>

@endsection


@push('js')
    <script src="{{ asset('asset/js/jsGlobal/event.js') }}"></script>
@endpush
