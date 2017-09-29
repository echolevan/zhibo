@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">敏感词管理</strong> / <small>编辑敏感词</small></div>
        </div>

        <hr>
        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form action="" class="am-form am-form-horizontal">
                    <div class="am-g am-margin-top">
                        <input type="hidden" value="{{$word->id}}" id="word_id" name="word_id">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            分类名称
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="type_name" value="{{$word->word}}" type="text" id="word_name"  minlength="2" placeholder="分类名称" required/>
                        </div>
                    </div>
                    <hr>
                    <div class="am-form-group">
                        <label class="am-u-sm-3 am-form-label"></label>
                        <button class="am-btn am-btn-secondary" id="sub" type="button">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $(document).on('click', '#sub', function () {
                var word_name = $('#word_name').val();
                var word_id = $('#word_id').val();
                var data = {
                    id:word_id,
                    word:word_name,
                };
                var url = "{{route('updateWord')}}";
                $.post(url,data,function (res) {
                    layer.msg(res['msg']);
                    if(res['status']==true)
                    {
                        setTimeout(function(){window.location.href=("{{route('wordList')}}");}, 1000);
                    }
                })
            });
        })
    </script>
@stop
