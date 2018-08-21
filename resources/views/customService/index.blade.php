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
                <h5>客服列表</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-sym">
                        <thead>
                        <tr>
                            <th>ID </th>
                            <th>姓名 </th>
                            <th>电话 </th>
                            <th>创建时间 </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td class="td-name">{{$item->name}}</td>
                                <td>{{$item->tel}}</td>
                                <td>{{date("Y-m-d H:i:s", $item->creatTime)}}</td>
                                <td>
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
                <h5>客服添加</h5>
            </div>
            <div class="ibox-content">
                <form method="post" class="form-horizontal" action="/customService">
                    {{csrf_field()}}
                    <div class="form-group"><label class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="name" value="" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">联系电话</label>
                        <div class="col-sm-10">
                            <input id="tel" type="tel" class="form-control" name="tel" value="" required >
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
    $(".dataTables-sym").on("click", ".btn.btn-to-edit", function(){
       window.location.href = "/customService/" + $(this).data("id") + "/edit";
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
            confirmButtonText: "确定!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'delete',
                url : "/customService/" + self.data("id") || 0,
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
