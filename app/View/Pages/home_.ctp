<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */ 

	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'chart/highcharts', 'chart/exporting'));
?>
<script type="text/javascript">
$(function () {
	$('#chart_01').highcharts({
	exporting: false,
	title: {text: ''},
	xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May']},
	labels: {
		items: [{
			html: 'Total Number Of Offers',
			style: {
				left: '50px',
				top: '18px',
				color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
			}
		}]
	},
	series: [{
		type: 'column',
		name: 'For Confirmation',
		data: [3, 2, 1, 3, 4]
	}, {
		type: 'column',
		name: 'Confirmed',
		data: [2, 3, 5, 7, 6]
	}, {
		type: 'column',
		name: 'Delivered / Invoiced',
		data: [4, 3, 3, 9, 2]
	}, {
		type: 'column',
		name: 'Cancelled',
		data: [4, 3, 3, 9, 1]
	}, {
		type: 'spline',
		name: 'Average',
		data: [3.4, 2.8, 3, 7.4, 6.6],
		marker: {
			lineWidth: 2,
			lineColor: Highcharts.getOptions().colors[3],
			fillColor: 'white'
		}
	}, {
		type: 'pie',
		name: 'Total Offers',
		data: [{
			name: 'For Confirmation',
			y: 13,
			color: Highcharts.getOptions().colors[0] // Jane's color
		}, {
			name: 'Confirmed',
			y: 22,
			color: Highcharts.getOptions().colors[1] // John's color
		}, {
			name: 'Delivered / Invoiced',
			y: 21,
			color: Highcharts.getOptions().colors[2] // Joe's color
		}, {
			name: 'Cancelled',
			y: 20, 
			color: Highcharts.getOptions().colors[3]
		}],
		center: [100, 80],
		size: 100,
		showInLegend: false,
		dataLabels: {
			enabled: false
		}
	}]
	});
	
	$('#chart_02').highcharts({
	exporting: false,
	title: {text: ''},
	xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May']},
	labels: {
		items: [{
			html: 'Total Number Of Offers',
			style: {
				left: '50px',
				top: '18px',
				color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
			}
		}]
	},
	series: [{
		type: 'column',
		name: 'For Confirmation',
		data: [3, 2, 1, 3, 4]
	}, {
		type: 'column',
		name: 'Confirmed',
		data: [2, 3, 5, 7, 6]
	}, {
		type: 'column',
		name: 'Delivered / Invoiced',
		data: [4, 3, 3, 9, 2]
	}, {
		type: 'column',
		name: 'Cancelled',
		data: [4, 3, 3, 9, 1]
	}, {
		type: 'spline',
		name: 'Average',
		data: [3.4, 2.8, 3, 7.4, 6.6],
		marker: {
			lineWidth: 2,
			lineColor: Highcharts.getOptions().colors[3],
			fillColor: 'white'
		}
	}, {
		type: 'pie',
		name: 'Total Offers',
		data: [{
			name: 'For Confirmation',
			y: 13,
			color: Highcharts.getOptions().colors[0] // Jane's color
		}, {
			name: 'Confirmed',
			y: 22,
			color: Highcharts.getOptions().colors[1] // John's color
		}, {
			name: 'Delivered / Invoiced',
			y: 21,
			color: Highcharts.getOptions().colors[2] // Joe's color
		}, {
			name: 'Cancelled',
			y: 20, 
			color: Highcharts.getOptions().colors[3]
		}],
		center: [100, 80],
		size: 100,
		showInLegend: false,
		dataLabels: {
			enabled: false
		}
	}]
	});
	
	$('#chart_03').highcharts({
	exporting: false,
	title: {text: ''},
	xAxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May']},
	labels: {
		items: [{
			html: 'Total Number Of Offers',
			style: {
				left: '50px',
				top: '18px',
				color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
			}
		}]
	},
	series: [{
		type: 'column',
		name: 'For Confirmation',
		data: [3, 2, 1, 3, 4]
	}, {
		type: 'column',
		name: 'Confirmed',
		data: [2, 3, 5, 7, 6]
	}, {
		type: 'column',
		name: 'Delivered / Invoiced',
		data: [4, 3, 3, 9, 2]
	}, {
		type: 'column',
		name: 'Cancelled',
		data: [4, 3, 3, 9, 1]
	}, {
		type: 'spline',
		name: 'Average',
		data: [3.4, 2.8, 3, 7.4, 6.6],
		marker: {
			lineWidth: 2,
			lineColor: Highcharts.getOptions().colors[3],
			fillColor: 'white'
		}
	}, {
		type: 'pie',
		name: 'Total Offers',
		data: [{
			name: 'For Confirmation',
			y: 13,
			color: Highcharts.getOptions().colors[0] // Jane's color
		}, {
			name: 'Confirmed',
			y: 22,
			color: Highcharts.getOptions().colors[1] // John's color
		}, {
			name: 'Delivered / Invoiced',
			y: 21,
			color: Highcharts.getOptions().colors[2] // Joe's color
		}, {
			name: 'Cancelled',
			y: 20, 
			color: Highcharts.getOptions().colors[3]
		}],
		center: [100, 80],
		size: 100,
		showInLegend: false,
		dataLabels: {
			enabled: false
		}
	}]
	});
	
});
</script>
<div class="container_0 content_pane">
	<h2>Dashboard</h2>
	<div class="float_left" style="width: 500px; margin-right: 10px; margin-bottom: 10px;">
		<div class="easyui-panel" title="2014 OFFERS">	
			<div id="chart_01" style="height: 350px; padding-top: 15px;"></div>
	    </div>
    </div>
	<div class="float_left" style="width: 500px; margin-bottom: 10px;">
		<div class="easyui-panel" title="2014 OFFERS">	
			<div id="chart_02" style="height: 350px; padding-top: 15px;"></div>
	    </div>
    </div>
    <div class="float_left" style="width: 500px; margin-bottom: 10px;">
		<div class="easyui-panel" title="2014 OFFERS">	
			<div id="chart_03" style="height: 350px; padding-top: 15px;"></div>
	    </div>
    </div>
    <div class="clear"></div>
</div>