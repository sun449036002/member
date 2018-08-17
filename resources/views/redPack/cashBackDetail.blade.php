@include('header')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>返现申请详情</h5>
            </div>
            <div class="ibox-content">
                <form id="roomSourceForm" method="post" class="form-horizontal" action="#">
                    <input type="hidden" name="id" value="{{$row->id}}" />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">楼盘名称</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->roomSourceName}}</div>
                        <label class="col-sm-2 control-label">楼盘地址</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->address}}</div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">楼盘面积</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->acreage}} m²</div>
                        <label class="col-sm-2 control-label">购房时间</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->buyTime}}</div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">购房人</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->buyers}}</div>
                        <label class="col-sm-2 control-label">联系电话</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->tel}}</div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">购房金额</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->amount}} 万元</div>
                        <label class="col-sm-2 control-label">付款方式</label>
                        <div class="col-sm-3 radio radio-info radio-inline"> {{$row->type ? "全额" : "按揭"}}</div>
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
                        <label class="col-sm-2 control-label">使用红包金额</label>
                        <div class="col-sm-3 radio radio-info radio-inline">xxxx 元</div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">购房凭证</label>
                        <div class="col-sm-5">
                            @if(!empty($row->imgs))
                                <div class="carousel slide" id="carousel1">
                                    <ol class="carousel-indicators">
                                        @foreach($row->imgs as $key => $img)
                                            <li data-slide-to="{{$key}}" data-target="#carousel1"  class="{{$key == 0 ? 'active' : ''}}"></li>
                                        @endforeach
                                    </ol>

                                    <div class="carousel-inner">
                                        @foreach($row->imgs as $key => $img)
                                            <div class="item {{$key == 0 ? 'active' : ''}}">
                                                <input type="hidden" name="imgs[]" value="{{$img}}"/>
                                                <img alt="image"  class="img-responsive" src="{{$img}}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <a data-slide="prev" href="#carousel1" class="left carousel-control">
                                        <span class="icon-prev"></span>
                                    </a>
                                    <a data-slide="next" href="#carousel1" class="right carousel-control">
                                        <span class="icon-next"></span>
                                    </a>
                                </div>
                            @endif
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
</div>
</div>

<script>
    $(document).ready(function() {

    });
</script>
</body>
</html>
