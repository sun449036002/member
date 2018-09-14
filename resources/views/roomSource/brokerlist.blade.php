@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>经纪人报名列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>ID </th>
                        <th>报名人 </th>
                        <th>联系电话 </th>
                        <th>提交时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>

                            <td> {{$item->id}}</td>
                            <td> {{$item->name}}</td>
                            <td>{{$item->tel}}</td>
                            <td>{{date("Y-m-d H:i:s", $item->createTime)}}</td>

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
});
</script>
</body>
</html>
