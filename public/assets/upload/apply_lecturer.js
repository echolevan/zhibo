$("#apply").click(function () {
    var ok = $('input[name="ok"]').is(':checked');
    if (!$('input[name="ok"]').is(':checked')) {
        layer.msg('没有接受讲师协议！');
        return false;
    }
});


$('.upload1').click(function(){
    $('#thumb_upload1').click()
})
var opts = {
    url: "/user/common_upload",
    type: "POST",
    success: function (result, status, xhr) {
        console.log(result)
        if (result.status == "0") {
            layer.msg(result.msg);
            return false;
        }
        $("input[name='front_picture']").val(result.info);
        $("#img1").attr('src', result.info);

    },
    error: function (result, status, errorThrown) {
        layer.msg('文件上传失败', {icon: 5});
    }
}
$('#thumb_upload1').fileUpload(opts);

$('.upload2').click(function(){
    $('#thumb_upload2').click()
})
var opts2 = {
    url: "/user/common_upload",
    type: "POST",
    success: function (result, status, xhr) {
        console.log(result)
        if (result.status == "0") {
            layer.msg(result.msg);
            return false;
        }
        $("input[name='back_picture']").val(result.info);
        $("#img2").attr('src', result.info);

    },
    error: function (result, status, errorThrown) {
        layer.msg('文件上传失败', {icon: 5});
    }
}
$('#thumb_upload2').fileUpload(opts2);

$('.upload3').click(function(){
    $('#thumb_upload3').click()
})
var opts3 = {
    url: "/user/common_upload",
    type: "POST",
    success: function (result, status, xhr) {
        console.log(result)
        if (result.status == "0") {
            layer.msg(result.msg);
            return false;
        }
        $("input[name='hand_picture']").val(result.info);
        $("#img3").attr('src', result.info);

    },
    error: function (result, status, errorThrown) {
        layer.msg('文件上传失败', {icon: 5});
    }
}
$('#thumb_upload3').fileUpload(opts3);