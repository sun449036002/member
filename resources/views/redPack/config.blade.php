@include('header')

<style type="text/css">
    .col-label {
        float: left;
        height: 34px;
        line-height: 34px;
    }
</style>

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
                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">金额范围</label>--}}
                        {{--<div class="col-sm-3">--}}
                            {{--<input type="number" class="form-control" name="minMoney" value="{{$rdConfig->minMoney ?? ""}}" placeholder="最小领取到的总金额，单位元">--}}
                        {{--</div>--}}
                        {{--<div class="col-label">至</div>--}}
                        {{--<div class="col-sm-3">--}}
                            {{--<input type="number" class="form-control" name="maxMoney" value="{{$rdConfig->maxMoney ?? ""}}"  placeholder="最大领取到的总金额，单位元">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">首次领取的金额范围</label>
                        <div class="col-sm-3">
                            <div class="input-group m-b">
                                <input type="number" class="form-control" name="firstMinPercent" value="{{$rdConfig->firstMinPercent ?? ""}}" placeholder="总金额的最小的百分比" min="1" max="100"> <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div class="col-label">至</div>
                        <div class="col-sm-3">
                            <div class="input-group m-b">
                                <input type="number" class="form-control" name="firstMaxPercent" value="{{$rdConfig->firstMaxPercent ?? ""}}" placeholder="总金额的最大的百分比" min="1" max="100"> <span class="input-group-addon">%</span>
                            </div>
                        </div>
                        <div>即，若总金额是500，则设置成40% ~ 60%时，用户在领取每个红包，首次得到的金额在200元~300之间</div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">助力金额范围</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="minAssistanceMoney" value="{{$rdConfig->minAssistanceMoney ?? ""}}" placeholder="最小助力的金额，单位元">
                        </div>
                        <div class="col-label">至</div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="maxAssistanceMoney" value="{{$rdConfig->maxAssistanceMoney ?? ""}}" placeholder="最大助力的金额，单位元">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">剩余助力金额低于</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="remainderAssistanceMoney" value="{{$rdConfig->remainderAssistanceMoney ?? ''}}" placeholder="剩余助力金额低于此值">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">剩余助力金额低于某个值，助力金额范围</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="secondMinAssistanceMoney" value="{{$rdConfig->secondMinAssistanceMoney ?? ''}}" placeholder="单位元">
                        </div>
                        <div class="col-label">至</div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="secondMaxAssistanceMoney" value="{{$rdConfig->secondMaxAssistanceMoney ?? ""}}" placeholder="单位元">
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