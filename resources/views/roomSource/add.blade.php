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
                            <div class="form-group"><label class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="name" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">类型</label>
                                <div class="col-sm-10">
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="1" name="type" checked>
                                        <label for="inlineRadio1"> 新房 </label>
                                    </div>
                                    {{--<div class="radio radio-info radio-inline">--}}
                                        {{--<input type="radio" id="inlineRadio2" value="2" name="type">--}}
                                        {{--<label for="inlineRadio2"> 二手房 </label>--}}
                                    {{--</div>--}}
                                    {{--<div class="radio radio-info radio-inline">--}}
                                        {{--<input type="radio" id="inlineRadio3" value="3" name="type">--}}
                                        {{--<label for="inlineRadio3"> 出租房 </label>--}}
                                    {{--</div>--}}
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">装修</label>
                                <div class="col-sm-10">
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio4" value="0" name="decoration" required>
                                        <label for="inlineRadio4"> 毛柸 </label>
                                    </div>
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio5" value="1" name="decoration" required>
                                        <label for="inlineRadio5"> 精装 </label>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">地域</label>
                                <div class="col-sm-5">
                                    <select name="areaId" class="form-control m-b">
                                        <option value="0">请选择地域</option>
                                        @foreach($areaList as $area)
                                            <option value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">分类</label>
                                <div class="col-sm-5">
                                    <select name="roomCategoryId" class="form-control m-b">
                                        <option value="0">请选择分类</option>
                                        @foreach($categoryList as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">户型</label>
                                <div class="col-sm-5">
                                    <select name="houseTypeId" class="form-control m-b">
                                        <option value="0">请选择户型</option>
                                        @foreach($houseTypeList as $houseType)
                                            <option value="{{$houseType->id}}">{{$houseType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">标签</label>
                                <div class="col-sm-5">
                                    <select class="chosen-select form-control m-b" multiple data-placeholder="请选择标签">
                                        @foreach($roomTags as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">均价</label>
                                <div class="col-sm-4">
                                    <div class="input-group m-b">
                                        <input type="number" class="form-control" name="avgPrice" value="">
                                        <span class="input-group-addon">元 / m²</span>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">总价</label>
                                <div class="col-sm-4">
                                    <div class="input-group m-b">
                                        <input type="number" class="form-control" name="totalPrice" value="">
                                        <span class="input-group-addon">万元 起</span>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">首付金额</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="firstPay" value="">
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">面积</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="acreage" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">报备模板</label>
                                <div class="col-sm-5">
                                    <textarea class="form-control report-template" name="reportTemplate"></textarea>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">渠道对接联系人</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="contacts" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">渠道对接电话</label>
                                <div class="col-sm-5"><input type="number" class="form-control" name="tel" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">佣金</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="commission" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">奖励政策</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="rewardPolicy" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">描述</label>
                                <div class="col-sm-8">
                                    <div class="summernote"></div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">封面</label>
                                <div class="col-sm-5 dropzone" id="cover">
                                    <div class="dropzone-previews"></div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">详情轮播图</label>
                                <div class="col-sm-5 dropzone" id="imgs">
                                    <div class="dropzone-previews"></div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">户型图</label>
                                <div class="col-sm-5 dropzone" id="houseTypeImgs">
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
        $('.summernote').summernote();

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        //下拉多选初始化
        $(".chosen-select").chosen();

        //自适应高度
        TextAreaAutoHeight(".report-template");

        //表单提交
        $("#roomSourceForm").on("submit", function(){
            var _findError = false;

            //富文本编辑器内容
            var aHTML = $('.summernote').code(); //save HTML If you need(aHTML: array).
            aHTML =  aHTML === '<p><br></p>' ? "" : aHTML;

            var _dataList = $(this).serializeArray();
            _dataList.push({name:"desc", value:aHTML});
            console.log(_dataList);
            var _fields = {"name":"名称", "roomCategoryId":"类型", "avgPrice":"均价", "acreage":"面积", "houseType":"户型", "desc":"描述"};
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

            //标签多选值数据
            _dataList.push({name:"tagIds", value : $(".chosen-select").val()});

            //Ajax提交表单
            $.ajax({
                type : 'post',
                url : "/roomSource/doAdd",
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

        //封面图
        initCover(appendImgToForm, "{{csrf_token()}}");
        //详情轮播图
        initImgs(appendImgToForm, "{{csrf_token()}}");
        //户型图
        initHouseTypeImgs(appendImgToForm, "{{csrf_token()}}");
    });
</script>
</body>
</html>
