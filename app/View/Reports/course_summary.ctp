<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'reports/report.main'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'amcharts/amcharts', 'amcharts/pie', 'amcharts/serial', 'amcharts/themes/none', 'amcharts/plugins/dataloader/dataloader.min'));
?>
<div class="page-header">
    <h3 class="text-default">COURSE SUMMARY</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<span class="pull-right">
								<input id="OfferingCourseID" name="course_id" value="<?php echo (isset($course_id)&&trim($course_id)!=''?$course_id."-CORS":''); ?>" type="text" style="width:500px;"/>&nbsp;&nbsp;<input id="OfferYearStart" class="easyui-numberspinner" data-options="min:2013,max:2099,prompt:'-- year --'" value="<?php echo (isset($year)&&trim($year)!=''?$year:''); ?>" type="text" style="width:85px;"/>&nbsp;&nbsp;<?php echo $this->Html->link('Go', array('controller'=>'reports','action'=>'course_summary'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Apply filter', "data-options"=>"iconCls:'icon-filter'", "style"=>"padding: 0px 0px 0px 0px;", "id"=>"filtertrainingsummary"));?>&nbsp;<?php echo $this->Html->link('', array('controller'=>'reports','action'=>'course_summary'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Reset filter',  "data-options"=>"iconCls:'icon-reload'", "style"=>"padding: 0px 3px 0px 3px;"));?>
						</span>
						<div class="clearfix"></div>
				</div>
		</div>
</div>
<div class="box">
		<?php
				if(isset($courses_summary))
				{
						if(count($courses_summary)>0)
						{
		?>
		<h4 class="text-default"><button class="btn btn-xs btn-default tool_tips" style="margin-bottom:3px;" data-toggle="collapse" data-target="#chart" title="Hide/Show Chart"></button> <small>[ graphical presentation ]</small></h4>
		<div id="chart" class="well collapse in">
				<div class="row">
						<div id="coursesummary_chart" data-url="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'course_summary', (isset($course_id)&&trim($course_id)!=''?$course_id:'course'), (isset($year)&&trim($year)!=''?$year:'year'), 'json'));?>" class="col-sm-12" style="height:400px;"></div>
				</div>
		</div>
		<h4 class="text-default"><button class="btn btn-xs btn-default tool_tips collapsed" style="margin-bottom:3px;" data-toggle="collapse" data-target="#tableSummary" title="Hide/Show Detailed Summary"></button> <b>Detailed Summary</b></h4>
		<table class="table table-bordered table-striped table-hover">
				<thead class="thead-default">
						<tr>
								<th>Course Name</th>
								<th style="text-align:right !important;"><span class="tool_tips" title="Number of Participants">NoP</span></th>
								<th style="text-align:right !important;"><span class="tool_tips" title="Number of Days">NoD</span></th>
								<th style="text-align:right !important;"><span class="tool_tips" title="Course Man Days">CMD</span></th>
						</tr>
				</thead>
				<tbody id="tableSummary" class="collapse out">
				<?php
						$totalNoOfParticipants = 0;
						$totalNoOfDays = 0;
						$totalCourseManDays = 0;
						foreach($courses_summary as $summary):
								$totalNoOfParticipants += intval($summary['number_of_participants']);
								$totalNoOfDays += intval($summary['number_of_days']);
								$totalCourseManDays += intval($summary['course_man_days']);
				?>
						<tr>
								<td><?php echo $summary['course_name']; ?></td>
								<td style="text-align:right !important;"><?php echo $summary['number_of_participants']; ?></td>
								<td style="text-align:right !important;"><?php echo $summary['number_of_days']; ?></td>
								<td style="text-align:right !important;"><?php echo $summary['course_man_days']; ?></td>
						</tr>
				<?php endforeach; unset($summary); ?>
				</tbody>
				<tfoot>
						<tr style="background-color:#F2F9FF;">
								<td><b>TOTAL:</b></td>
								<td style="text-align:right !important;"><b><?php echo $totalNoOfParticipants; ?></b></td>
								<td style="text-align:right !important;"><b><?php echo $totalNoOfDays; ?></b></td>
								<td style="text-align:right !important;"><b><?php echo $totalCourseManDays; ?></b></td>
						</tr>
				</tfoot>
		</table>
		<?php
						}
						else
						{
								echo "<div class=\"clearfix\" style=\"text-align:center;\">No records found!</div>";
						}
				}
				else
				{
						echo "<div class=\"clearfix\" style=\"text-align:center;\">Course summary will be displayed here.</div>";
				}
		?>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("reports/report.main", "reports/course.summary"));
		echo $this->fetch("script");
?>
