@include('header')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>用户资源列表</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-sym">
                        <thead>
                        <tr>
                            <th>ID </th>
                            <th>头像 </th>
                            <th>用户名 </th>
                            <th>关注时间 </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td><img src="{{$item->avatar_url}}"  width="30" height="30" /></td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->subscribe_time}}</td>
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