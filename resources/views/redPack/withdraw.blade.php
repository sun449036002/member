@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>提现申请列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>申请ID </th>
                        <th>申请人 </th>
                        <th>联系电话 </th>
                        <th>申请状态 </th>
                        <th>申请时间 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->tel}}</td>
                            <td>{{$withdrawStatus[$item->status] ?? "未设定"}}</td>
                            <td>{{date("Y-m-d H:i:s", $item->createTime)}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-to-detail" data-id="{{$item->id}}">查看详情</button>
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
    $(".dataTables-sym").on("click", ".btn.btn-to-detail", function(){
        window.location.href = "/redPack/withdrawDetail?id=" + $(this).data("id");
    });
});
</script>
</body>
</html>
