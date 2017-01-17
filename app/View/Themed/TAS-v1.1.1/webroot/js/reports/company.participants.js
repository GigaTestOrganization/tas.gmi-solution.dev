$(function()
{
    AmCharts.ready(function()
    {
        $columnChartOptions = {"type":"serial",
                						   "theme":"none",
                						   "valueAxes":[{"position":"left", "title":"Number of Participants"}],
                						   "graphs":[{"balloonText":"[[category]]: <b>[[value]]</b>", "fillAlphas":1, "lineAlpha":0.2, "type":"column", "valueField":"nop"}],
                						   "depth3D":20,
                						   "angle":30,
                						   "categoryField":"name",
                						   "categoryAxis":{"fillAlpha":0.05, "labelRotation":45, "axisColor":"#DADADA", "position":"top", "labelsEnabled":false},
                						   "chartScrollbar": {"autoGridCount":false},
                						   "chartCursor":{"cursorPosition":"mouse"}
              						   };
    		$columnChartOptions.dataLoader = {"url":$('#noppercompany_cc').data('url'), "format":"json"};
    		$noppercompany_cc = AmCharts.makeChart("noppercompany_cc", $columnChartOptions);
    });

    $('#filtertrainingsummary').click(function(evt)
		{
  			evt.preventDefault();
  			var $customer_id = $('#CustomerID').combotree('getValue');
  			var $year = $('#YearStart').numberspinner('getValue');
  			if(($customer_id!=undefined&&$customer_id!=null&&$customer_id!='') || ($year!=undefined&&$year!=null&&$year!=''))
  				  window.location.href = $(this).attr('href')+($year!=undefined&&$year!=null&&$year!=''?'/'+$year:'/all')+($customer_id!=undefined&&$customer_id!=null&&$customer_id!=''?'/'+$customer_id:'/customer');
  			$(this).blur();
		});
});
