@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>微信用户列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>用户ID </th>
                        <th>用户URI </th>
                        <th>用户名称 </th>
                        <th>openid </th>
                        <th>状态 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->uri}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->openid}}</td>
                            <td>
                                <span class="badge {{$item->is_subscribe ? "badge-success" : ""}}">{{$item->is_subscribe ? "已关注" : "未关注"}}</span>
                                <span class="badge {{$item->lock ? "badge-warning" : "badge-success"}}">{{$item->lock ? "冻结中" : "正常"}}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-to-detail" data-id="{{$item->id}}">详情</button>
                                <button type="button" class="btn btn-primary btn-to-lock" data-id="{{$item->id}}">{{$item->lock ? "解冻" : "冻结"}}</button>
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

</div>
</div>

<script>
$(document).ready(function() {
    initDataTable();

    //TO 详情
    $(".dataTables-sym").on("click", ".btn-to-detail", function () {
        window.location.href = "/user/detail?id=" + $(this).data("id");
    });

    //TO 冻结
    $(".dataTables-sym").on("click", ".btn.btn-to-lock", function(){
        var self = $(this);
        var optName = self.text();
        swal({
            title: "确定要" + optName + "吗?",
            text: optName + "后可在此恢复!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定!",
            cancelButtonText:"取消",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'post',
                url : "/user/lock",
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
