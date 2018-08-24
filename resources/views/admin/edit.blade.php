@include('header')

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>管理员编辑</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="/admins/{{$row->id}}">
                            @method("PUT")
                            @csrf
                            <div class="form-group"><label class="col-sm-2 control-label">姓名</label>

                                <div class="col-sm-10"><input type="text" class="form-control" name="name" value="{{$row->name}}" required></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">登录邮箱</label>

                                <div class="col-sm-10"><input type="email" class="form-control" name="email" value="{{$row->email}}" required readonly></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">用户组</label>
                                <div class="col-sm-10">
                                    <select name="group_id" class="form-control m-b" required>
                                        <option value="">请选择用户分组</option>
                                        @foreach($groupList as $group)
                                            <option value="{{$group->id}}" {{$group->id == $row->group_id ? "selected='selected'" : ""}}>{{$group->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">电话</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tel" value="">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>



                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <div class="i-checks">
                                        <label> <input type="checkbox" name="is_spread" value="1" {{$row->is_spread ? "checked" : ""}}> <i></i> 开通推广功能 </label>
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
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green'
        });
    });
</script>

</body>
</html>
