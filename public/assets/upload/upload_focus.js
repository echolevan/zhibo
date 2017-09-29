//文件上传
var opts = {
    url: "/image/upload_focus",
    type: "POST",
    beforeSend: function () {
        $("#loading").attr("class", "am-icon-spinner am-icon-pulse");
    },
    success: function (result, status, xhr) {
        console.log(result);
        if (result.status == "0") {
            alert(result.msg);
            $("#loading").attr("class", "am-icon-cloud-upload");
            return false;
        }
        $("input[name='thumb']").val(result.thumb);
        $("input[name='small']").val(result.small);
        $("#img_show").attr('src', result.small);
        $("#loading").attr("class", "am-icon-cloud-upload");
    },
    error: function (result, status, errorThrown) {
        alert('文件上传失败');
    }
}

$('#focus_upload').fileUpload(opts);