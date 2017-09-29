@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">讲师提现规则设置</strong> /
                <small><a href="{{route('user_examine_role')}}">用户提现规则设置</a></small>
            </div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form class="am-form am-form-horizontal" action="{{route('examine_role_store')}}" method="post">
                    {{csrf_field()}}
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <p>不填写则无限制</p>
                        <hr>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            每月提现时间
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="time" type="number" value="{{$role['time']}}" placeholder="(每月的1-28号之间)"/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            每月提现次数
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="num" type="number"  value="{{$role['num']}}" />
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            最低提现金额
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="money" type="number"  value="{{$role['money']}}" />
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            平台抽取比例
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="proportion" type="number"  value="{{$role['proportion']}}" />
                        </div>
                    </div>
                    <hr>
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label"></label>
                        <input type="hidden" name="type" value="teacher">
                        <button class="am-btn am-btn-secondary make_room" type="submit">修改</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
