@include('header')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>基本信息设置</h5>
            </div>
            <div class="ibox-content">
                <form id="about-us-form" method="post" class="form-horizontal" action="#">
                    <input type="hidden" name="id" value="{{$row->id ?? ""}}" />
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">短信通知接收电话</label>
                        <div class="col-sm-5"><input type="number" class="form-control" name="smsTel" value="{{$row->smsTel ?? ""}}"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">关于我们</label>
                        <div class="col-sm-8">
                            <div class="summernote"></div>
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
    @if(!empty($row->aboutUs))
    $(".summernote").append(htmlDecode("{{$row->aboutUs}}"));
    @endif

    $('.summernote').summernote();

    //表单提交
    $("#about-us-form").on("submit", function(){
        //富文本编辑器内容
        var aHTML = $('.summernote').code(); //save HTML If you need(aHTML: array).
        aHTML =  aHTML === '<p><br></p>' ? "" : aHTML;

        var _dataList = $(this).serializeArray();
        _dataList.push({name:"aboutUs", value:aHTML});

        //Ajax提交表单
        $.ajax({
            type : 'post',
            url : "/system/saveAboutUs",
            data : _dataList,
            dataType : "json",
            headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
            success : function(res){
                swal(res.msg);
                window.location.reload();
            }
        });

        return false;
    });
});
</script>

</body>
</html>
