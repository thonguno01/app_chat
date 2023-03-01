var fileImagePaste = []


var id_recieder = $('#id_recieder').val();
var id_sender = $('#id_sender').val();
// 
const myTimeout = setTimeout(() => {
    document.querySelectorAll('#chat .get-msg-chat:last-child')[0].scrollIntoView({ behavior: "smooth" });
}, 500);
var socket = io('ws://localhost:6001', {
    transports: ['websocket']
});

socket.on('sendMessage', function(msg) {
    console.log(msg);
    var domMessageToListUser = $('.dom-message-socket-' + id_recieder);
    console.log('.dom-message-socket-' + id_recieder);

    if (msg.message.sender_id == id_recieder) {
        let messageReciver = sendMessgaeReceiver(msg)
        console.log(messageReciver);
        var htmlNewMessageSidebar = `
        <span class="message text-dark">` + messageReciver.domSidebar + `  </span>
        `
        $('#chat').append(messageReciver.domMessage);
        domMessageToListUser.html(htmlNewMessageSidebar);
    }
    let boxChat1 = document.querySelectorAll('#chat .get-msg-chat:last-child');
    boxChat1[0].scrollIntoView();
});

var textScreen = 0
document.onpaste = function(pasteEvent) {
    let html = '';
    var item = pasteEvent.clipboardData.items[0];
    if (item.type.indexOf("image") === 0) {
        let randomNameFile = randomStrGenerator(20) + '.png';
        const myFile = new File([item.getAsFile()], randomNameFile, {
            type: 'text/plain',
            lastModified: new Date(),
        });
        fileImagePaste.push(myFile);

        $('.paste-image').removeClass('d-none');
        // item.getAsFile().name = 'helo.png';
        // var blob = URL.createObjectURL(item.getAsFile());
        var blob = URL.createObjectURL(myFile);

        html += `
            <div class="item"> 
            <input type="hidden" class="fileNamePaste" name="fileName" value="` + randomNameFile + `">
            <img src="` + blob + `" alt="">
            <strong class="close" onclick="removeImg(this)" ><i class="fa-regular fa-circle-xmark text-danger"></i></strong>
        </div>`;
        // console.log(html);
        $('#paste').append(html);
        document.querySelectorAll('#chat .get-msg-chat:last-child')[0].scrollIntoView();

        textScreen++;
    } else {
        item.getAsString(function(data) {
            let inputMesage = $("#content_chat").val()
            $("#content_chat").val(inputMesage + data)
        });
    }
    $("#content_chat").focus()
}

function removeImg(e) {
    let remove = $(e).parent();
    console.log(remove.remove());
    let countItemImg = $('.item');
    if (countItemImg.length == 0) {
        $('.paste-image').addClass('d-none')
    }
}


$(document).on('keydown', 'input#content_chat', function(e) {

    var code = (e.keyCode ? e.keyCode : e.which);


    if (code == 13) {
        sendMessage()
    }
});


function sendMessage() {
    let saveFileNameImage = [];
    let fileImagePasteChoose = [];
    let message = $('#content_chat').val();
    $('.fileNamePaste').each(function() {
        let input = $(this);
        saveFileNameImage.push(input.val())
    });
    // console.log(saveFileNameImage);

    $.each(saveFileNameImage, function(keyName, name) {
        $.each(fileImagePaste, function(keyFile, file) {
            if (name == file.name) {
                fileImagePasteChoose.push(file);
            }
        });
    });
    if (message.trim() == '') {
        if (fileImagePasteChoose.length == 0) {
            return false;
        }
    }
    console.log(fileImagePasteChoose);
    let id_sender = $('#id_sender').val().trim();
    let id_receiver = $('#id_recieder').val().trim();
    let data = new FormData();
    data.append('message', message);
    data.append('id_sender', id_sender);
    data.append('id_receiver', id_receiver);
    if (fileImagePasteChoose.length != 0) {
        for (var i = 0; i < fileImagePasteChoose.length; i++) {
            data.append('messageImg[]', fileImagePasteChoose[i]);
        }

    }
    // for (const pair of data.entries()) {
    //     console.log(` ${pair[1]}`);
    // }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    $.ajax({
        url: '/chat/sendMessage',
        type: 'post',
        data: data,
        async: false,
        cache: false,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(respose) {
            $('.paste-image').addClass('d-none')
            $('#paste').html('');

            sendMessageSender(respose)
        }
    });
    console.log($('#content_chat').val(''));
}

function sendMessageSender(message) {
    console.log(message);
    var html_message = '';
    let domMessSideBar = '';
    var sidebarUser = $('.dom-message-socket-' + message.id_receiver);
    if (message.message != '' && message.messageImage == '') {
        domMessSideBar = message.message
        html_message = `
        <div class="reply-text-chat get-msg-chat">
        <div class="client-chat">
            <div class="w-100">
                <div class="message-client">
                    <button class="option-message" id="option_message">
                        <img src="/asset/images/option-message.svg"   onerror="this.src='http://localhost:8181/asset/images/option-message.svg';" 
                            alt="Tùy chon chat">
                    </button>
                    <div class="content-chat bg-primary">
                        <span class="text-light">` + message.message + `
                        </span>
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>
    `;
    } else if (message.message == '' && message.messageImage != '') {
        domMessSideBar = 'Đã gửi 1 ảnh';
        let imgMess = message.messageImage.split(',');
        let domImage = '';
        $.each(imgMess, function(keyMess, messImg) {
            domImage += `<img src="/upload/mesage/image/` + messImg + `">
            `
        });
        html_message = `
        <div class="reply-text-chat get-msg-chat">
            <div class="client-chat">
                <div class="w-100">
                    <div class="item-message-img">` + domImage + `</div>
                </div>
            </div>
        </div>
        `;
    } else {
        domMessSideBar = 'Đã gửi 1 ảnh và 1 tin nhắn';
        domMessSideBar = 'Đã gửi 1 ảnh';
        let imgMess = message.messageImage.split(',');
        let domImage = '';
        $.each(imgMess, function(keyMess, messImg) {
            domImage += `<img src="/upload/mesage/image/` + messImg + `">
            `
        });
        html_message = `
        <div class="reply-text-chat get-msg-chat">
            <div class="client-chat">
                <div class="w-100">
                    <div class="item-message-img">` + domImage + `</div>
                    <div class="message-client">
                        <button class="option-message" id="option_message">
                            <img src="/asset/images/option-message.svg"
                                alt="Tùy chon chat"  onerror="this.src='http://localhost:8181/asset/images/option-message.svg';" >
                        </button>
                        <div class="content-chat bg-primary">
                        <span class="text-light">` + message.message + `</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        `;
    }
    var htmlNewMessageSidebar = `
<span class="message text-dark">` + domMessSideBar + `  </span>
`;
    $('#chat').append(html_message);

    sidebarUser.html(htmlNewMessageSidebar);
    let boxChat1 = document.querySelectorAll('#chat .get-msg-chat:last-child');
    boxChat1[0].scrollIntoView();
}

function upFile(event) {
    var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
    var file_data = $('#up_photo').prop('files')[0];

    if (file_data != undefined) {
        let html = '';
        let checkImagePaste = $('.paste-image').attr('class')
            // console.log(checkImagePaste);
        var type = file_data.type;
        var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/jfif", "image/PNG"];
        // return false
        if (type == match[0] || type == match[1] || type == match[2] || type == match[3] || type == match[4] || type == match[5]) {
            file_data = new File([file_data], ChangeToSlug(file_data.name), {
                type: 'text/plain',
                lastModified: new Date(),
            });
            fileImagePaste.push(file_data);

            if (file_data.size <= 8000000) {
                html += `
                <div class="item"> <img src="` + URL.createObjectURL(event.target.files[0]) + `" alt="">
                <input type="hidden" class="fileNamePaste" name="fileName" value="` + ChangeToSlug(file_data.name) + `">
                <strong class="close" onclick="removeImg(this)" ><i class="fa-regular fa-circle-xmark text-danger"></i></strong>
            </div>`;
                // console.log(html);
                $('#paste').append(html);

                let countItemImg = $('.item');
                if (countItemImg.length != 0) {
                    $('.paste-image').removeClass('d-none')
                    document.querySelectorAll('#chat .get-msg-chat:last-child')[0].scrollIntoView();


                }
            } else {
                alert('Bạn chỉ được upload file dưới 8MB');
            }
        } else {
            alert('Bạn chỉ được upload file ảnh');
            return false;
        }
    }
}

function sendMessgaeReceiver(message) {
    let domMessSideBar = '';
    let html_message = '';
    if (message.message.content != '' && message.message.contentImage == '') {
        domMessSideBar = message.message.content
        html_message = `
        <div class="text-chat get-msg-chat">
            <div class="client-chat">
                <div class="img-client">
                    <img src="/asset/images/avata.png" alt="ảnh người chat"  onerror="this.src='http://localhost:8181/asset/images/avata.png';">
                </div>
                <div class="message-client">
                    <div class="content-chat">
                        <span>` + message.message.content + ` </span>
                    </div>
                    <button class="option-message" id="option_message">
                        <img src="/asset/images" alt="Tùy chon chat"  onerror="this.src='http://localhost:8181/asset/images/option-message.svg';" >
                    </button>
        
                </div>
            </div>
        </div>
        `;
    } else if (message.message.content == '' && message.message.contentImage != '') {
        domMessSideBar = 'Đã nhận 1 ảnh';
        let imgMess = message.message.contentImage.split(',');
        let domImage = '';
        $.each(imgMess, function(keyMess, messImg) {
            domImage += `<img src="/upload/mesage/image/` + messImg + `">
            `
        });
        html_message = `
        <div class="text-chat get-msg-chat">
        <div class="client-chat ">
            <div class="img-client">
                <img src="/asset/images/avata.png" alt="ảnh người chat"
                    onerror="this.src='http://localhost:8181/asset/images/avata.png';">
            </div>
            <div class="message-client " style="flex-direction: column">
                <div class="message-image">
                    <div class="item-message-img">` + domImage + `</div>
                </div>
            </div>
        </div>
    </div>
        `;
    } else if (message.message.content != '' && message.message.contentImage != '') {
        let imgMess = message.message.contentImage.split(',');
        let domImage = '';
        $.each(imgMess, function(keyMess, messImg) {
            domImage += `<img src="/upload/mesage/image/` + messImg + `">
            `
        });
        domMessSideBar = 'Đã nhận 1 ảnh và 1 tin nhắn'
        html_message = `
        <div class="text-chat get-msg-chat">
            <div class="client-chat ">
                <div class="img-client">
                    <img src="/asset/images/avata.png" onerror="this.src='http://localhost:8181/asset/images/avata.png';" alt="ảnh người chat">
                </div>
                <div class="message-client " style="flex-direction: column">
                    <div class="item-message-img">` + domImage + `</div>
                    <div class="w-100 d-flex"  style="flex-direction: row">
                        <div class="content-chat">
                        <span>` + message.message.content + ` </span>
                        </div>
                        <button class="option-message" id="option_message">
                            <img src="/asset/images" alt="Tùy chon chat"  onerror="this.src='http://localhost:8181/asset/images/option-message.svg';" >
                        </button>
        
                </div>
                </div>
            </div>
        </div>
            `;
    }
    return {
        domMessage: html_message,
        domSidebar: domMessSideBar
    }
}