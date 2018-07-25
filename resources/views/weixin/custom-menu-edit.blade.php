@include('header')

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
                        <form method="post" class="form-horizontal" action="/weixin/custom-menu-do-edit">
                            {{csrf_field()}}
                            <input  type="hidden" name="id" value="{{$row->id}}" />
                            <div class="form-group"><label class="col-sm-2 control-label">菜单名称</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="name" value="{{$row->name}}"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">链接地址</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="url" value="{{$row->url}}"></div>
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

    });
</script>
</body>
</html>
