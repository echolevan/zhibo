@extends('home.layout.app')
@section('css')
    <style>
        .menulist{overflow-y:scroll}
        td,th{text-align: center;border:1px solid;width:140px;height: 45px;line-height: 45px}
        .am-bo{margin-left:10%;border:1px solid;height:150px;color:pink;border-color:pink;margin-left:10%}
    </style>
@endsection
@section('content')
    <div class="container user">
        <div class="row">
            <!--左侧-->
        @include('home.lecturer.layout.left')
        <!--左侧结束-->
            <!--右侧-->
            <div class="pull-right userright">
                <div class="rightcon">
                    <h3>
                        <span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>我的转播
                    </h3>
                    <table class="am-bo">
                        <tbody>
                            <tr>
                                <th>讲师</th>
                                <th>转播时间</th>
                                <th>服务类型</th>
                                <th>转播费用</th>
                                <th>开关</th>
                            </tr>

                            @foreach($myRelay as $relay)
                            <tr>
                                <td>{{ $relay->fromRoom->lecturer->username }}</td>
                                <td>{{ $relay->created_at }}</td>
                                <td>包月</td>
                                <td>{{ $relay->amount }}</td>
                                <td>
                                    @if($relay->expired_at > \Carbon\Carbon::now())
                                        <form method="post" action="{{ route('relay.relay') }}">
                                            <button type="submit">转播</button>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="relay_id" value="{{ $relay->id }}" />
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h3>
                        <span style=" width:5px; height:35px; display:block; float:left; background:#ff4436;"></span>谁转播我
                    </h3>

                    <table class="am-bo">
                        <tbody>
                            <tr>
                                <th>转客</th>
                                <th>转播时间</th>
                                <th>服务类型</th>
                                <th>转播收入</th>
                                <th>手机号</th>
                            </tr>
                        @foreach($relayMe as $relay)
                            <tr>
                                <td>{{ $relay->toRoom->lecturer->username }}</td>
                                <td>{{ $relay->created_at }}</td>
                                <td>包月</td>
                                <td>{{ $relay->amount }}</td>
                                <td>{{ $relay->toRoom->lecturer->user->phone }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!--右侧结束-->
        </div>
    </div>
@stop