@include('header')

<div class="row">
    <div class="col-lg-8">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>管理员组别列表</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-sym">
                        <thead>
                        <tr>
                            <th>ID </th>
                            <th>组名 </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-to-auth" data-id="{{$item->id}}">权限管理</button>
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
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>管理员组别添加</h5>
            </div>
            <div class="ibox-content">
                <form method="post" class="form-horizontal" action="/adminGroups">
                    {{csrf_field()}}
                    <div class="form-group"><label class="col-sm-2 control-label">分组名称</label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="name" value=""></div>
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
    //TO 权限管理
    $(".btn.btn-to-auth").on("click", function(){
        window.location.href = "/authority/" + $(this).data("id") + "/edit";
    });
    //TO 编辑
    $(".btn.btn-to-edit").on("click", function(){
        var self = $(this);
        window.location.href = "/adminGroups/" + self.data("id") + "/edit";
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
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'delete',
                url : "/adminGroups/" + self.data("id") || 0,
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
