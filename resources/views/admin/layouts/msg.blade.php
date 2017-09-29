@if (session('msg'))
    <div class="am-alert am-alert-success" data-am-alert>
        <button type="button" class="am-close">&times;</button>
        <p>{{session('msg')}}</p>
    </div>
@endif

@if (session('error'))
    <div class="am-alert am-alert-warning" data-am-alert>
        <button type="button" class="am-close">&times;</button>
        <p>{{session('error')}}</p>
    </div>
@endif

@if (count($errors) > 0)
    @foreach($errors->all() as $v)
        <div class="am-alert am-alert-warning" data-am-alert>
            <button type="button" class="am-close">&times;</button>
            <p>{{$v}}</p>
        </div>
    @endforeach
@endif

