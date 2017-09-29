@extends('admin.layouts.application')

@section('content')
    <div class="admin-content-body">
        <div class="am-cf am-padding am-padding-bottom-0">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">轮播图</strong> / <small>Edit Focus</small></div>
        </div>

        <hr>

        <div class="am-g">
            <div class="am-u-sm-9 am-u-sm-offset-1">
                <form method="post" action="{{route('config.update.focus',$focus->id)}}" class="am-form am-form-horizontal">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            焦点图
                        </div>

                        <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                            <div class="am-form-group am-form-file new_thumb">
                                <button type="button" class="am-btn am-btn-success am-btn-sm">
                                    <i class="am-icon-cloud-upload" id="loading"></i> 上传新的焦点图
                                </button>
                                <input type="file" id="focus_upload">
                                <input type="hidden"  name="thumb" value="{{$focus->thumb}}" />
                                <input type="hidden"  name="small" value="{{$focus->small}}" />
                            </div>

                            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
                            <div>
                                <img src="{{$focus->small}}" id="img_show">
                            </div>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            展示讲师
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">

                            <select data-am-selected="{searchBox: 1}" name="lecturer_id">
                                <option value="-1">选择要展示的讲师</option>
                                @foreach($lecturer as $l)
                                    @if(!empty($l->room))
                                        @if(!empty($l->user))
                                            <option @if($focus->lecturer_id == $l->id) selected @endif value="{{$l->id}}">{{$l->user->name}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>

                        </div>
                    </div>


                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            说明
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea name="desc" id="doc-vld-ta-2" minlength="4" maxlength="100">{{$focus->desc}}</textarea>
                        </div>

                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            排序
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input name="sort" type="number" value="{{$focus->sort}}" placeholder=">0" required/>
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

@section('js')
    <script src="{{asset('assets/upload/jquery.html5-fileupload.js')}}"></script>
    <script src="{{asset('assets/upload/upload_focus.js')}}"></script>
@stop