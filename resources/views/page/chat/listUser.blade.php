<?php
$listUsers = ChatHelper::callUser();
$group = ChatHelper::callGroup();
?>
<div class="user-chat">
    <div class="information">
        <div class="avata-me">
            <img src="{{ asset('asset/images/avata.png') }}" alt="">
        </div>
        <div class="full-name">
            <span>{{ session()->get('name') }}</span>
        </div>
    </div>
    <div class="seach-user">
        <div class="form-search">
            <input type="text" class="inputSearch" id="inputSearch" name="search-user">
            <button type="button" class="icon-search" id="searchUser" onclick="searchUser()">
                <img src="{{ asset('asset/images/icon-search.svg') }}" alt="icon-search">
            </button>
        </div>

    </div>
    <div class="menu-content ">
        <div class="all menu-active text-menu">
            <span> All</span>
        </div>

        <div class="user-like text-menu">
            <span>Yêu thích</span>
        </div>

        <div class="save-user text-menu">
            <span>Lưu trữu</span>
        </div>
        <div class="create-group text-menu">
            <span onclick="addMember()">Tạo nhóm</span>
        </div>
    </div>
    <div class="list-user">
        @foreach ($listUsers as $key => $user)
            <?php
            $lastMessage = ChatHelper::getLastMessage($user->id);
            $lastMessageContent = count($lastMessage) == 0 ? '' : $lastMessage[count($lastMessage) - 1]->message;
            $lastMessageImage = count($lastMessage) == 0 ? '' : $lastMessage[count($lastMessage) - 1]->message_img;
            $lastMessageStatus = count($lastMessage) == 0 ? '' : $lastMessage[count($lastMessage) - 1]->seen_status;
            
            ?>
            <div class="item-user mb-2">
                <div class="user-avata">
                    <img src="{{ asset('asset/images/avata.png') }}" alt="avata người dùng" onclick="showImage()">
                    <span id="statusUserOnOff-{{ $user->id }}"><i
                            class="fa-solid fa-circle status-user-off"></i></span>
                </div>
                <div class="user-name">
                    <a href="/chat/{{ $user->id }}" class="name">{{ $user->name }} </a>
                    <div class="message-user  dom-message-socket-{{ $user->id }}">
                        <?php
                            if(count($lastMessage ) != 0){
                            ?>
                        @if ($lastMessageContent != '' && $lastMessageImage == null)
                            <span
                                class="message <?= $lastMessageStatus == 0 ? 'text-dark' : 'text-muted' ?>">{{ $lastMessageContent }}
                            </span>
                        @elseif ($lastMessageContent === '' && $lastMessageImage !== null)
                            <span class="message <?= $lastMessageStatus == 0 ? 'text-dark' : 'text-dmuted' ?>">Đã nhận
                                đươc ảnh
                            </span>
                        @elseif ($lastMessageContent !== '' && $lastMessageImage !== null)
                            <span
                                class="message <?= $lastMessageStatus == 0 ? 'text-dark' : 'text-dmuted' ?>">{{ $lastMessageContent }}
                            </span>
                        @endif
                        {{-- <span class="time-chat">20 phút</span> --}}
                        <?php }?>
                    </div>
                </div>
                <button type="button" class="icon-option"><img src="{{ asset('asset/images/icon-option.svg') }}"
                        alt=""></button>
            </div>
            {{-- @endif --}}
        @endforeach
    </div>
</div>
@push('js')
    <script src="{{ asset('asset/js/jsGlobal/event.js') }}"></script>
    <script src="{{ asset('asset/js/listUser.js') }}"></script>
@endpush
