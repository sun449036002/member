@include('header')
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>房源添加</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="/roomSource/doAdd">
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
        $('.summernote').summernote();

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
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
                this.on("successmultiple", function(files, response) {
                    console.log(files, response);
                });
                this.on("errormultiple", function(files, response) {
                });
            }
        };

        //封面图片上传
        Dropzone.options.imgs = {
            url:"/img/upload",
            paramName:"imgs",
            headers:{"X-CSRF-TOKEN" : "{{csrf_token()}}"},
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 5,
            maxFiles: 5,

            // Dropzone settings
            init: function() {
                var myDropzone = this;

                this.on("sendingmultiple", function() {
                });
                this.on("successmultiple", function(files, response) {
                    console.log(files, response);
                });
                this.on("errormultiple", function(files, response) {
                });
            }
        };
    });
</script>
</body>
</html>
