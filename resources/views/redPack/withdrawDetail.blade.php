@include('header')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>提现申请详情</h5>
            </div>
            <div class="ibox-content">
                <form id="roomSourceForm" method="post" class="form-horizontal" action="#">
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">申请人</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->name}}</div>
                        <label class="col-sm-2 control-label">联系电话</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->tel}}</div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">返现账号</label>
                        <div class="col-sm-10">
                            @foreach($row->paymentMethodList as $key => $payment)
                                @if(empty($payment)) @continue @endif
                                @if($key == 'alipay')
                                <label class="control-label col-sm-1">支付宝:</label>
                                @elseif($key == 'weixin')
                                <label class="control-label col-sm-1">微信:</label>
                                @else
                                <label class="control-label col-sm-1">银行账号:</label>
                                @endif
                                <div class="col-sm-3 radio radio-info radio-inline">{{$payment}}</div>
                            @endforeach
                        </div>
                    </div>


                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">使用的红包</label>
                        <div class="col-sm-3">
                            @if(!empty($redPackList))
                            <ul class="sortable-list connectList agile-list" id="completed">
                                @foreach($redPackList as $item)
                                <li class="{{$redPackStatusConfig[$item->status]['element-class']}}-element" id="task15">
                                    {{$item->received . " / " . $item->total}} 元
                                    <div class="agile-detail">
                                        <a href="#" class="pull-right btn btn-xs btn-white">{{$item->fromUserId > 0 ? "朋友赠送的" : "自己的"}}</a>
                                        <i class="fa fa-clock-o"></i> 红包状态:{{$redPackStatusConfig[$item->status]['status'] ?? '未知道'}}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">驳回原因</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="remark" value="" placeholder="驳回原因"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary btn-withdraw btn-pass" data-status="1" type="button">通过</button>
                            <button class="btn btn-primary btn-withdraw btn-no-pass" data-status="2" type="button">不通过</button>
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
        $(".btn.btn-withdraw").on("click", function() {
            var self = $(this);
            var status = self.data("status");
            var title = "通过";
            var text = "通过后若有红包，则红包的状态将置为已使用状态，且不能恢复!";
            if (status === 2) {
                title = "驳回";
                text = "驳回时，红包状态不变";
                if($("input[name='remark']").val() === "") {
                    swal("驳回原因不能为空");
                    return false;
                }
            }
            swal({
                title: "确定要" + title + "审核吗?",
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定!",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type : 'post',
                    url : "/redPack/withdrawExamine",
                    data : {
                        id : "{{$row->id}}",
                        status : status
                    },
                    dataType : "json",
                    headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                    success : function(res){
                        swal(res.msg);
                        window.location.href = "/redPack/withdraw";
                    }
                });
            });
        })
    });
</script>
</body>
</html>
