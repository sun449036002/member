@include('header')

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>自定义菜单列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">配置选项 1</a>
                                </li>
                                <li><a href="#">配置选项 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>菜单名称 </th>
                                    <th>菜单类型 </th>
                                    <th>菜单地址</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($menuList as $menu)
                                    <tr>
                                        <td>{{$menu->name}}</td>
                                        <td>{{$menu->type}}</td>
                                        <td><a href="{{$menu->url}}" target="_blank">{{$menu->url}}</a></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-to-edit" data-id="{{$menu->id}}">编辑</button>
                                            <button type="button" class="btn btn-primary btn-to-del" data-id="{{$menu->id}}">删除</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>自定义菜单添加</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">配置选项 1</a>
                                </li>
                                <li><a href="#">配置选项 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="/weixin/custom-menu-create">
                            {{csrf_field()}}
                            <div class="form-group"><label class="col-sm-2 control-label">菜单名称</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="name"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">链接地址</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="url"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-white" type="submit">取消</button>
                                    <button class="btn btn-primary" type="submit">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //TO 编辑
        $(".btn.btn-to-edit").on("click", function(){
            window.location.href = "/weixin/custom-menu-edit?id=" + $(this).data("id");
        });

        //TO 删除
        $(".btn.btn-to-del").on("click", function(){
            $.ajax({
                type : 'post',
                url : "/weixin/custom-menu-del",
                data : {
                    id : $(this).data("id") || 0
                },
                dataType : "json",
                headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                success : function(res){
                    alert(res.msg);
                    window.location.reload();
                }
            });
        });
    });
</script>
</body>
</html>
