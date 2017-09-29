<div class="navbar navbar-default navbar-fixed-bottom" style="background:#f8f8f8;">
    <ul class="list-inline footnav">
        <li class="text-center {{$_mobile_index or ''}}"> <a href="{{route('mobile')}}"> <i class="icon-1"></i>
                <div class="name">首页</div>
            </a> </li>
        <li class="text-center {{$_mobile_back_live or ''}}"> <a href="{{route('mobile.back_live')}}"> <i class="icon-2"></i>
                <div class="name">回看</div>
            </a> </li>
        @if(\Auth::check())
        <li class="text-center {{$_mobile_follow or ''}}"> <a href="{{route('mobile.follow')}}"> <i class="icon-3"></i>
                <div class="name">关注</div>
            </a> </li>
        @else
            <li class="text-center auth"> <a href="javascript:void (0);"> <i class="icon-3"></i>
                    <div class="name">关注</div>
                </a> </li>
            <script>
                $(function(){
                    $('.auth').click(function(){
                        layer.open({
                            content: '查看我的关注，请先登陆！'
                            ,btn: ['确定']
                            ,skin: 'footer'
                            ,yes: function(index){
                                location.href = "{{url('mobile/login')}}";
                            }
                        });
                    })
                })
            </script>
            @endif
        <li class="text-center {{$_mobile_article or ''}}"> <a href="{{route('mobile.view')}}"> <i class="icon-4"></i>
                <div class="name">动态</div>
            </a> </li>
        <li class="text-center {{$_mobile_customer or ''}}"> <a href="{{route('mobile.customer')}}"> <i class="icon-5"></i>
                <div class="name">我的</div>
            </a> </li>
    </ul>
</div>