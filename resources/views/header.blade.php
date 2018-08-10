<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>首页</title>

    <link href="{{asset("css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("css/animate.css")}}" rel="stylesheet">
    <link href="{{asset("css/style.css")}}" rel="stylesheet">
    <link href="{{asset("css/style.css")}}" rel="stylesheet">
    <link href="{{asset("font-awesome/css/font-awesome.css")}}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{asset("css/plugins/toastr/toastr.min.css")}}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{asset("js/plugins/gritter/jquery.gritter.css")}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{asset("css/plugins/sweetalert/sweetalert.css")}}" rel="stylesheet">
    <link href="{{asset("css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css")}}" rel="stylesheet">

    <link href="{{asset("css/plugins/iCheck/custom.css")}}" rel="stylesheet">

    <link href="{{asset("css/plugins/summernote/summernote.css")}}" rel="stylesheet">
    <link href="{{asset("css/plugins/summernote/summernote-bs3.css")}}" rel="stylesheet">

    <link href="{{asset("css/plugins/dropzone/basic.css")}}" rel="stylesheet">
    <link href="{{asset("css/plugins/dropzone/dropzone.css")}}" rel="stylesheet">

    <link href="{{asset("css/plugins/dataTables/datatables.min.css")}}" rel="stylesheet">
    <link href="{{asset("css/plugins/jsTree/style.min.css")}}" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="{{asset("js/jquery-2.1.1.js")}}"></script>
    <script src="{{asset("js/bootstrap.min.js")}}"></script>
    <script src="{{asset("js/plugins/metisMenu/jquery.metisMenu.js")}}"></script>
    <script src="{{asset("js/plugins/slimscroll/jquery.slimscroll.min.js")}}"></script>
    <script src="{{asset("js/inspinia.js")}}"></script>


    <!-- Sweet alert -->
    <script src="{{asset("js/plugins/sweetalert/sweetalert.min.js")}}"></script>

    <!-- iCheck -->
    <script src="{{asset("js/plugins/iCheck/icheck.min.js")}}"></script>

    <!-- SUMMERNOTE -->
    <script src="{{asset("js/plugins/summernote/summernote.min.js")}}"></script>

    <!-- DROPZONE -->
    <script src="{{asset("js/plugins/dropzone/dropzone.js")}}"></script>

    <script src="{{asset("js/plugins/pace/pace.min.js")}}"></script>

    <!-- dataTables  -->
    <script src="{{asset("js/plugins/dataTables/datatables.min.js")}}"></script>

    <!-- JS Tree -->
    <script src="{{asset("js/plugins/jsTree/jstree.min.js")}}"></script>

    <!-- Toastr -->
    <script src="{{asset("js/plugins/toastr/toastr.min.js")}}"></script>
    <script>
        $(document).ready(function(){
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            @if(count($errors)>0)
                @foreach($errors->all() as $value)
                    toastr.error('{{$value}}', '错误提示');
                @endforeach
            @endif
        });
    </script>

</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{asset("img/profile_small.jpg")}}" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{$admin->name}}</strong>
                             </span> <span class="text-muted text-xs block">{{$adminGroupName}} </span> </span> </a>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                @if(!empty($menuList))
                    @foreach($menuList as $menu)
                    <li class="{{($menu['active'] ?? 0) ? "active" : ""}}">
                        <a href="{{$menu['route']}}"><i class="fa {{$menu['icon'] ?? 'fa-desktop'}}"></i> <span class="nav-label">{{$menu['title']}}</span> <span class="fa arrow"></span></a>
                        @if(!empty($menu['subMenuList']))
                        <ul class="nav nav-second-level">
                            @foreach($menu['subMenuList'] as $subMenu)
                            <li class="active"><a href="{{$subMenu['route']}}">{{$subMenu['title']}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">欢迎来到管理后台</span>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> 退出登录
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{csrf_field()}}
                        </form>
                    </li>
                </ul>

            </nav>
        </div>