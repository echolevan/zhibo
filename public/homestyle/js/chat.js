
$(function () {
    var myselfInfo = {"level": 0, "uid":0};
    var maxMessageNum = 100;
    var timeDiff = 0;// 服务器时间和用户本地时间差
    var isMobile= false;
    var userLevel = [];
    
    init();
    WEB_SOCKET_SWF_LOCATION = "/homestyle/js/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    
    try {
        WebSocket.loadFlashPolicyFile("xmlsocket://" + host + ":10843");
    } catch (e) {
    }
    
    var ws = new WebSocket(wsAddress);
    ws.onopen = function () {
            userLogin();
			syncTimer();
    };
    ws.onmessage = function (event) {
        var data = event.data.split('\n');
        for (var i = 0; i < data.length; i++) {
            var messages = data[i];
//            console.log("receive msg:" + messages);

            var prefix = messages.substr(0, 4);
            var content = messages.substr(5);
//            console.log("prefix:" + prefix + "  content:" + content);

            switch (prefix) {
                case "1001":
                    loginResult(content);
                    break;
                case "1005":
                    setGuestInfo(content);
                    break;
                case "1021":
                    syncTime(content);
                    break;
                case "1200":
                    showOnLineUsers(content);
                    break;
                case "1110":
                    showMessage(content);
                    break;
                case "1101":
                    snedMessageResult(content);
                    break;
                case "1111":
                    showSystemTips(content, 'normal');
                    break;
                case "1121":
                    showQuestion(content);
                    break;
                case "1122":
                    solveQuestion(content);
                    break;
                case "1131":
                    showGift(content);
                    break;
                case "9001":
                    layer.msg("请登录后再发言。");
                default:
            }
        }
    };
    ws.onclose = function () {
        setTimeout(function () {
            layer.msg("无法连接到聊天室");
        }, 500);
    };

    ws.onerror = function () {
        reconnect();
    };

    function init() {
        //calHeight();    //自动调整消息框高度
        parseMyselfInfo();
        initQuestion();
//        beautySelect();
//        checkIsMobile();
//        autuAdaptper();
    }

    // 时间同步
    function syncTime(content){
        var serverTime = content;
        var localTime = timestamp = Date.parse(new Date())/1000;
        timeDiff = serverTime - localTime;
        //console.log(" time sync :  serverTime:" +serverTime +  " localtime:" +  localTime + " timediff:"+ timeDiff);
    }

    function parseMyselfInfo() {
        jsonStr = $("#userData").attr("userData");
        if (jsonStr.length > 0) {
            jsonStr = jsonStr.replace("1000|", "");
            myselfInfo = JSON.parse(jsonStr);
        }
        console.log(myselfInfo);
    }

    function userLogin(){
        if ($("#userData").attr("userData") != "") {
            ws.send($("#userData").attr("userData"));
        }
    }
    
    function syncTimer(){
        ws.send("1020|");
        return;
    }

    function setGuestInfo(content) {
        $("#guestName").html(content);
    }

    function showGift(content){
//        console.log(content);
        var obj = JSON.parse(content)
        var info = "<font class='sender'>" + obj.SenderName + "</font> 送给 <font class='receiver'>" + obj.ReceiverName + "</font> <font class='giftNum'>"+ obj.GiftNum +"</font> 个" + obj.GiftName;
        showSystemTips(info, 'gifts');
        updateNotice(info);
        
        // show gift
        var giftSource = $("#paid-gifts-wrap #gift_"+obj.GiftID).attr("source");
        var giftImg = "<img src='"+giftSource+"' />";
        
//        layer.open({type: 1,title: false,closeBtn: 0, area: '516px', skin: 'layui-layer-nobg', shadeClose: true, content: giftImg, time:4000});

        showGiftBarrager(info, giftSource);
    }
    
    function showQuestion(content){
        var obj = JSON.parse(content)
        var questionStr = $("#userData").attr('question');
        var questionList = JSON.parse(questionStr);
        var que = new Object();
        que.reply_price = obj.QuestionCost;
        que.title = obj.QuestionTitle;
        que.id = obj.UserID;
        que.name = obj.UserName;
        que.status = obj.QuestionStatus;
        questionList.push(que); // 合并问题
//        console.log(questionList);
        $("#userData").attr('question', JSON.stringify(questionList)); // 更新
        
        initQuestion(); // 重新初始化
       
       // show in chatroom
        var info = obj.UserName + "向主播提了一个付费问题";
        showSystemTips(info, 'question');
    }
    
    function solveQuestion(content){
        var obj = JSON.parse(content);
        var questionID = obj.QuestionID;
        var questionStr = $("#userData").attr('question');
        var questionList = JSON.parse(questionStr);
//        console.log(questionStr);
        for (var i=0; i< questionList.length; i++){
//            console.log("q:"+parseInt(questionList[i].id) + " qid:"+parseInt(questionID));
            if (parseInt(questionList[i].id) == parseInt(questionID)){
//                console.log("id =====："+ questionList[i].id);
                questionList[i].status = 2;
            }
        }
        
        var newQuestionStr = JSON.stringify(questionList);
//        console.log(newQuestionStr);
        $("#userData").attr('question', newQuestionStr);
        initQuestion(); // 重新初始化
    }
    

    function showSystemTips(content, types){
        var str = '<div class="sysTips"><span class="'+types+'">'+content+'</span></div>';
        $(".chatInfo").append(str);
        scrollBottom();
    }

    function loginResult(content) {
        var obj = JSON.parse(content)
        if (!obj.Result) {
            layer.msg("进入房间失败");
        }
    }

    function snedMessageResult(content) {
        var obj = JSON.parse(content)
        if (!obj.Result) {
            layer.msg(obj.Msg);
        }
    }

    function showOnLineUsers(content) {
        var obj = JSON.parse(content);
        $('#onlineCount').text(obj.Total);
        //console.log("当前在线人数："+obj.Total);
    }
    
    // init question when page loaded
    function initQuestion(){
        var questionStr = $("#userData").attr('question');
//        console.log(questionStr);
        var question = JSON.parse(questionStr);
        var questionSorted =  questionSort(question);
//        console.log(questionSorted);
        questionRender(questionSorted);
        
    }
    
    function questionSort(question){
        var asked = [];
        var unasked = [];
        for (var i=0; i< question.length; i++){
            if (question[i].status == 1){
                unasked.push(question[i]);
            }else{
                asked.push(question[i])
            }
        }
        unasked.sort(
            function(a,b){
//                console.log("unasked: a:"+ parseFloat(a.reply_price) + "  b:" + parseFloat(b.reply_price));
                return parseFloat(a.reply_price) < parseFloat(b.reply_price);
        });
        asked.sort(
            function(a,b){
                return parseFloat(a.reply_price) < parseFloat(b.reply_price);
        });
        
        return unasked.concat(asked);
    }
    
    function questionRender(question){
        var tempStr ="";
        for (var i=0; i< question.length; i++){
            var status =  question[i].status == 1 ? 'unasked':"asked";
            tempStr += '<li class="'+status+'">';
            tempStr += '<a href="javascript:void (0);">';
            tempStr += '<i>';
            tempStr += '<img src="/homestyle/images/'+status+'.png" width="20" height="20">';
            tempStr += '</i>';
            tempStr += '<span class="questionTitle">'+question[i].title+'</span>';
            tempStr += '<span class="questionPrice">';
            tempStr += '<img src="/homestyle/images/gold.png" width="12" height="14">￥';
            tempStr += question[i].reply_price;
            tempStr += '</span>';
            tempStr += '</a>';
            tempStr += '</li>';
        }
         $(".questionBox").html("");
        $(".questionBox").append(tempStr);
    }
    
    function updateNotice(str){
        $(".bulletin .line").html("");
        $(".bulletin .line").html('<li style="margin-top: 0px; ">'+str+'</li>');
    }
    

//  禁言
    $(document).on("click", ".denyspeak", function () {
        var roomid = $('input[name=room_id]').val();
        var uid = $(this).attr("uid");
        var cid = $(this).attr("cid");
        $.ajax({
            type: 'get',
            url: '/live/ban',
            data: {uid: uid,room_id:roomid,cid:cid},
            success: function (data) {
                if(data.status == false){
                    layer.msg(data.msg);
                    return false;
                }
                layer.msg('禁言成功！');
            },error: function(){
                layer.msg('操作失败！');
            }
        });
        
        var prefix = "1300|";
        var msg = {userID: parseInt(uid), cmd:"refresh"};
        ws.send(prefix + JSON.stringify(msg));
    });
    
    
    $(document).on("mouseover", ".talk_recordbox", function () {
        $(this).find(".denyspeak").show();
    }).on("mouseout", ".talk_recordbox", function () {
        $(this).find(".denyspeak").hide();
    });
    
//    $(document).on("click", ".frozen", function () {
//        var cid = $(this).data('cid');
//        var uid = $(this).data('uid');
//        var status = 3;
//        $.ajax({
//            type: 'get',
//            url: '/ban',
//            data: {cid: cid, uid: uid, status: status},
//            success: function (data) {
//                if (data.status) {
//                    layer.msg('冻结成功！');
//                } else {
//                    layer.msg(data.msg);
//                }
//            }
//        })
//    });
//    $(document).on("click", ".notip", function () {
//        var cid = $(this).data('cid');
//        var uid = $(this).data('uid');
//        var Ip = 'ip';
//        $.ajax({
//            type: 'get',
//            url: '/ban',
//            data: {ipcid: cid, ipuid: uid},
//            success: function (data) {
//                if (data.status) {
//                    layer.msg(data.msg);
//                } else {
//                    layer.msg(data.msg);
//                }
//            }
//        })
//    });

    function showMessage(content) {

        setTimeout(function(t){
            //alert("delay 1s");
            _show(content)
        }, 300);

        function _show(content){
            var content = content.split('\n');
            //console.log(content);
            var msgStr = "";
            var megStrAdvance = "";
            for (var i = 0; i < content.length; i++) {
                obj = JSON.parse(content[i]);
                var timestamp = Date.parse(new Date());
                timestamp = timestamp / 1000;
                msgStr = htmlTemplateMsg(obj)
                appendChatMsg(msgStr);
            }

            //弹幕配置
            processBarrager(obj);

            //parse face
//        $(".chatInfo").AnalyticEmotion();

//        $(".message_list_2").AnalyticEmotion();

            // 表情解析后，若有大图片，需要重新滚动
            scrollBottom();
        }

    }

  
    // 普通消息模板
    function htmlTemplateMsg(obj){
        var msgStr = "";

        var msgContetn = AnalyticEmotion(obj.Data);

        // 公聊
        if (obj.MessageType == 0){
            var sUserAgent = navigator.userAgent.toLowerCase();
            if ((sUserAgent.match(/(ipod|iphone os|midp|ucweb|android|windows ce|windows mobile)/i))) {
                var level = obj.UserFrom.Level;
                var htmluserLevel=userLevel[level];
                msgStr += '<li class="d-flex">';
                msgStr += '</li>';
                msgStr += '<div class="clear"></div>';
            }else{
                var userIcon = obj.UserFrom.Uid <= 0 ? '/homestyle/images/admin.png' : obj.UserFrom.Thumb;
                var denySpeak =  (myselfInfo.level >=10000) ? '<span class="denyspeak" uid='+obj.UserFrom.Uid+ ' cid='+obj.UserFrom.ClientID+'>禁言</span>' : "";
                msgStr += '<li class="">';
                msgStr += '<div class="talk_recordbox">';
                msgStr += '<div class="nickname"> <span class="pull-left user"><img src="' + userIcon + '" class="img-circle img-responsive"></span> <span style="text-indent:10px; margin-left:10px; line-height:20px;">' + obj.UserFrom.Name + '</span> ' +denySpeak+ ' </div>';
                msgStr += '<div class="talk_recordcon">';
                msgStr += '<div class="talk_recordtextbg"> &nbsp;</div>';
                msgStr += '<div class="talk_recordtext">' + msgContetn + '</div>';
                msgStr += '</div>';
                msgStr += '</div>';
                msgStr += '</li>';
                msgStr += '<div class="clear"></div>';
                
                // 如果是管理员，增加禁言等控制按钮
                if (myselfInfo.level >= 10000 && obj.UserFrom.Level < 10000) {
                    msgStr += '<div style="display: none;float: left" class="onopn">';
                    msgStr += '<span data-uid=' + obj.UserFrom.Uid + ' data-cid=' + obj.UserFrom.ClientID + ' class="member_cell_2 notip">禁IP</span>';
                    var Status = obj.UserFrom.Status;
                    if (Status != 0) {
                        msgStr += '<span data-uid=' + obj.UserFrom.Uid + ' data-cid=' + obj.UserFrom.ClientID + ' class="member_cell_2 frozen">冻结</span>';
                        if(Status==1){
                            var Text = "禁言";
                            var status  = "2";
                            msgStr += '<span data-uid=' + obj.UserFrom.Uid + ' data-cid=' + obj.UserFrom.ClientID + ' data-status='+status+' class="member_cell_2 gag">'+Text+'</span>';
                        }
                    }
                    msgStr += '<span data-uid=' + obj.UserFrom.Uid + ' data-cid=' + obj.UserFrom.ClientID + ' class="member_cell_2">私聊</span>';
                    msgStr += '</div>';
                }
                msgStr += '</div>';
            }
        }else if(obj.MessageType == 1){ // 1V1私聊
            var sender = "";
            var receiver = "";
            if (obj.UserFrom.Uid == myselfInfo.uid){
                sender = "我";
                receiver = obj.UserTo.Name;
            }else{
                sender = obj.UserFrom.Name;
                receiver = "我";
            }
            msgStr += '<div class="message_list_1">';
            msgStr += '<div class="message_cell_1">';
            msgStr += '<ul>';
            msgStr += '<li><p>' + formatDateTime(obj.Time) + '</p></li>';
            msgStr += '<li><h3>'+sender+'</h3><span>对</span></li>';
            msgStr += '</ul>';
            msgStr += '<div class="message_table_1">';
            msgStr += '<table>';
            msgStr += '<tr>';
            msgStr += '<td><div class="message_tr_1"><h3>'+receiver+'</h3><span>说：</span></div></td>';
            msgStr += '<td><div class="message_txt_1"><span>'+obj.Data+'</span></div></td>';
            msgStr += '</tr>';
            msgStr += '</table>';
            msgStr += '</div>';
            msgStr += '</div>';
            msgStr += '</div>';
        }

        return msgStr;

    }

    // 那些用户需要显示弹幕
    function processBarrager(obj){
        var timestamp = Date.parse(new Date())/ 1000;
        //console.log("msg:" + obj.Data + " shicha:" + timeDiff +   ' 服务器：'+obj.Time+  "bendi weijiaozhun:" + timestamp +   '  本地时间jiaozhun：'+ (timestamp - timeDiff) +'  时间差：'+ Math.abs(timestamp - timeDiff - obj.Time));


        if (Math.abs(timestamp + timeDiff - obj.Time) > 180){
            return;
        }

        //showBarrager(obj);

        var barragerSystemOpen = $('#barrage_system').val(); //系统是否开启弹幕
        var barrageUserSetting = $('#barrage_default').val(); // 用户自己是否打开或者关闭了弹幕

        if( barragerSystemOpen == 1 && barrageUserSetting ==1 ){
            showBarrager(obj);
        }
    }


    // 显示弹幕
    function showBarrager(obj){

        var Data = obj.Data;
        Data = AnalyticEmotion(Data);
        var timeout =  Math.floor(Math.random()*1000);
        var timeDelayByLevel =  obj.UserFrom.Level * 2;
        timeDelayByLevel = timeDelayByLevel > 30 ? 30 : timeDelayByLevel;
        setTimeout(function(){
            var item = {
                info: Data, //文字
                href: 'javascript:;', //链接
                close: false, //显示关闭按钮
                speed: parseInt(20 + timeDelayByLevel + Math.floor(Math.random() * 10)), //延迟,单位秒,默认6
//                speed: 20, //延迟,单位秒,默认6
                color: '#fff', //颜色,默认白色
                old_ie_color: '#000000', //ie低版兼容色,不能与网页背景相同,默认黑色
                bg_color:'', //背景颜色
                opacity:0.9,//背景颜色透明度
            };

            // root level
            if (obj.UserFrom.Level >= 10000) {
                item.img = '/assets/home/barrager/static/img/heisenberg.png';
//                item.img = '/assets/home/images/identity/10000.png';
                item.bg_color = '#dd1234';
                item.speed = 40;
            }
            $('body').barrager(item);
        }, timeout);
    }
    
    // 显示礼物
    function showGiftBarrager(Data, imgbg){
        var timeout =  Math.floor(Math.random()*1000);
        setTimeout(function(){
            var item = {
                info: Data, //文字
                href: 'javascript:;', //链接
                close: false, //显示关闭按钮
                speed: 4, //延迟,单位秒,默认6
//                color: '#dd1234', //颜色,默认白色
                old_ie_color: '#000000', //ie低版兼容色,不能与网页背景相同,默认黑色
                bg_color:'', //背景颜色
                opacity:0.9,//背景颜色透明度
                imgbg : imgbg,
            };
            $('body').giftBarrager(item);
        }, timeout);
    }
    
    
    function calHeight() {
        calHeightPC();
        calHeightMobile();
    }
    
    function calHeightPC(){
        if (!isMobile){
            var total = document.documentElement.clientHeight;
            var messageBoxHeight = total - $(".message_advance").height() - 220 - $(".message_telCell_1").height();
            $(".chatInfo").css("height", messageBoxHeight);
        }
    }
    
    function calHeightMobile() {
        if (isMobile){
            var win = $(window).height();
            var rel = $("#rel").height();
            var clx = $(".clearfix").height()
            var inr = $("#inputbar").height();
            var hei = win-rel-inr-clx;
            $(".swiper-wrapper").height((hei+inr)+'px');
            $(".swiper-no-swiping").css('min-height',hei+'px');
            $(".swiper-slide").height(hei+'px');
            $(".tab-content-cooperation").height((hei+inr)+'px');
        }
    }

    function appendChatMsg(item) {
        $(".chatInfo").append(item);
        if ($(".chatInfo .message_list_1").length > maxMessageNum) {
            $(".chatInfo .message_list_1:first").remove();
        }
        scrollBottom();
    }
    
    function scrollBottom(){
        $(".scroll-sidebar-cont").scrollTop($(".chatInfo").scrollTop() + 30000000000);
//        $(".scroll-sidebar-cont").animate({scrollTop: $(".scroll-sidebar-cont").scrollTop() + 30000}, 800);
    }
    
    $("#btnCommit").bind("click", function () {
        commit();
    });

    function commit() {
        var speak = $("#speak").val();
        if(!speak == 1){
            layer.msg("现在还不能说话哦！");
            return false;
        }
        if (!$(".msg").val()) {
            layer.msg("聊天内容不能为空");
            return false;
        }
        var CidFrom = parseInt($("#userfrom").val());
        var CidTo = parseInt($("#userto").val());
        //console.log("CidFrom:"+CidFrom+"  CidTo:"+CidTo);
        sendMessage($(".msg").val(), CidFrom, CidTo);
        $(".msg").val("");
        return false;
    }

    function sendMessage(msgStr, CidFrom, CidTo) {
        if (!ws) {
            layer.msg("已经断开连接");
            return false;
        }
        var prefix = "1100|";
        var msg = {Data: msgStr, ClientIDFrom: CidFrom, ClientIDTo:CidTo};
        //console.log(msg);
        ws.send(prefix + JSON.stringify(msg));
    }

    function formatDateTime(/** timestamp=0 **/) {
        var ts = arguments[0] || 0;
        var t, y, m, d, h, i, s;
        t = ts ? new Date(ts * 1000) : new Date();
        y = t.getFullYear();
        m = t.getMonth() + 1;
        d = t.getDate();
        h = t.getHours();
        i = t.getMinutes();
        s = t.getSeconds();
        // 可根据需要在这里定义时间格式
//	    return y+'-'+(m<10?'0'+m:m)+'-'+(d<10?'0'+d:d)+' '+(h<10?'0'+h:h)+':'+(i<10?'0'+i:i)+':'+(s<10?'0'+s:s);  
        return (h < 10 ? '0' + h : h) + ':' + (i < 10 ? '0' + i : i);
    }
    
    $(".clearMessage").bind("click", function(){
        $('.chatInfo').html("");
    });
    
    

});

