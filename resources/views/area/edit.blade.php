@include('header')

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>地域编辑</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="/area/{{$row->id}}">
                            @method("PUT")
                            @csrf
                            <div class="form-group"><label class="col-sm-2 control-label">名称</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="name" value="{{$row->name}}"></div>
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


</body>
</html>
