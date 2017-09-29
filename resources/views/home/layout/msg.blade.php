<div class="container">
    

@if (session('msg'))
    <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 20px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" onclick="$(this).parent().parent().hide()">&times;</span>
        </button>
        {{session('msg')}}
    </div>
@endif

@if (session('error'))

    <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 20px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" onclick="$(this).parent().parent().hide()">&times;</span>
        </button>
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
</div>

