<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'amcharts/amcharts', 'amcharts/serial', 'amcharts/themes/light', 'amcharts/plugins/dataloader/dataloader.min'));
?>
<div class="page-header">
    <h3 class="text-default"><?php echo $_report_type[$type]; ?></h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<span class="pull-right">Choose Year Range: <input id="yearStart" class="easyui-numberspinner" data-options="min:2013,max:2099,prompt:'-- year --'" value="<?php echo (isset($from_year)&&trim($from_year)!=''?$from_year:''); ?>" type="text" style="width:85px;"/> - <input id="yearEnd" class="easyui-numberspinner" data-options="min:2013,max:2099,prompt:'-- year --'" value="<?php echo (isset($to_year)&&trim($to_year)!=''?$to_year:''); ?>" type="text" style="width:85px;"/> <?php echo $this->Html->link('Go', array(), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Apply filter', "data-options"=>"iconCls:'icon-filter'", "data-url"=>$this->Html->url(array($type)), "style"=>"padding: 0px 0px 0px 0px;", "id"=>"filtercumulativeparticipants"));?>
						</span>
						<div class="clearfix"></div>
				</div>
		</div>
</div>
<div class="box">
		<div id="StatisticChart" style="height:600px;width:100%;"></div>
    <script type="text/javascript">
        var $cumulativeParticipantsOption = {};
        <?php
            switch($type):
                case "participants":
        ?>
                    $cumulativeParticipantsOption = {"type":"serial",
                                                     "theme":"light",
                                                     "depth3D":10,
                                                     "startDuration": 1,
                                                     "legend":{"useGraphSettings":true, "valueAlign":"left", "labelText":"[[title]]:", "labelGap":5},
                                                     "valueAxes": [{"id":"v1",
                                                                    "axisColor":"#59ACFF",
                                                                    "axisThickness":2,
                                                                    "gridAlpha": 0.1,
                                                                    "axisAlpha": 1,
                                                                    "offset": 63,
                                                                    "position": "left",
                                                                    "title": "Number of Participants"},
                                                                   {"id":"v2",
                                                                    "axisColor": "#B0DE09",
                                                                    "axisThickness": 2,
                                                                    "gridAlpha": 0,
                                                                    "axisAlpha": 1,
                                                                    "position": "left",
                                                                    "title": "Months Moving Average"},
                                                                   {"id":"v3",
                                                                    "axisColor": "#CA340F",
                                                                    "axisThickness": 2,
                                                                    "gridAlpha": 0,
                                                                    "axisAlpha": 1,
                                                                    "position": "right",
                                                                    "title": "Cumulative Participants"
                                                                    }],
                                                     "chartScrollbar": {"autoGridCount":true, "color":"#333333"},
                                                     "chartCursor": {"cursorPosition":"mouse","categoryBalloonDateFormat":"YYYY-MMM"},
                                                     "dataDateFormat": "YYYY-MM",
                                                     "categoryField": "dates",
                                                     "categoryAxis": {"parseDates": true, "minPeriod":"MM", "axisColor": "#DADADA","minorGridEnabled": true,"position":"top", "gridAlpha":0.1}};


    <?php
            break;

            case "course_man_days":
    ?>
                $cumulativeParticipantsOption = {"type":"serial",
                                                 "theme":"light",
                                                 "depth3D":10,
                                                 "startDuration":1,
                                                 "legend":{"useGraphSettings":true, "valueAlign":"left", "labelText":"[[title]]:", "labelGap":5},
                                                 "valueAxes": [{"id":"v1",
                                                                "axisColor":"#59ACFF",
                                                                "axisThickness":2,
                                                                "gridAlpha": 0.1,
                                                                "axisAlpha": 1,
                                                                "offset": 73,
                                                                "position": "left",
                                                                "title": "Course Man Days"},
                                                               {"id":"v2",
                                                                "axisColor": "#B0DE09",
                                                                "axisThickness": 2,
                                                                "gridAlpha": 0,
                                                                "axisAlpha": 1,
                                                                "position": "left",
                                                                "title": "Months Moving Average"},
                                                               {"id":"v3",
                                                                "axisColor": "#CA340F",
                                                                "axisThickness": 2,
                                                                "gridAlpha": 0,
                                                                "axisAlpha": 1,
                                                                "position": "right",
                                                                "title": "Cumulative Course Man Days"
                                                                }],
                                                 "chartScrollbar": {"autoGridCount":true, "color":"#333333"},
                                                 "chartCursor": {"cursorPosition":"mouse","categoryBalloonDateFormat":"YYYY-MMM"},
                                                 "dataDateFormat": "YYYY-MM",
                                                 "categoryField": "dates",
                                                 "categoryAxis": {"parseDates":true, "minPeriod":"MM", "axisColor":"#DADADA","minorGridEnabled":true,"position":"top", "gridAlpha":0.1}};
    <?php
            break;

            case "monthly_participants":
    ?>
                $cumulativeParticipantsOption = {"type":"serial",
                                                 "theme":"light",
                                                 "depth3D":10,
                                                 "startDuration":1,
                                                 "legend":{"useGraphSettings":true, "valueAlign":"right", "labelText":"Yr [[title]]:", "position":"bottom", "right":-4},
                                                 "valueAxes": [{"axisThickness": 1, "gridAlpha": 0.1, "axisAlpha": 1, "position": "left", "title": "Number of Participants"}],
                                                 "chartScrollbar": {"autoGridCount":true, "color":"#333333"},
                                                 "chartCursor":{"cursorPosition":"mouse", "categoryBalloonDateFormat":"MMM"},
                                                 "dataDateFormat": "MM",
                                                 "categoryField":"months",
                                                 "categoryAxis":{"parseDates":true, "boldPeriodBeginning":false, "markPeriodChange":false, "axisColor":"#DADADA", "minPeriod":"MM", "position":"top", "gridAlpha":0.1}};

    <?php
            break;

        endswitch;
    ?>
        AmCharts.ready(function()
        {

            $cumulativeParticipantsOption.dataLoader = {url: "<?php echo $this->Html->url(array($type, $from_year, $to_year, 'json'));?>",
                                                        format: "json",
                                                        postProcess: function(data, options) {
                                                                        if(data===null)
                                                                        {
                                                                            data = [];
                                                                            options.chart.addLabel("50%", "50%", "No Data Available");
                                                                            options.chart.graphs = [];
                                                                        }
                                                                        else
                                                                        {
                                                                        <?php
                                                                            switch($type):
                                                                                case "participants":
                                                                        ?>
                                                                            options.chart.graphs = [{valueAxis:"v1",type:"column",lineColor:"#59ACFF",title:"No. of Participants",valueField:"nop",fillAlphas:1,fixedColumnWidth:20},
                                                                                                    {valueAxis:"v2",type:"line",lineColor:"#B0DE09",title:"Months Moving Average",valueField:"mma",bullet:"square",fillAlphas:0.3},
                                                                                                    {valueAxis:"v3",type:"line",lineColor:"#CA340F",title:"Cumulative Pax/Yr",valueField:"cpy",bullet:"round",fillAlphas:0}];
                                                                        <?php
                                                                                break;

                                                                                case "course_man_days":
                                                                        ?>
                                                                            options.chart.graphs = [{valueAxis:"v1",type:"column",lineColor:"#59ACFF",title:"Course Man Days",valueField:"cmd",fillAlphas:1,fixedColumnWidth:20},
                                                                                                    {valueAxis:"v2",type:"line",lineColor:"#B0DE09",title:"Months Moving Average",valueField:"mma",bullet:"square",fillAlphas:0.3},
                                                                                                    {valueAxis:"v3",type:"line",lineColor:"#CA340F",title:"Cumulative CMD/Yr",bullet:"round",valueField:"ccmdpy",fillAlphas:0}];
                                                                        <?php
                                                                                break;

                                                                                case "monthly_participants":
                                                                        ?>
                                                                            for($i=<?php echo $from_year; ?>; $i<=<?php echo $to_year; ?>; $i++)
                                                                            {
                                                                                var $graph = new AmCharts.AmGraph();
                                                                                $graph.title = $i;
                                                                                $graph.valueField = $i;
                                                                                $graph.bullet = "square";
                                                                                options.chart.addGraph($graph);
                                                                            }
                                                                        <?php
                                                                                break;
                                                                            endswitch;
                                                                        ?>
                                                                        }
                                                                        return data;
                                                                      }};
            var $StatisticChart = AmCharts.makeChart("StatisticChart", $cumulativeParticipantsOption);
            $StatisticChart.addListener("dataUpdated", zoomChart);
            zoomChart();

            function zoomChart(){$StatisticChart.zoomToIndexes($StatisticChart.dataProvider.length - 36, $StatisticChart.dataProvider.length-1);}
        });
    </script>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("reports/statistic.reports"));
		echo $this->fetch("script");
?>
