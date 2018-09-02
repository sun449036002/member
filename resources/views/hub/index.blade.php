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
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>栏目ID </th>
                        <th>栏目名称 </th>
                        <th>子级栏目 </th>
                        <th>链接地址 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                @if(!empty($item->sublist))
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>栏目ID </th>
                                        <th>栏目名称 </th>
                                        <th>链接地址 </th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($item->sublist as $subItem)
                                        <tr>
                                            <td>{{$subItem->id}}</td>
                                            <td>{{$subItem->name}}</td>
                                            <td>{{$subItem->url}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-to-edit" data-id="{{$subItem->id}}">编辑</button>
                                                <button type="button" class="btn btn-primary btn-to-del" data-id="{{$subItem->id}}">删除</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </td>
                            <td>{{$item->url}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-to-edit" data-id="{{$item->id}}">编辑</button>
                                <button type="button" class="btn btn-primary btn-to-del" data-id="{{$item->id}}">删除</button>
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
            <h5>栏目添加</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form method="post" class="form-horizontal" action="/hub/doAdd">
                {{csrf_field()}}
                <div class="form-group"><label class="col-sm-2 control-label">名称</label>
                    <div class="col-sm-3"><input type="text" class="form-control" name="name"></div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label">链接地址</label>
                    <div class="col-sm-3"><input type="text" class="form-control" name="url"></div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label">上级栏目名称</label>
                    <div class="col-sm-3">
                        <select class="form-control m-b" name="pid">
                            <option value="0">顶级菜单</option>
                            @foreach($list as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
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
    initDataTable();

    //TO 编辑
    $(".btn.btn-to-edit").on("click", function(){
        window.location.href = "/hub/edit?id=" + $(this).data("id");
    });

    //TO 删除
    $(".btn.btn-to-del").on("click", function(){
        var self = $(this);
        swal({
            title: "确定要删除吗?",
            text: "删除后将不能恢复!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'post',
                url : "/hub/del",
                data : {
                    id : self.data("id") || 0
                },
                dataType : "json",
                headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                success : function(res){
                    swal(res.msg);
                    window.location.reload();
                }
            });
        });

    });
});
</script>
</body>
</html>
