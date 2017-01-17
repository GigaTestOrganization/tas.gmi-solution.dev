$(function()
{
    AmCharts.ready(function()
    {
        $(".js-amcharts-pie").each(function()
        {
            $pieChartOptions = {"type":"pie", "titles":[{"text":"PER MONTH","size":11}], "theme":"none", "valueField":"value", "titleField":"month",
                                                             "outlineAlpha":0.6, "depth3D":10, "balloonText":"[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>", "angle":25};

            $pieChartOptions.dataLoader = {"url":$(this).data('url'), "format":"json"};
            $piechart = AmCharts.makeChart($(this).data('target'), $pieChartOptions);
        });

        $(".js-amcharts-column").each(function()
        {
            $columnChartOptions = {"type":"serial", "titles":[{"text":"ANNUAL PER COURSE", "size":11}], "theme":"none", "valueAxes":[{"position":"left", "title":"Course Man Days"}],
                                                               "graphs":[{"balloonText":"[[course_name]]: <b>[[value]]</b>", "fillAlphas":1, "lineAlpha":0.2, "type":"column", "valueField":"value"}], "angle":30, "depth3D":10,
                                                               "categoryField":"course", "categoryAxis":{"fillAlpha":0.05, "labelRotation":45, "axisColor":"#DADADA", "position":"top", "labelsEnabled":false},
                                                               "chartScrollbar": {"autoGridCount":false}, "chartCursor":{"cursorPosition":"mouse"}};

            $columnChartOptions.dataLoader = {"url":$(this).data('url'), "format":"json"};
            $columnchart = AmCharts.makeChart($(this).data('target'), $columnChartOptions);
        });


    });

    $('#filtercoursesummary').click(function(evt)
    {
        evt.preventDefault();
        var $from_month = $('#FromMonth').combobox('getValue');
        var $to_month = $('#ToMonth').combobox('getValue');
        var $year = $('#OfferYearStart').numberspinner('getValue');
        if((($from_month!=undefined&&$from_month!=null&&$from_month!='') && ($to_month!=undefined&&$to_month!=null&&$to_month!='')) || ($year!=undefined&&$year!=null&&$year!=''))
          window.location.href = $(this).attr('href')+((($from_month!=undefined&&$from_month!=null&&$from_month!='')&&($to_month!=undefined&&$to_month!=null&&$to_month!=''))?'/'+$from_month+'-'+$to_month:'/year')+($year!=undefined&&$year!=null&&$year!=''?'/'+$year:'');
        $(this).blur();
    });
});
