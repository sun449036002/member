@include('header')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>红包配置</h5>
            </div>
            <div class="ibox-content">
                <form id="redPackConfigForm" method="post" class="form-horizontal" action="#">
                    <input type="hidden" name="id" value="{{$rdConfig->id ?? 0}}"/>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">金额范围</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="minMoney" value="{{$rdConfig->minMoney ?? ""}}">
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="maxMoney" value="{{$rdConfig->maxMoney ?? ""}}">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-sm-2 control-label">助力金额范围</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="minAssistanceMoney" value="{{$rdConfig->minAssistanceMoney ?? ""}}">
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="maxAssistanceMoney" value="{{$rdConfig->maxAssistanceMoney ?? ""}}">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white btn-submit" type="submit">取消</button>
                            <button class="btn btn-primary" type="submit">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#redPackConfigForm").on("submit", function(){
            var _data = $(this).serializeArray();
            //Ajax提交表单
            $.ajax({
                type : 'post',
                url : "/redPack/saveConfig",
                data : _data,
                dataType : "json",
                headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                success : function(res){
                    swal(res.msg);
                    window.location.href = "/redPack/config";
                }
            });
            return false;
        })
    });
</script>