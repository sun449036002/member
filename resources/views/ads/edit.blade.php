@include('header')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>广告添加</h5>
            </div>
            <div class="ibox-content">
                <form id="roomSourceForm" method="post" class="form-horizontal" action="/ads/{{$row->id}}">
                    @method("PUT")
                    {{csrf_field()}}
                    <div class="form-group"><label class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="title" value="{{$row->title}}"></div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">跳转链接</label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="url" value="{{$row->url}}"></div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">广告图片</label>
                        @if(!empty($row->img))
                            <div class="col-sm-3">
                                <input type="hidden" name="img" value="{{$row->img}}" />
                                <img src="{{$row->img}}" width="200px"/>
                            </div>
                        @endif
                        <div class="col-sm-4">
                            <div class="col-sm-12 dropzone" id="cover">
                                <div class="dropzone-previews"></div>
                            </div>
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
        initCover(appendImgToForm, "{{csrf_token()}}", "img");
    });
</script>
</body>
</html>
