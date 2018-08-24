@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>房源列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>楼盘ID </th>
                        <th>楼盘名称 </th>
                        <th>楼盘地域 </th>
                        <th>楼盘户型 </th>
                        <th>楼盘面积 </th>
                        <th>楼盘均价 </th>
                        <th>更新时间 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->area}}</td>
                            <td>{{$item->houseType}}</td>
                            <td>{{$item->acreage}}</td>
                            <td>{{$item->avgPrice}}</td>
                            <td>{{date("Y-m-d H:i:s", $item->updateTime)}}</td>
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

</div>
</div>

<script>
$(document).ready(function() {
    initDataTable(6);

    //TO 编辑
    $(".dataTables-sym").on("click", ".btn.btn-to-edit", function(e){
        console.log(e);
        window.location.href = "/roomSource/edit?id=" + $(this).data("id");
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
                type : 'post',
                url : "/roomSource/del",
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
