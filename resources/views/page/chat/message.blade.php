@extends('layouts.app')
@section('title', 'Tin nhắn')
@section('content')
    <div id="wrap-chat">
        <div class="chat">
            @include('page.chat.listUser')

            @include('page.chat.contentChat')
        </div>
    </div>
@endsection
@section('sidebarRight')
    @include('includes.sidebarRight')
@endsection
