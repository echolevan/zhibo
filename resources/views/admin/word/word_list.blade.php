@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">敏感词管理</strong> / <small>敏感词列表</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('createWord')}}">
                            <button type="button" class="am-btn am-btn-success"><span class="am-icon-plus"></span>添加敏感词</button>
                        </a>

                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
                    <input type="word_key" value="" id="word_key" class="am-form-field">
          <span class="am-input-group-btn">
            <button class="am-btn am-btn-default" id="btn_search" type="button">搜索</button>
          </span>
                </div>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover">
                        <thead>
                        <tr>
                            <th class="table-id">ID</th>
                            <th class="table-name">敏感词名称</th>
                            <th class="table-ctime">创建时间</th>
                            <th class="table-etime">末次修改时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($words))
                            @foreach($words as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td><a href="#">{{$value->word}}</a></td>
                                    <td class="am-hide-sm-only">{{date('Y-m-d H:i:s',$value->ctime)}}</td>
                                    <td class="am-hide-sm-only">{{date('Y-m-d H:i:s',$value->etime)}}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a href="{{route('editWord',$value->id)}}" style="border: none"><button type="button" class="am-btn am-btn-success am-radius am-btn-xs"><span class="am-icon-pencil-square-o"></span> 编辑</button></a>
                                                <a><button type="button" class="am-btn am-btn-danger am-radius am-btn-xs" data-id="{{$value->id}}" id="btn_del"><span class="am-icon-trash-o"></span> 删除</button></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$words->count()}} 条记录
                        <div class="am-fr">
                            {!! $words->links() !!}
                        </div>
                    </div>
                    <hr>
                </form>
            </div>

        </div>
    </div>
    @stop
    @section('js')
        <script>
            $(function () {
                $(document).on('click', '#btn_del', function () {
                    var wordid = $(this).data('id');
                    var data = {
                        id:wordid,
                    };
                    var url = "{{route('delWord')}}";
                    $.get(url,data,function (res) {
                        layer.msg(res['msg']);
                        if (res['status'] == true) {
                            setTimeout(function(){window.location.href=("{{route('wordList')}}");}, 500);
                        }
                    })
                });
            })
            $(function () {
                $(document).on('click', '#btn_search', function () {
                    var word_key= $('#word_key').val();
                    var url = "{{route('searchWord')}}"+'/?keyword='+word_key;
                    window.location.href=(url);
                })
            })
        </script>
    @stop