@include('header')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>红包列表</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-sym">
                        <thead>
                        <tr>
                            <th>红包ID </th>
                            <th>红包所属人 </th>
                            <th>总金额 </th>
                            <th>已收集金额 </th>
                            <th>收集过期时间</th>
                            <th>使用过期时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->total}}</td>
                                <td>{{$item->received}}</td>
                                <td>{{date("Y-m-d H:i:s", $item->expiredTime)}} {{time() > $item->expiredTime ? "【已过期】" : ""}}</td>
                                <td>{{$item->useExpiredTime ? date("Y-m-d H:i:s", $item->useExpiredTime) . (time() > $item->useExpiredTime ? "【已过期】" : "") : ""}}</td>
                                <td>{{$redPackStatusConfig[$item->status]['status']}}</td>
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
        initDataTable();
    });
</script>
</body>
</html>
