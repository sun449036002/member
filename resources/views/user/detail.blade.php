@include('header')

<div class="wrapper wrapper-content">
    <div class="row animated fadeInRight">
        <div class="col-md-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>个人信息</h5>
                </div>
                <div>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="image" class="img-responsive" src="{{$row->avatar_url}}">
                    </div>
                    <div class="ibox-content profile-content">
                        <h4><strong>{{$row->username}}</strong></h4>
                        <p><i class="fa fa-map-marker"></i> {{$row->info->country}} - {{$row->info->province}} - {{$row->info->city}}</p>
                        <h5>
                            个人简介
                        </h5>
                        <p>性别: {{$row->info->sex == 1 ? "男" : "女"}}</p>
                        <p>关注状态 :{{$row->is_subscribe ? "已关注" : "未关注"}}</p>
                        <p>关注途径 :{{$subscribeChannel[$row->info->subscribe_scene] ?? "未知"}}</p>
                        <p>关注时间 :{{date("Y-m-d H:i:s", $row->info->subscribe_time)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>详细</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div>
                        <div class="feed-activity-list">
                            <div class="feed-element">
                                <div class="media-body ">
                                    <div>余额：{{$row->balance}} 元</div>
                                </div>
                            </div>
                            <div class="feed-element">
                                <div class="media-body ">
                                    <div>为别人助力次数：{{$recordCount}} 次</div>
                                </div>
                            </div>
                            <div class="feed-element">
                                <div class="media-body ">
                                    <div>红包记录：{{$redPackCount}} 个</div>
                                </div>
                            </div>
                            <div class="feed-element">
                                <div class="media-body ">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">推广员绑定</label>
                                        <div class="col-sm-10">
                                            <select class="toAdminId" name="toAdminId" class="form-control m-b" required>
                                                <option value="">请选择绑定到哪个推广员</option>
                                                @foreach($list ?? [] as $item)
                                                    <option value="{{$item->id}}" {{$item->id == $row->admin_id ? "selected='selected'" : ""}}>{{$item->name . "[" . $item->group_name . "]"}}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-primary btn-sm btn-change-admin-id">更换</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".btn-change-admin-id").on("click", function(){
            swal({
                title: "确定要变更绑定吗?",
                text: "确认后数据将不能恢复!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定!",
                showLoaderOnConfirm: true,
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type : 'post',
                    url : "/user/changeAdminId",
                    data : {
                        id : "{{$row->id}}",
                        toAdminId : $(".toAdminId").val()
                    },
                    dataType : "json",
                    headers : {"X-CSRF-TOKEN" : "{{csrf_token()}}"},
                    success : function(res){
                        swal({
                                title: res.msg,
                                text: "",
                                type: res.code ? "error" : "info",
                                closeOnConfirm: true
                            },
                            function(){
                                if(!res.code) {
                                    window.location.reload();
                                }
                            }
                        );
                    }
                });
            });
        })
    });
</script>