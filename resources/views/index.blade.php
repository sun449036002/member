@include('header')
<script type="text/javascript" src="{{asset('js/plugins/chartJs/Chart.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var doughnutData = [
            {
                value: {{$total}},
                color: "#a3e1d4",
                highlight: "#1ab394",
                label: "总关注人数"
            },
            {
                value: {{$todayTotal}},
                color: "#b5b8cf",
                highlight: "#1ab394",
                label: "今日关注人数"
            }
        ];

        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 45, // This is 0 for Pie charts
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            responsive: true,
        };


        var ctx = document.getElementById("doughnutChart").getContext("2d");
        var myNewChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
    });
</script>

<div class="row  border-bottom white-bg dashboard-header">

    <div class="col-sm-3">
        <h2>欢迎您，{{$admin->name}}</h2>
    </div>

</div>

<div class="row">

    <div class="col-lg-4">
        <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>微信用户关注数据图表 </h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="doughnutChart" height="140"></canvas>
                </div>
                <div>总关注人数:{{$total}}人</div>
                <div>今日关注人数:{{$todayTotal}}人</div>
            </div>
        </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-primary pull-right">今日</span>
                <h5>预约单数</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{$todayTotalBespeakNum}} 单</h1>
                @if(!empty($todayTotalBespeakNum))
                <div class="stat-percent font-bold text-navy">60% <i class="fa fa-level-up"></i></div>
                @endif
            </div>
        </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>未完成的看房预约</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>

                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content inspinia-timeline">

                            @foreach($bespeakList as $item)
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-xs-3 date">
                                        <i class="fa fa-briefcase"></i>
                                        {{$item->time}}
                                        <br/>
                                        <small class="text-navy"></small>
                                    </div>
                                    <div class="col-xs-7 content no-top-border">
                                        <p class="m-b-xs"><strong>{{$item->name}}</strong></p>

                                        <p>预约地址:{{$item->address}}</p>

                                        <p><span data-diameter="40" class="updating-chart">联系电话:{{$item->tel}}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>