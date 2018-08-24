@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>预约列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>预约ID </th>
                        <th>楼盘名称 </th>
                        <th>推广员 </th>
                        <th>预约人 </th>
                        <th>预约电话 </th>
                        <th>预约人数 </th>
                        <th>接送地址 </th>
                        <th>接送时间 </th>
                        <th>预约状态 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->roomSourceName}}</td>
                            <td>{{$item->adminName}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->tel}}</td>
                            <td>{{$item->num}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->time}}</td>
                            <td>
                                @if($item->status == 0)
                                <span class="badge">未完成</span>
                                @elseif($item->status == 1)
                                <span class="badge badge-success">已完成</span>
                                @else
                                <span class="badge badge-warning">已取消</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 0)
                                <button type="button" class="btn btn-primary btn-change-status btn-to-over" data-id="{{$item->id}}">完成</button>
                                <button type="button" class="btn btn-primary btn-change-status btn-to-cancel" data-id="{{$item->id}}">取消</button>
                                @elseif($item->status == 1 || $item->status == 2)
                                <button type="button" class="btn btn-primary btn-change-status btn-to-reset" data-id="{{$item->id}}">重置为未完成</button>
                                @endif
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

    //TO 完成
    $(".btn.btn-change-status").on("click", function(){
        var self = $(this);

        var status = 1;
        var title = "确定完成此预约吗?";
        if (self.hasClass("btn-to-cancel")) {
            status = 2;
            title = "确定取消此预约吗？"
        } else if (self.hasClass("btn-to-reset")) {
            status = 0;
            title = "确定重置此预约为未完成状态吗？"
        }
        swal({
            title: title,
            text: "事后可再此重新变更!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'get',
                url : "/bespeak/change",
                data : {
                    id : self.data("id") || 0,
                    status : status
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
