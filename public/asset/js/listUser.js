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

function addMember() {
    let htmlUser = '';
    let users = callAjax('/get-all-user', 'POST', []);
    $.each(users, function(indexInArray, valueOfElement) {
        htmlUser += `
        <div class="item-member">
            <div class="img-member">
                <img src="/asset/images/avata.png" alt="">
            </div>
            <div class="info-member">
                <label for="selec-member-` + valueOfElement.id + `">
                    <span class="name">` + valueOfElement.name + `</span>
                </label>
                <input type="checkbox" id="selec-member-` + valueOfElement.id + `" class="select-member" value="` + valueOfElement.id + `">
            </div>
        </div>`

    });

    let htmlRender = `
    <div class="wrap-pp-group-member">
    
        <div class="title-popup-add-member">
            <h4>Thêm thành viên </h4>
            <span class="close-pp-member" onclick="closePpAddMember()"><i class="fa-solid fa-x"></i></span>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Tên Nhóm</span>
            </div>
        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" id='nameGroup'>
        </div>

        <div class="list-member">` + htmlUser + `</div>
        <button type="button" class="btn btn-primary" onclick="addGroup()">Thêm Nhóm </button>
    </div>

    `
    $('.popup-group-member').html(htmlRender)
    $('.popup-group-member').addClass('d-block')
}

function closePpAddMember() {
    $('.popup-group-member').removeClass('d-block')
}
$(document).on('keydown', '.wrap-pp-group-member', function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) {
        addGroup()
    }
});

function addGroup() {
    let member = [];
    $('input.select-member:checked').each(function() {
        let id = $(this).val();
        member.push(id);
    });
    if (member.length == 0) {
        alert('Bạn phải chọn thành viên trong nhóm');
        return false
    }
    let nameGroup = $('#nameGroup').val();
    if (nameGroup == '') {
        alert('Không được bỏ trống tên nhóm ');
        return false;
    }
    let data = new FormData();
    data.append('member', member.toString())
    data.append('nameGroup', nameGroup)
    let group = callAjax('/add-member-to-group', 'POST', data);
    console.log(group);
    if (group.rs) {
        window.location.reload();
    } else {
        alert('xảy ra lỗi ');
    }
}