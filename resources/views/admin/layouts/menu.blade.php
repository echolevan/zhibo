<div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
        <ul class="am-list admin-sidebar-list">
            <li><a href="{{route('admin')}}"><span class="am-icon-home"></span> 首页</a></li>
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#collapse-nav'}">
                    <span class="am-icon-graduation-cap"></span>
                    讲师管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_lecturer or ''}}" id="collapse-nav">
                    <li>
                        <a href="{{route('lecturer')}}" class="am-cf">
                            <span class="am-icon-navicon"></span> 讲师列表
                        </a>
                    </li>
                    <li>
                        <a href="{{route('lecturer.create')}}" class="am-cf">
                            <span class="am-icon-plus"></span> 添加讲师
                        </a>
                    </li>
                    <li>
                        <a href="{{route('lecturer.check.list')}}" class="am-cf">
                            <span class="am-icon-hand-stop-o"></span> 讲师审核列表
                            <span class="am-badge am-badge-success">{{App\Models\Lecturer::where('status',1)->count()}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('lecturer.reject.list')}}" class="am-cf">
                            <span class="am-icon-hand-scissors-o"></span> 讲师驳回列表
                            <span class="am-badge am-badge-danger">{{App\Models\Lecturer::where('status',3)->count()}}</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#room'}">
                    <span class="am-icon-object-group"></span> 房间管理
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_room or ''}}" id="room">
                    <li>
                        <a href="{{route('room')}}" class="am-cf">
                            <span class="am-icon-bars"></span> 房间列表
                        </a>
                        <a href="{{route('room.create')}}" class="am-cf">
                            <span class="am-icon-plus"></span> 添加房间
                        </a>
                    </li>
                </ul>
            </li>

            <li><a href="{{route('gift_index')}}"><span class="am-icon-gift"></span> 礼物管理</a></li>
            <li><a href="{{route('pay.info')}}"><span class="am-icon-paypal"></span> 充值管理</a></li>
            <li><a href="{{route('admin.user')}}"><span class="am-icon-user"></span> 用户管理</a></li>

            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#article'}">
                    <span class="am-icon-file"></span> 内容管理
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_article or ''}}" id="article">
                    <li>
                        <a href="{{route('articleList')}}" class="am-cf">
                            <span class="am-icon-bars"></span> 文章列表
                        </a>
                        <a href="{{route('createArticle')}}" class="am-cf">
                            <span class="am-icon-plus"></span> 添加文章
                        </a>
                    </li>
                </ul>
            </li>

            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#price'}">
                    <span class="am-icon-rmb"></span> 资产管理
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_withdrawals or ''}}" id="price">
                    <li>
                        <a href="{{route('examine_index')}}" class="am-cf">
                            <span class="am-icon-rmb"></span> 提现管理
                        </a>
                    </li>
                    <li>
                        <a href="{{route('examine_role')}}" class="am-cf">
                            <span class="am-icon-building"></span> 提现规则设置
                        </a>
                    </li>
                </ul>
            </li>

            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#system'}">
                    <span class="am-icon-google-wallet"></span> 配置管理
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_system or ''}}" id="system">
                    <li>
                        <a href="{{route('qiniu.config')}}" class="am-cf">
                            <span class="am-icon-vimeo"></span> 七牛配置
                        </a>
                    </li>

                    <li>
                        <a href="{{route('oauth.config')}}" class="am-cf">
                            <span class="am-icon-drupal"></span> 第三方登陆配置
                        </a>
                    </li>

                </ul>
            </li>

            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#promotion'}">
                    <span class="am-icon-sitemap"></span> 推广管理
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_promotion or ''}}" id="promotion">
                    <li>
                        <a href="{{route('admin.promotion')}}" class="am-cf">
                            <span class="am-icon-list-alt"></span> 推广列表
                        </a>
                    </li>
                    <li>
                        <a href="{{route('promotion.config')}}" class="am-cf">
                            <span class="am-icon-asterisk"></span> 推广奖励规则设置
                        </a>
                    </li>
                </ul>
            </li>

            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#config'}">
                    <i class="am-icon-gear am-icon-spin"></i> 系统设置
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_config or ''}}" id="config">
                    <li>
                        <a href="{{route('config.site_info')}}" class="am-cf">
                            <span class="am-icon-send"></span> 站点信息
                        </a>
                        <a href="{{route('config.focus')}}" class="am-cf">
                            <span class="am-icon-image"></span> 轮播图
                        </a>
                        <a href="{{route('clear_cache')}}" class="am-cf">
                            <i class="am-icon-spinner am-icon-pulse"></i> 清除缓存
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="{{route('admin.delivery')}}"><span class="am-icon-clone"></span> 交割单</a></li>
            <li class="admin-parent">
                <a class="am-cf" data-am-collapse="{target: '#rbac'}">
                    <span class="am-icon-lock"></span> 权限管理
                    <span class="am-icon-angle-right am-fr am-margin-right"></span>
                </a>
                <ul class="am-list am-collapse admin-sidebar-sub {{$_admin_user or ''}} {{$_permission or ''}} {{$_role or ''}}" id="rbac">
                    <li>
                        <a href="{{route('adminlist')}}" class="am-cf">
                            <span class="am-icon-user"></span> 管理员
                        </a>
                        <a href="{{route('rolelist')}}" class="am-cf">
                            <span class="am-icon-paw"></span> 角色
                        </a>
                        <a href="{{route('Permissionlist')}}" class="am-cf">
                            <span class="am-icon-tachometer"></span> 功能
                            <span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li><a href="{{route('resetpassword')}}"><span class="am-icon-pencil-square-o"></span> 修改账号密码</a></li>
            <li><a href="{{url('admin/logout')}}"><span class="am-icon-sign-out"></span> 注销</a></li>
        </ul>


        <div class="am-panel am-panel-default admin-sidebar-panel">
            <div class="am-panel-bd">
                <p>时光静好，与君语；细水流年，与君同。</p>
            </div>
        </div>

    </div>
</div>