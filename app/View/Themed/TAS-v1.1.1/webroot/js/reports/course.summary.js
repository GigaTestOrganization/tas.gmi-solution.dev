$(function()
{
    AmCharts.ready(function()
  	{
  			$columnChartOptions = {"type":"serial",
  													   "balloon": {},
  													   "valueAxes":[{"position":"left"}],
  													   "graphs":[{"balloonText":"<b>[[course_name]]</b>Total NoP: <b>[[value]]</b>","fillAlphas":1,"lineAlpha":0.2,"type":"column","title":"Total Number of Participants","valueField":"number_of_participants"},
  													   			 {"balloonText":"<b>[[course_name]]</b>Total NoD: <b>[[value]]</b>","fillAlphas":1,"lineAlpha":0.2,"type":"column","title":"Total Number of Days","valueField":"number_of_days"},
  																 {"balloonText":"<b>[[course_name]]</b><br/>CMD: <b>[[value]]</b>","fillAlphas":1,"lineAlpha":0.2,"type":"column","title":"Course Man Days","valueField":"course_man_days"}],
  													   "depth3D":20,
  													   "angle":30,
  													   "categoryField":"course_code",
  													   "legend": {"maxColumns": 3,
  																  "fontSize": 10,
  																  "markerLabelGap": 4,
  																  "markerSize": 13},
  													   "categoryAxis":{"fillAlpha":0.05, "labelRotation":45, "axisColor":"#DADADA", "position":"top", "labelsEnabled":false},
  													   "chartScrollbar": {"autoGridCount":false},
  													   "chartCursor":{"cursorPosition":"mouse"}
  													  };

  			$columnChartOptions.dataLoader = {"url":$("#coursesummary_chart").data("url"), "format":"json"};
  			$coursesummary_chart = AmCharts.makeChart("coursesummary_chart", $columnChartOptions);
  	});
});
