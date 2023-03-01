// //key code
$(document).on('keydown', 'input#inputSearch', function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
        searchUser()
    }
});

function searchUser() {
    let html = ``;
    var keySearchUser = $('#inputSearch').val();
    if (keySearchUser.trim() != '') {
        let data = new FormData();
        data.append('keySearch', keySearchUser)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        $.ajax({
            url: '/search-user',
            type: 'post',
            data: data,
            async: false,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(respose) {
                if (respose.length > 0) {
                    $.each(respose, (key, users) => {
                        html += `     <div class="item-user mb-2">
                        <div class="user-avata">
                            <img src="/asset/images/avata.png" alt="avata người dùng">
                            <span id="statusUserOnOff-` + users.id + `"><i
                                    class="fa-solid fa-circle status-user-off"></i></span>
                        </div>
                        <div class="user-name">
                            <a href="/chat/` + users.id + `" class="name">` + users.name + ` </a>
                            <div class="message-user  dom-message-socket-` + users.id + `">
                                <span
                                    class="message text-dark">` + users.lastMessage +
                            `
                                </span>
                            </div>
                        </div>
                        <button type="button" class="icon-option"><img src="/asset/images/icon-option.svg"
                                alt=""></button>
                    </div>`;
                    });
                    $('.list-user').html(html)
                } else {
                    alert('Không tìm thấy người dùng nào ');
                }
            }
        });
    }
}