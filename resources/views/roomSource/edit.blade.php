@include('header')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>房源添加</h5>
            </div>
            <div class="ibox-content">
                <form id="roomSourceForm" method="post" class="form-horizontal" action="#">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$row->id}}" />
                    <div class="form-group"><label class="col-sm-2 control-label">楼盘名称</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name="name" value="{{$row->name}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">楼盘类型</label>
                        <div class="col-sm-10">
                            <div class="radio radio-info radio-inline">
                                <input type="radio" id="inlineRadio1" value="1" name="type" checked>
                                <label for="inlineRadio1"> 新房 </label>
                            </div>
                            {{--<div class="radio radio-info radio-inline">--}}
                            {{--<input type="radio" id="inlineRadio1" value="2" name="type">--}}
                            {{--<label for="inlineRadio1"> 二手房 </label>--}}
                            {{--</div>--}}
                            {{--<div class="radio radio-info radio-inline">--}}
                            {{--<input type="radio" id="inlineRadio1" value="3" name="type">--}}
                            {{--<label for="inlineRadio1"> 出租房 </label>--}}
                            {{--</div>--}}
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">楼盘地域</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name="area" value="{{$row->area}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">楼盘分类</label>
                        <div class="col-sm-5">
                            <select name="roomCategoryId" class="form-control m-b">
                                <option value="0">请选择楼盘分类</option>
                                @foreach($categoryList as $category)
                                    <option value="{{$category->id}}" {{$category->id == $row->roomCategoryId ? "selected" : ""}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">楼盘均价</label>
                        <div class="col-sm-5"><input type="number" class="form-control" name="avgPrice" value="{{$row->avgPrice}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">楼盘面积</label>
                        <div class="col-sm-5"><input type="number" class="form-control" name="acreage" value="{{$row->acreage}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">户型</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name="houseType" value="{{$row->houseType}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">报备模板</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name="reportTemplate" value="{{$row->reportTemplate}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">渠道对接联系人</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name="contacts" value="{{$row->contacts}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">渠道对接电话</label>
                        <div class="col-sm-5"><input type="number" class="form-control" name="tel" value="{{$row->tel}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">佣金</label>
                        <div class="col-sm-5"><input type="number" class="form-control" name="commission" value="{{$row->commission}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">奖励政策</label>
                        <div class="col-sm-5"><input type="text" class="form-control" name="rewardPolicy" value="{{$row->rewardPolicy}}"></div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">描述</label>
                        <div class="col-sm-8">
                            <div class="summernote"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">封面</label>
                        @if(!empty($row->cover))
                        <div class="col-sm-5">
                            <img src="{{$row->cover}}" />
                        </div>
                        @endif
                        <div class="col-sm-4 dropzone" id="cover">
                            <div class="dropzone-previews"></div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label">其他图片</label>
                        <div class="col-sm-5">
                            <div class="carousel slide" id="carousel1">
                                <ol class="carousel-indicators">
                                    @if(!empty($row->imgs))
                                    @foreach($row->imgs as $key => $img)
                                    <li data-slide-to="{{$key}}" data-target="#carousel1"  class="{{$key == 0 ? 'active' : ''}}"></li>
                                    @endforeach
                                    @endif
                                </ol>
                                <div class="carousel-inner">
                                    @if(!empty($row->imgs))
                                    @foreach($row->imgs as $key => $img)
                                    <div class="item {{$key == 0 ? 'active' : ''}}">
                                        <img alt="image"  class="img-responsive" src="{{$img}}">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <a data-slide="prev" href="#carousel1" class="left carousel-control">
                                    <span class="icon-prev"></span>
                                </a>
                                <a data-slide="next" href="#carousel1" class="right carousel-control">
                                    <span class="icon-next"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-4 dropzone" id="imgs">
                            <div class="dropzone-previews"></div>
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
        @if(!empty($row->desc))
        $(".summernote").append(htmlDecode("{{$row->desc}}"));
        @endif

        $('.summernote').summernote();

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        //表单提交
        $("#roomSourceForm").on("submit", function(){
            var _findError = false;

            //富文本编辑器内容
            var aHTML = $('.summernote').code(); //save HTML If you need(aHTML: array).
            aHTML =  aHTML === '<p><br></p>' ? "" : aHTML;

            var _dataList = $(this).serializeArray();
            _dataList.push({name:"desc", value:aHTML});
            console.log(_dataList);
            var _fields = {"name":"楼盘名称", "roomCategoryId":"楼盘类型", "avgPrice":"楼盘均价", "acreage":"楼盘面积", "houseType":"户型", "desc":"楼盘描述"};
            var _keys = Object.keys(_fields);
            $(_dataList).each(function(k, item){
                if (_keys.indexOf(item.name) > -1) {
                    if (item.value === "") {
                        _findError = true;
                        swal((_fields[item.name] || "") + "字段不得为空");
                        return false;
                    }
                }
            });

            if (_findError) {
                return false;
            }

            //Ajax提交表单
            $.ajax({
                type : 'post',
                url : "/roomSource/doEdit",
                data : _dataList,
                dataType : "json",
                headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                success : function(res){
                    swal(res.msg);
                    window.location.href = "/roomSource";
                }
            });

            return false;
        });

        initCover(appendImgToForm, "{{csrf_token()}}");
        initImgs(appendImgToForm, "{{csrf_token()}}");
    });
</script>
</body>
</html>
