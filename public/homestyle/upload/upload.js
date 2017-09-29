//文件上传
$('.upload').click(function(){
    $('#thumb_upload').click();
})
var opts = {
    url: "/user/imgs",
    type: "POST",
    success: function (result, status, xhr) {
        if (result.status == "0") {
            layer.msg(result.msg);
            return false;
        }
        $("input[name='img']").val(result.medium);
        $("#img_show").attr('src', result.medium);
        $(".left_thumb").attr('src', result.medium);
    },
    error: function (result, status, errorThrown) {
        layer.msg('文件上传失败', {icon: 5});
    }
}

$('#thumb_upload').fileUpload(opts);