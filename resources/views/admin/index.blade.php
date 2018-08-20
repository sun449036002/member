@include('header')
<style type="text/css">
    #qrcode {
        display: flex;
    }

    #qrcode canvas {
        margin: auto;
    }
</style>
<script type="text/javascript" src="{{asset('js/jquery.qrcode.min.js')}}"></script>

<div class="row">
    <div class="col-lg-8">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>管理员列表</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-sym">
                        <thead>
                        <tr>
                            <th>ID </th>
                            <th>姓名 </th>
                            <th>用户组 </th>
                            <th>登录名 </th>
                            <th>创建时间 </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td class="td-name">{{$item->name}}</td>
                                <td>{{$item->group_name ?? "未分配"}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    @if(!empty($item->is_spread))
                                    <button type="button" class="btn btn-success btn-to-spread" data-toggle="modal" data-target="#myModal5" data-id="{{$item->id}}">推广链接</button>
                                    @endif
                                    <button type="button" class="btn btn-primary btn-to-reset" data-id="{{$item->id}}">重置密码</button>
                                    <button type="button" class="btn btn-primary btn-to-edit" data-id="{{$item->id}}">编辑</button>
                                    <button type="button" class="btn btn-danger btn-to-del" data-id="{{$item->id}}">删除</button>
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
                <h5>管理员添加</h5>
            </div>
            <div class="ibox-content">
                <form method="post" class="form-horizontal" action="/admins">
                    {{csrf_field()}}
                    <div class="form-group"><label class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="name" value=""></div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">用户组</label>
                        <div class="col-sm-10">
                            <select name="group_id" class="form-control m-b" required>
                                <option value="">请选择用户分组</option>
                                @foreach($groupList as $group)
                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">登录邮箱</label>
                        <div class="col-sm-10">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required >
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">登录密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" value="" required>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <div class="i-checks">
                                <label> <input type="checkbox" name="is_spread" value="1"> <i></i> 开通推广功能 </label>
                            </div>
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

<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
                <small class="font-bold">这是您的推广二维码，微信扫码后分享后推广</small>
            </div>
            <div class="modal-body">
                <div id="qrcode"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<script>
$(document).ready(function() {
    initDataTable();

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green'
    });

    //展示推广链接
    $(".dataTables-sym").on("click", ".btn.btn-to-spread", function(){
        $("#qrcode").empty();
        var name = $(this).parent().parent("tr").find(".td-name").html();
        $("#myModal5").find("h4").html(name);
        $("#qrcode").qrcode('{{env('APP_URL') . "/cash-red-pack?adminId="}}' + $(this).data("id"));
    });

    //TO 编辑
    $(".dataTables-sym").on("click", ".btn.btn-to-edit", function(){
       window.location.href = "/admins/" + $(this).data("id") + "/edit";
    });

    //重置密码
    $(".dataTables-sym").on("click", ".btn.btn-to-reset", function(){
        var self = $(this);
        swal({
            title: "确定要重置密码吗?",
            text: "重置后将不能恢复!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'post',
                url : "/admins/resetPwd",
                data : {
                    id : self.data("id") || 0
                },
                dataType : "json",
                headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                success : function(res){
                    swal(res.msg);
                }
            });
        });
    });

    //TO 删除
    $(".dataTables-sym").on("click", ".btn.btn-to-del", function(){
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
                url : "/admins/" + self.data("id") || 0,
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
