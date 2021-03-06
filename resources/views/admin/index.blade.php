@include('header')
<style type="text/css">
    #qrcode {
        display: flex;
    }

    #qrcode canvas {
        margin: auto;
    }

    .qr-code-tips {
        font-size:16px;
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
                            <th>电话 </th>
                            <th>引荐人 </th>
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
                                <td>{{$item->tel}}</td>
                                <td>{{$item->referrer}}</td>
                                <td>
                                    @if(!empty($item->is_spread))
                                    <button type="button" class="btn btn-success btn-to-spread" data-toggle="modal" data-target="#myModal5" data-id="{{$item->id}}">推广链接</button>
                                    <button type="button" class="btn btn-success btn-to-users" data-id="{{$item->id}}">我的客户</button>
                                    <button type="button" class="btn btn-success btn-transfer-users" data-toggle="modal" data-target="#myModal6" data-id="{{$item->id}}">客户转移</button>
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

                    <div class="form-group"><label class="col-sm-2 control-label">引荐人</label>
                        <div class="col-sm-10">
                            <select name="pid" class="form-control m-b">
                                <option value="0">请选择引荐人</option>
                                @foreach($list as $item)
                                    <option value="{{$item->id}}">{{$item->name . "[" . $item->group_name . "]"}}</option>
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

                    <div class="form-group"><label class="col-sm-2 control-label">电话</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tel" value="">
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

{{-- 业务员专属推广二维码 --}}
<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
                <small class="font-bold qr-code-tips">微信扫码领取500元现金大礼包</small>
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

{{-- 业务员的资源用户转移 --}}
<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <small class="font-bold qr-code-tips">客户资源从<span class="modal-title"></span>转移到另外一个业务员</small>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">转移到</label>
                    <div class="col-sm-10">
                        <select class="toAdminId" name="toAdminId" class="form-control m-b" required>
                            <option value="">请选择转移到哪个用户下</option>
                            @foreach($list as $item)
                                <option value="{{$item->id}}">{{$item->name . "[" . $item->group_name . "]"}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sure-transfer">确认</button>
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

    var fromAdminId = 0;
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green'
    });

    var tableSym = $(".dataTables-sym");
    //展示推广链接
    tableSym.on("click", ".btn.btn-to-spread", function(){
        var name = $(this).parent().parent("tr").find(".td-name").html();
        $("#myModal5").find("h4").html(name);
        $("#qrcode").empty().qrcode('{{env('APP_URL') . "/cash-red-pack?adminId="}}' + $(this).data("id"));
    });

    //更新转移用户的fromAdminID
    tableSym.on("click", ".btn.btn-transfer-users", function(){
        fromAdminId = $(this).data("id");
        var name = $(this).parent().parent("tr").find(".td-name").html();
        $("#myModal6").find(".modal-title").html(name);
    });

    //TO 编辑
    tableSym.on("click", ".btn.btn-to-edit", function(){
       window.location.href = "/admins/" + $(this).data("id") + "/edit";
    });

    //TO 由我推广获得的用户资源
    tableSym.on("click", ".btn.btn-to-users", function(){
        window.location.href = "/admins/resources?adminId=" + $(this).data("id");
    });

    //重置密码
    tableSym.on("click", ".btn.btn-to-reset", function(){
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
    tableSym.on("click", ".btn.btn-to-del", function(){
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

    //用户资源转移
    $("#myModal6").on("click", ".btn-sure-transfer", function(){
        swal({
            title: "确定要转移吗?",
            text: "确认后数据将不能恢复!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定!",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'post',
                url : "/adminResourceTransfer",
                data : {
                    fromAdminId : fromAdminId,
                    toAdminId : $(".toAdminId").val()
                },
                dataType : "json",
                headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                success : function(res){
                    swal({
                            title: res.msg,
                            text: "",
                            type: res.code ? "error" : "info",
                            closeOnConfirm: true
                        },
                        function(){
                            if(!res.code) {
                                window.location.reload();
                            }
                        }
                    );
                }
            });
        });

    });
});
</script>
</body>
</html>
