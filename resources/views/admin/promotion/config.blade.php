@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">推广奖励配置</strong> / <small>Promotion Config</small></div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('update.promotion.config')}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            注册成功奖励金币
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="register_award" type="text"  value="{{$promotion['register_award']}}" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            充值提成(%)
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="pay_award" type="text"  value="{{$promotion['pay_award']}}" placeholder="填写数字即可" required/>
                        </div>
                    </div>

                    <hr>
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label"></label>
                        <button class="am-btn am-btn-secondary" type="submit">提交</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop