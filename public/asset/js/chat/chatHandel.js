function fileShare() {
    let img = '';
    let id_receiver = $('#idReceiver').val();
    let id_sender = $('#idSender').val();
    let data = new FormData();
    data.append('id_receiver', id_receiver);
    data.append('id_sender', id_sender);
    const getImageMessage = callAjax('/get-image-message', 'POST', data)

    $.each(getImageMessage.msgImage, function(key, image) {
        let imgMess = image.message_img.split(',');
        $.each(imgMess, function(keySplit, vlaueSplitImage) {
            if (vlaueSplitImage != '') {
                img += `
                <div class="item-image">
                    <img src="/upload/mesage/image/` + vlaueSplitImage + `" alt="">
                </div>
                `

            }

        });
    });
    console.log(getImageMessage);

    let fileImage = `
<div class="dom-data-click " >
    <div class="title-sidebar d-flex mb-3">
        <button  onclick="backToStep()"><img src="/asset/images/back.png" alt=""></button>
        <span>File đã chia sẻ</span>
    </div>
    <div class="list-image">` + img + ` </div>
</div>
    `
    $('#sidebar-right').html(fileImage)
}


function backToStep() {
    let renderStep = `
<div class="sidebar-right">
    <div class="sb-avata">
        <img src="/asset/images/avata.png" alt="avata-content">

    </div>
    <div class="name-user">
        <span class="full-name">Phan Văn Thông </span>
    </div>
    <div class=" btn-see-profile d-flex sb-btn">
        <div class="icon-profile icon">
            <img src="/asset/images/icon-see-profile.svg" alt="">
        </div>
        <span class="see-profile">Xem profile</span>
    </div>
    <div class=" btn-share-file d-flex sb-btn">
        <div class="d-flex" onclick="fileShare()">
            <div class="icon-file icon">
                <img src="/asset/images/icon-share-file.svg" alt="">
            </div>
            <span class="share-file">File đã chia sẻ</span>
        </div>
        <div class="icon-down">
            <img src="/asset/images/icon-down.svg" alt="">
        </div>
    </div>
    <div>

    </div>
    <div class=" btn-share-link d-flex sb-btn">
        <div class="d-flex">
            <div class="icon-link icon">
                <img src="/asset/images/icon-share-link.svg" alt="">
            </div>
            <span class="share-link">Liên kết đã chia sẻ</span>
        </div>
        <div class="icon-down">
            <img src="/asset/images/icon-down.svg" alt="">
        </div>
    </div>
    <div class=" btn-add-like d-flex sb-btn">
        <div class="icon-add-like icon">
            <img src="/asset/images/icon-add-like.svg" alt="">
        </div>
        <span class="add-like">Thêm vào yêu thích</span>
    </div>
    <div class=" btn-del-chat d-flex sb-btn">
        <div class="icon-del-chat icon">
            <img src="/asset/images/icon-del-chat.svg" alt="">
        </div>
        <span class="del-chat">Xóa đoạn chat</span>
    </div>
</div>
    `
    $('#sidebar-right').html(renderStep)
}


function callMessageImage(id_receiver) {
    let data = new FormData();
    let result = [];
    data.append('id_receiver', id_receiver);
    const getImageMessage = callAjax('/get-image-message', 'POST', data)

    $.each(getImageMessage.msgImage, function(key, image) {
        let imgMess = image.message_img.split(',');
        $.each(imgMess, function(keySplit, vlaueSplitImage) {
            result.push(vlaueSplitImage)
        });
    });
    return result;
}


function showImageMessaeg(imageActive, id_recieder) {

    $('.popup-slick').removeClass('d-none')
    let html = ``;
    let dataImageMessage = callMessageImage(id_recieder);
    $.each(dataImageMessage, function(indexInArray, valueOfElement) {
        // if (imageActive == valueOfElement) {
        //     html += `
        // <div class="item-slick slick-active">
        //     <img src="/upload/mesage/image/` + valueOfElement + `" alt="">
        // </div>`;
        // } else {
        if (valueOfElement != '') {
            html += `
        <div class="item-slick ">
            <img src="/upload/mesage/image/` + valueOfElement + `" alt="">
        </div>`;
        }
    });
    console.log(html);
    $('.image-main').html(html);

    $('.image-main').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });
}

function closePpImage() {

    $('.popup-slick').addClass('d-none');
    // $('.image-main').html('');
}