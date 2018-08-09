@include('header')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>权限列表</h5>
            </div>
            <div class="ibox-content">
                <form id="authForm" method="post" class="form-horizontal" action="/authority">
                    <input type="hidden" name="id" value="{{$group_id}}"/>
                    @csrf
                    <div id="jstree1">

                    </div>

                    <div id="event_result" style="display: none;"></div>

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


<style>
    ul li {
        list-style-type: none;
    }
    .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }

    .jstree-default .jstree-icon.none {
        width: 0;
    }
</style>
<script>
$(document).ready(function() {
    var treejson = JSON.parse(htmlDecode("{{$treeJson}}"));
    $('#jstree1').jstree({
        'core' : {
            'check_callback' : true,
            'data' : treejson
        },
        'plugins' : ['wholerow', 'checkbox'],
    }).on('changed.jstree', function (e, data) {
        $("#event_result").empty();
        for(var i = 0, j = data.selected.length; i < j; i++) {
            console.log(data.instance.get_node(data.selected[i]).li_attr.route);
//            console.log(data.instance.get_node(data.selected[i]).data.route);
            $("#event_result").append("<input type='hidden' name='route[]' value='" + (data.instance.get_node(data.selected[i]).li_attr.route || "") + "'>");
        }
    });
});
</script>
</body>
</html>
