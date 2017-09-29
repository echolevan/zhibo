@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">送礼记录</strong> /
                <small>列表</small>
            </div>
        </div>
        <hr>
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">

                        <a href="{{route('gift_index')}}">
                            <button type="button" class="am-btn am-btn-default"><span class="am-icon-history"></span>
                                礼物管理
                            </button>
                        </a>
                    </div>
                </div>
            </div>
          </span>
                </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-bordered am-table-compact" id="example">
                        <thead>
                        <tr>
                            <th>赠送者</th>
                            <th>收礼者</th>
                            <th>礼物名称</th>
                            <th>数量</th>
                            <th>金额</th>
                            <th>送礼时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($history as $h)
                        <tr class="odd gradeX">
                            <td><a href="{{route('admin.user_update',$h->send_id)}}" target="_blank">{{$h->send_name}}</a></td>
                            <td><a href="{{route('admin.user_update',$h->receiver_id)}}" target="_blank">{{$h->receiver_name}}</a></td>
                            <td>{{$h->gift_name}}</td>
                            <td class="center">{{$h->num}}</td>
                            <td class="center">{{$h->gift_price}}</td>
                            <td class="center">{{$h->create_time}}</td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr/>
                </form>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>
        $(function() {
            $('#example').DataTable();
        });
    </script>
@stop
