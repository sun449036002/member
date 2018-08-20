@include('header')

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>广告列表</h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-sym">
                    <thead>
                    <tr>
                        <th>广告ID </th>
                        <th>广告标题 </th>
                        <th>跳转链接 </th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($list))
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->url}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-to-edit" data-id="{{$item->id}}">编辑</button>
                                <button type="button" class="btn btn-primary btn-to-del" data-id="{{$item->id}}">删除</button>
                            </td>
                        </tr>
                    @endforeach
                    @endif
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

    //TO 编辑
    $(".dataTables-sym").on("click", ".btn.btn-to-edit", function(){
        window.location.href = "/ads/" + $(this).data("id") + "/edit";
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
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                type : 'delete',
                url : "/ads/" + self.data("id") || 0,
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
