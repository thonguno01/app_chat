@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('asset/css/chatIndex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/ppCreateGroup.css') }}" />
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


@section('popup')
    <div class="popup-group-member" hidden>

    </div>
@endsection
