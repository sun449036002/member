<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>首页</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="../css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="../js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="../css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="../css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

    <link href="../css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="../css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="../css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

    <link href="../css/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="../css/plugins/dropzone/dropzone.css" rel="stylesheet">

    <link href="../css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="../js/jquery-2.1.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../js/inspinia.js"></script>


    <!-- Sweet alert -->
    <script src="../js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- iCheck -->
    <script src="../js/plugins/iCheck/icheck.min.js"></script>

    <!-- SUMMERNOTE -->
    <script src="../js/plugins/summernote/summernote.min.js"></script>

    <!-- DROPZONE -->
    <script src="../js/plugins/dropzone/dropzone.js"></script>

    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- dataTables  -->
    <script src="../js/plugins/dataTables/datatables.min.js"></script>

    <!-- Toastr -->
    <script src="../js/plugins/toastr/toastr.min.js"></script>
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
                            <img alt="image" class="img-circle" src="../img/profile_small.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">王昆</strong>
                             </span> <span class="text-muted text-xs block">管理员 <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="profile.html">个人信息</a></li>
                            <li><a href="contacts.html">联系方式</a></li>
                            <li><a href="mailbox.html">邮箱</a></li>
                            <li class="divider"></li>
                            <li><a href="login.html">退出登录</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="active">
                    <a href="/"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">首页</span> <span class="fa arrow"></span></a>
                </li>
                {{--<li>--}}
                    {{--<a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">栏目管理</span> <span class="fa arrow"></span></a>--}}
                    {{--<ul class="nav nav-second-level">--}}
                        {{--<li class="active"><a href="/hub">栏目列表</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li>
                    <a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">房源分类管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/roomCategory">分类列表</a></li>
                        <li class="active"><a href="/roomCategory/add">添加分类</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-pie-chart"></i> <span class="nav-label">房源管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/roomSource">房源列表</a></li>
                        <li class="active"><a href="/bespeak">预约列表</a></li>
                        <li class="active"><a href="/roomSource/add">添加房源</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">红包管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/redPack/config">红包配置</a></li>
                        <li class="active"><a href="/redPack/statistics">红包数据统计</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-globe"></i> <span class="nav-label">微信用户管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/user">用户列表</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">客服管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/customService">客服列表</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">业务员管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/salesman">业务员列表</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">管理员管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/admins">管理员列表</a></li>
                        <li class="active"><a href="/admins/add">添加管理员</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">权限管理</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li class="active"><a href="/authority">权限列表</a></li>
                        <li class="active"><a href="/authority/add">添加权限</a></li>
                        <li class="active"><a href="/authority/config">权限设置</a></li>
                    </ul>
                </li>
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
                        <a href="login.html">
                            <i class="fa fa-sign-out"></i> 退出登录
                        </a>
                    </li>
                </ul>

            </nav>
        </div>