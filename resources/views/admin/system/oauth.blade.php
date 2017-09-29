@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">第三方登陆配置</strong> / <small>Oauth Config</small></div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('oauth.config.update')}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            client_id <span class="am-badge am-badge-secondary am-radius"><i class="am-icon-qq"></i></span>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="qq_client_id" type="text"  value="{{$oauth['qq_client_id']}}" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            client_secret <span class="am-badge am-badge-secondary am-radius"><i class="am-icon-qq"></i></span>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="qq_client_secret" type="text"  value="{{$oauth['qq_client_secret']}}" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            回调地址 <span class="am-badge am-badge-secondary am-radius"><i class="am-icon-qq"></i></span>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="qq_redirect" type="text"  value="{{$oauth['qq_redirect']}}" required/>
                        </div>
                    </div>

                    <hr>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            client_id <span class="am-badge am-badge-danger am-radius"><i class="am-icon-weibo"></i></span>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="weibo_client_id" type="text"  value="{{$oauth['weibo_client_id']}}" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            client_secret <span class="am-badge am-badge-danger am-radius"><i class="am-icon-weibo"></i></span>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="weibo_client_secret" type="text"  value="{{$oauth['weibo_client_secret']}}" required/>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            回调地址 <span class="am-badge am-badge-danger am-radius"><i class="am-icon-weibo"></i></span>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="weibo_redirect" type="text"  value="{{$oauth['weibo_redirect']}}" required/>
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