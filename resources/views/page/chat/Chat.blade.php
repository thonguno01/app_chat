@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('asset/css/chatIndex.css') }}">
@endpush
@section('title', 'Trang chủ')

@section('content')
    <div id="wrap-chat">
        <div class="chat">
            @include('page.chat.listUser')

            <div class="message-chat h-100">
                <h1 class="text-center w-100 d-flex justify-content-center   align-items-center">Chào mừng bạn đến với phần
                    chat</h1>
            </div>

        </div>
    </div>
@endsection
{{-- @section('sidebarRight')
    @include('includes.sidebarRight') 
@endsection --}}
