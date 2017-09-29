@extends('admin.layouts.application')
@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文章管理</strong> / <small>文章列表</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a href="{{route('createArticle')}}">
                            <button type="button" class="am-btn am-btn-success"><span class="am-icon-plus"></span>添加文章</button>
                        </a>

                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-form-group">
                    <select data-am-selected="{btnSize: 'sm'}" id="article_type">
                        <option value="0"
                                @if($typeid==0)
                                  selected
                                @endif
                        >全部分类</option>
                        <option value="1"
                                @if($typeid==1)
                                selected
                                @endif
                        >系统文章</option>
                        <option value="2"
                                @if($typeid==2)
                                selected
                                @endif
                        >观点文章</option>
                        <option value="3"
                                @if($typeid==3)
                                selected
                                @endif
                        >我的文章</option>
                    </select>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
                    <input type="type_key" value="" id="type_key" class="am-form-field">
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
                            <th class="table-title">文章标题/股票代码</th>
                            <th class="table-type">文章类别</th>
                            <th class="table-author am-hide-sm-only">作者</th>
                            <th class="table-date am-hide-sm-only">添加日期</th>
                            <th class="table-date am-hide-sm-only">修改日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($articles))
                            @foreach($articles as $key=>$value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value->title}}{{$value->description}}</td>
                            <td>
                                @foreach(ATarrry() as $k=> $v)
                                    @if(!empty($k==$value->type))
                                        {{$v}}
                                    @endif
                                @endforeach
                            </td>
                            @if(empty($value->user_id))
                                <td class="am-hide-sm-only">管理员</td>
                                @else
                                @if(isThere($users,$value->user_id))
                                    <td class="am-hide-sm-only">{{$value->user->name}}</td>
                                @else
                                    <td class="am-hide-sm-only"></td>
                                @endif

                            @endif
                            <td class="am-hide-sm-only">{{$value->ctime}}</td>
                            <td class="am-hide-sm-only">{{$value->etime}}</td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a href="{{route('editArticle',$value->id)}}" style="border: none"><button type="button" class="am-btn am-btn-success am-radius am-btn-xs"><span class="am-icon-pencil-square-o"></span> 编辑</button></a>
                                        <a><button type="button" class="am-btn am-btn-danger am-radius am-btn-xs" data-id="{{$value->id}}" id="btn_del"><span class="am-icon-trash-o"></span> 删除</button></a>
                                        <a href="{{route('articleComment',$value->id)}}" style="border: none">
                                            <button type="button" class="am-btn am-btn-warning am-radius am-btn-xs">
                                                <span class="am-icon-bullhorn"></span> 查看文章评论
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="am-cf">
                        共 {{$articles->count()}} 条记录
                        <div class="am-fr">
                            {!! $articles->links() !!}
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
                var articleid = $(this).data('id');
                var data = {
                    id:articleid,
                };
                var url = "{{route('delArticle')}}";
                $.get(url,data,function (res) {
                    layer.msg(res['msg']);
                    if (res['status'] == true) {
                        setTimeout(function(){window.location.href=("{{route('articleList')}}");}, 500);
                    }
                })
            });
        })
        $('#article_type').change(function(){
            $('#btn_search').click();
        })
        $(function () {
            $(document).on('click', '#btn_search', function () {
                var typeid=$('#article_type').val();
                var type_key= $('#type_key').val();
                if(typeid!=null)
                {
                    var url = "{{route('searchArticle')}}"+'/?keyword='+type_key+'&'+'typeid='+typeid;
                    window.location.href=(url);
                }
            })
        })
    </script>
@stop