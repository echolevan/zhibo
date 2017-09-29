@extends('admin.layouts.application')
{{--@section('css')--}}
{{--@stop--}}
@section('content')
<div class="admin-content">
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl"><strong class="am-text-primary am-text-lg">消费记录</strong></div>
        </div>

        <hr/>

        <div class="am-g error-log">
            <div class="am-u-sm-12 am-u-sm-centered">
        <pre class="am-pre-scrollable">@foreach($consumes as $c)<span class="am-text-success">[{{$c->created_time}}]</span><span class="am-text-danger">[花费了{{$c->price}}金币]</span>{{$c->type}} @if(!empty($c->toUser)) [接受者：{{$c->toUser->name}} ]@endif<br>@endforeach</pre>
            </div>
        </div>
    </div>

</div>
    @stop