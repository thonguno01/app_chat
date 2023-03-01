@php
    $receiver = ChatHelper::getInforUser($receider_id);
@endphp
<input type="hidden" id="idReceiver" value="{{ $receiver->id }}">
<input type="hidden" id="idSender" value="{{ session()->get('id') }}">
<div id="sidebar-right">
    <div class="sidebar-right">
        <div class="sb-avata">
            <img src="{{ asset('asset/images/avata.png') }}" alt="avata-content">

        </div>
        <div class="name-user">
            <span class="full-name">Phan Văn Thông </span>
        </div>
        <div class=" btn-see-profile d-flex sb-btn">
            <div class="icon-profile icon">
                <img src="{{ asset('asset/images/icon-see-profile.svg') }}" alt="">
            </div>
            <span class="see-profile">Xem profile</span>
        </div>
        <div class=" btn-share-file d-flex sb-btn " onclick="fileShare()">
            <div class="d-flex">
                <div class="icon-file icon">
                    <img src="{{ asset('asset/images/icon-share-file.svg') }}" alt="">
                </div>
                <span class="share-file">File đã chia sẻ</span>
            </div>
            <div class="icon-down">
                <img src="{{ asset('asset/images/icon-down.svg') }}" alt="">
            </div>
        </div>
        <div class=" btn-share-link d-flex sb-btn">
            <div class="d-flex">
                <div class="icon-link icon">
                    <img src="{{ asset('asset/images/icon-share-link.svg') }}" alt="">
                </div>
                <span class="share-link">Liên kết đã chia sẻ</span>
            </div>
            <div class="icon-down">
                <img src="{{ asset('asset/images/icon-down.svg') }}" alt="">
            </div>
        </div>
        <div class=" btn-add-like d-flex sb-btn">
            <div class="icon-add-like icon">
                <img src="{{ asset('asset/images/icon-add-like.svg') }}" alt="">
            </div>
            <span class="add-like">Thêm vào yêu thích</span>
        </div>
        <div class=" btn-del-chat d-flex sb-btn">
            <div class="icon-del-chat icon">
                <img src="{{ asset('asset/images/icon-del-chat.svg') }}" alt="">
            </div>
            <span class="del-chat">Xóa đoạn chat</span>
        </div>
    </div>

</div>

@push('js')
    <script src="{{ asset('asset/js/chat/chatHandel.js') }}"></script>
@endpush
