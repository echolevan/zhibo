@extends('home.layout.app')

@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
            @include('home.lecturer.layout.left')
                    <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <div class="record">
                    <div class="recording">
                        <div style="width:100%; height:50px;border-bottom:#ddd 1px solid;">
                            <div class="recordtit">
                                <span style="width:5px; height:35px; display:block; float:left; background:#ff4436;"></span> 上传交割单
                            </div>
                            <a href="/consult.xlsx" class="btn btn-success pull-right"> 下载参考表格</a>
                        </div>
                        <div class="clear"></div>
                        @if(empty($userinfo->lecturer->room))
                            <div class="rightcon">
                                <div class="collapse" >
                                    <div class="well text-success">
                                        暂未分配房间，请联系客服，请联系客服！
                                    </div>
                                </div>
                            </div>
                        @else
                            @if($userinfo->lecturer->room->status == 2)
                                <div class="rightcon" style="margin-top: 10px;">
                                    <div class="collapse" >
                                        <div class="well text-success">
                                            你的房间已被关闭，请联系客服！
                                        </div>
                                    </div>
                                </div>
                            @else
                                <form enctype="multipart/form-data" action="{{route('excel.import')}}" method="post">
                                    {!! csrf_field() !!}

                                <div class="tab-content">
                                    <div class="message-1">
                                        <div class="viewtext">
                                            <div class="postview-1">

                                                <div class="re-txt mt20">
                                                    <label class="relable">上传交割单：</label>
                                            <span class="respan">
                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="delivery">
                                                </div>
                                            </span>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="re-txt mt20">
                                                    <label class="relable"></label>
                                                    <button type="submit" class="btn btn-orange">上传</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="clear"></div>
                <div style="height:225px;"></div>
            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop
@section('js')
    <script>

    </script>
    @stop