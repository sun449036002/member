@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>返现申请列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>申请ID </th>
                        <th>楼盘名称 </th>
                        <th>楼盘地址 </th>
                        <th>楼盘面积 </th>
                        <th>购房人 </th>
                        <th>购房金额 </th>
                        <th>购房时间 </th>
                        <th>联系电话 </th>
                        <th>付款方式 </th>
                        <th>申请状态 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->roomSourceName}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->acreage}}</td>
                            <td>{{$item->buyers}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{$item->buyTime}}</td>
                            <td>{{$item->tel}}</td>
                            <td>{{$item->type ? "按揭" : "全额"}}</td>
                            <td>{{$item->status ? "已通过" : "未通过"}}</td>
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
        window.location.href = "/redPack/cashBackDetail?id=" + $(this).data("id");
    });
});
</script>
</body>
</html>
