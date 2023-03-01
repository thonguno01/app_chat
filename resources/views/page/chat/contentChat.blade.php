@push('css')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endpush
@push('js')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endpush
<?php
$personReceiver = ChatHelper::getInforUser($receider_id);
// var_dump($receider_id);
$sender_id = session()->get('id');
?>

<div class="message-chat">
    <div class="head-message d-flex">
        <div class="hdm-avata">
            <img src="{{ asset('asset/images/avata.png') }}" alt="avatar người chat ">
            <div class="status-on-off">
                <img src="{{ asset('asset/images/status-on.svg') }}" alt="trạng thái hoạt động " id="status_of_user">
            </div>
        </div>
        <div class="hdm-name-mesage ">
            <div class="hdm-name">
                <span>{{ _($personReceiver->name) }}</span>
            </div>
            <div class="hdm-status">
                <span>Đang hoạt động </span>
            </div>
        </div>
    </div>
    <div class="body-message ">
        <div class="w-100 d-flex hei" id="domMessageMe">
            <div class="w-100  overflow " id="chat">

                @foreach ($messagesOfUser as $indexOfMessage => $message)
                    @if ($message->receider_id != $personReceiver->id)
                        <div class="text-chat get-msg-chat">
                            <div class="client-chat ">


                                <div class="img-client">
                                    <img src="{{ asset('asset/images/avata.png') }}" alt="ảnh người chat">
                                </div>
                                <div class="message-client " style="flex-direction: column">
                                    @if ($message->message_img != '' || $message->message_img != null)
                                        @php
                                            $messageImg = explode(',', $message->message_img);
                                        @endphp
                                        <div class="message-image">
                                            @foreach ($messageImg as $img)
                                                <div class="item-message-img">
                                                    <img src="{{ asset('upload/mesage/image/' . $img) }}"   onclick="showImageMessaeg('{{  $img }}',{{ $receider_id }})">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($message->message != '' || $message->message != null)
                                        <div class="w-100 d-flex" style="flex-direction: row">
                                            <div class="content-chat">
                                                <span>{{ $message->message }} </span>
                                            </div>
                                            <button class="option-message" id="option_message">
                                                <img src="{{ asset('asset/images/option-message.svg') }}"
                                                    alt="Tùy chon chat">
                                            </button>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @else
                        <div class="reply-text-chat get-msg-chat">
                            <div class="client-chat">
                                <div class="w-100">
                                    @if ($message->message_img != '' || $message->message_img != null)
                                        @php
                                            $messageImg = explode(',', $message->message_img);
                                        @endphp
                                        <div class="message-image">
                                            @foreach ($messageImg as $img)
                                                <div class="item-message-img">
                                                    <img src="{{ asset('upload/mesage/image/' . $img) }}"   onclick="showImageMessaeg('{{  $img }}',{{ $receider_id }})">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($message->message != '' || $message->message != null)
                                        <div class="message-client">
                                            <button class="option-message" id="option_message">
                                                <img src="{{ asset('asset/images/option-message.svg') }}"
                                                    alt="Tùy chon chat">
                                            </button>

                                            <div class="content-chat bg-primary">
                                                <span class="text-light">{{ $message->message }}
                                                </span>
                                            </div>

                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>


            <div class="" id="last">
                <div class="paste-image d-none">
                    <div class="list-item" id="paste">

                    </div>
                </div>

            </div>
            <div class="form-chat w-100 d-flex align-items-center ">
                <div class="form w-100 ">
                    <div class="w-100 d-flex align-items-center jstify-space-betwen">
                        @csrf
                        <div class="sendInputFile ">
                            <button type="button" class="button-image"><i class="fa-solid fa-image"></i></button>
                            <input type="file" class="fileAvata" onchange="upFile(event)" id="up_photo"
                                name="avata_file">
                        </div>
                        <input type="text" name="content_chat" id="content_chat" class="inp_content_chat">
                        <input type="hidden" name="id_recieder" id="id_recieder" class=""
                            value="{{ $personReceiver->id }}">
                        <input type="hidden" name="id_sender" id="id_sender" class=""
                            value="{{ session()->get('id') }}">
                        <button type="button" id="btn_send_message" onclick="sendMessage()"><img
                                src="{{ asset('asset/images/btn-send-message.svg') }}" alt="button send mail"></button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="popup-slick d-none "  >

    <div class="slick-img">
        <div class="close-pp-img">
            <span onclick="closePpImage()"><i class="fa-solid fa-x text-dark"></i></span>
        </div>
        <div class="d-flex list-image-slick  image-main">
            
        </div>
    </div>
</div>
