$('.upload1').click(function(){
    $('#thumb_upload1').click();
})
//文件上传
var opts = {
    url: "/image/upthumb",
    type: "POST",
    success: function (result, status, xhr) {
        if(result.status == "0") {
            alert(result.info);
            return false;
        }
        $('input[name=gif]').val(result.info);
        $("#img_show_1").show();
        $("#img_show_1").attr('src', result.info);

    },
    error: function (result, status, errorThrown) {
        alert('文件上传失败');
    }
}
$('#thumb_upload1').fileUpload(opts);

$('.upload2').click(function(){
    $('#thumb_upload2').click();
})
//文件上传
var opts = {
    url: "/image/upthumb",
    type: "POST",
    success: function (result, status, xhr) {
        if(result.status == "0") {
            alert(result.info);
            return false;
        }
        $('input[name=img]').val(result.info);
        $("#img_show_2").show();
        $("#img_show_2").attr('src', result.info);

    },
    error: function (result, status, errorThrown) {
        alert('文件上传失败');
    }
}
$('#thumb_upload2').fileUpload(opts);