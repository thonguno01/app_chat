var id = document.getElementById('authId').value;
if (id != '') {
    var socket = io('ws://localhost:6001', {
        transports: ['websocket']
    });
    // on là lắng nghe 
    // emit là gửi
    socket.on('connect', function() {
        socket.emit('user_connected', id);
    });

    socket.on('updateUserStatus', (data) => {
        console.log(data);
        $.each(data, function(key, val) {
            if (val !== null && val !== 0) {
                let statusUser = $('#statusUserOnOff-' + key).html('<i class="fa-solid fa-circle status-user-on"></i>');
                let statusChatUser = $('.statusOnOffUser-' + key).html('<i class="fa-solid fa-circle text-success  "></i>');
                let textStatusUser = $('#textStatusUser-' + key).text('Đang hoạt động ');
            } else {
                let statusUser = $('#statusUserOnOff-' + key).html('<i class="fa-solid fa-circle status-user-off"></i>');
            }
        });
    });
    socket.on('sendMessage', function(msg) {
        if (msg.message.receider_id == id) {
            let domMessSideBar = '';
            if (msg.message.content != '' && msg.message.contentImage == '') {
                domMessSideBar = msg.message.content
            } else if (msg.message.content == '' && msg.message.contentImage != '') {
                domMessSideBar = 'Đã nhận 1 ảnh';
            } else if (msg.message.content != '' && msg.message.contentImage != '') {
                domMessSideBar = 'Đã nhận 1 ảnh và 1 tin nhắn'
            }
            var domMessageToListUser = $('.dom-message-socket-' + msg.message.sender_id);
            var htmlNewMessageSidebar = `
            <span class="message text-danger">` + domMessSideBar + `  </span>
            `;
            domMessageToListUser.html(htmlNewMessageSidebar);
        }
    });
}