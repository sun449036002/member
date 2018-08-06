@include('header')
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>房源添加</h5>
                    </div>
                    <div class="ibox-content">
                        <form id="roomSourceForm" method="post" class="form-horizontal" action="/roomSource/doAdd">
                            {{csrf_field()}}
                            <div class="form-group"><label class="col-sm-2 control-label">楼盘名称</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="name" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">楼盘类型</label>
                                <div class="col-sm-10">
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="1" name="type">
                                        <label for="inlineRadio1"> 新房 </label>
                                    </div>
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="2" name="type">
                                        <label for="inlineRadio1"> 二手房 </label>
                                    </div>
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="3" name="type">
                                        <label for="inlineRadio1"> 出租房 </label>
                                    </div>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">楼盘分类</label>
                                <div class="col-sm-5">
                                    <select name="roomCategoryId" class="form-control m-b">
                                        <option value="0">请选择楼盘分类</option>
                                        @foreach($categoryList as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">楼盘均价</label>
                                <div class="col-sm-5"><input type="number" class="form-control" name="avgPrice" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">楼盘面积</label>
                                <div class="col-sm-5"><input type="number" class="form-control" name="acreage" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">户型</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="houseType" value=""></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">报备模板</label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="reportTemplate" value=""></div>
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
                                <div class="col-sm-5"><input type="number" class="form-control" name="commission" value=""></div>
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
                            <div class="form-group"><label class="col-sm-2 control-label">其他图片</label>
                                <div class="col-sm-5 dropzone" id="imgs">
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
    //添加图片到Form中
    var appendImgToForm = function (response, keyName) {
        if (response.code > 0) {
            swal(response.msg || "Upload Failed");
            return false;
        }
        $(response.imgs).each(function (k,v) {
            $("#roomSourceForm").append("<input type='hidden' name='" + keyName + "' value='" + v + "'/>");
        })
    };

    $(document).ready(function() {
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
            _findError = aHTML === '<p><br></p>';
            if (_findError) {
                swal("描述内容不得为空");
//                return false;
            }

            var _dataList = $(this).serializeArray();
            var _fields = {"name":"楼盘名称", "roomCategoryId":"楼盘类型", "avgPrice":"楼盘均价", "acreage":"楼盘面积", "houseType":"户型"};
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

           return !_findError;
        });

        //封面图片上传
        Dropzone.options.cover = {
            url:"/img/upload",
            paramName:"cover",
            headers:{"X-CSRF-TOKEN" : "{{csrf_token()}}"},
            autoProcessQueue: true,
            uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,

            // Dropzone settings
            init: function() {
                var myDropzone = this;

                this.on("sendingmultiple", function() {
                });
                this.on("success", function(files, response) {
                    appendImgToForm(response, "cover");
                });
                this.on("successmultiple", function(files, response) {
                });
                this.on("errormultiple", function(files, response) {
                });
            }
        };

        //其他图片上传
        Dropzone.options.imgs = {
            url:"/img/upload",
            paramName:"imgs",
            headers:{"X-CSRF-TOKEN" : "{{csrf_token()}}"},
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,

            // Dropzone settings
            init: function() {
                var myDropzone = this;

                this.on("sendingmultiple", function() {
                });
                this.on("successmultiple", function(files, response) {
                    appendImgToForm(response, "imgs[]");
                });
                this.on("errormultiple", function(files, response) {
                });
            }
        };
    });
</script>
</body>
</html>
