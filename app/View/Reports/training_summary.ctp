<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'reports/report.main'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">TRAINING SUMMARY</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<span class="pull-right">
								<input id="OfferingCourseID" name="course_id" value="<?php echo (isset($course_id)&&trim($course_id)!=''?$course_id."-CORS":''); ?>" type="text" style="width:500px;"/>&nbsp;&nbsp;<input id="OfferYearStart" class="easyui-numberspinner" data-options="min:2013,max:2099,prompt:'-- year --'" value="<?php echo (isset($year)&&trim($year)!=''?$year:''); ?>" type="text" style="width:85px;"/>&nbsp;&nbsp;<?php echo $this->Html->link('Go', array('controller'=>'reports','action'=>'training_summary'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Apply filter', "data-options"=>"iconCls:'icon-filter'", "style"=>"padding: 0px 0px 0px 0px;", "id"=>"filtertrainingsummary"));?>&nbsp;<?php echo $this->Html->link('', array('controller'=>'reports','action'=>'training_summary'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Reset filter',  "data-options"=>"iconCls:'icon-reload'", "style"=>"padding: 0px 3px 0px 3px;"));?>
						</span>
						<div class="clearfix"></div>
				</div>
		</div>
</div>
<div class="box">
<?php
		if(isset($trainings))
		{
				if(count($trainings)>0)
				{
				    $trainingSummary = array();
				    foreach($trainings as $training) $trainingSummary[$training['Offering']['course_id']][] = $training;

				    $smry_counter = 0;
				    foreach($trainingSummary as $events)
				    {
				        $totalNoOfParticipants = 0;
				        $totalNoOfDays = 0;
				        $totalCourseManDays = 0;
?>
		<h3 class="text-default"><button class="btn btn-xs btn-default tool_tips" style="margin-bottom:4px;" data-toggle="collapse" data-target="#<?php echo $events[0]['Offering']['course_code']; ?>" title="Collapse"></button> <?php echo $events[0]['Offering']['course_name']; ?> <br/><small style="margin-left:27px;font-size:10px;">[ CODE: <?php echo $events[0]['Offering']['course_code']; ?> ]</small></h3>
		<table class="table table-striped table-hover">
		    <thead class="thead-default">
		        <tr>
		            <th style="width:170px;">Event</th>
		            <th style="width:170px;">Date</th>
		            <th style="width:250px;">Instructors</th>
		            <th style="min-width:200px !important;">Company</th>
		            <th style="width:70px;text-align:right !important;"><span class="tool_tips" title="Number of Participants">NoP</span></th>
		            <th style="width:70px;text-align:right !important;"><span class="tool_tips" title="Number of Days">NoD</span></th>
		            <th style="width:70px;text-align:right !important;"><span class="tool_tips" title="Course Man Days">CMD</span></th>
		        </tr>
		    </thead>
				<tbody id="<?php echo $events[0]['Offering']['course_code']; ?>" class="collapse in">
		    <?php
		        foreach($events as $event):
		            $totalNoOfParticipants += intval($event['Offering']['number_of_participants']);
		            $totalNoOfDays += intval($event['Offering']['number_of_days']);
		            $totalCourseManDays += intval($event['Offering']['course_man_days']);
		    ?>
						<tr>
							<td><?php echo $event['Offering']['offer_code']; ?></td>
							<td><?php echo $this->DateRangeFormat->FormatDateRange(strtotime($event['Offering']['date_start']), strtotime($event['Offering']['date_end'])) ?></td>
							<td><?php echo $event['Offering']['instructor_names']; ?></td>
							<td><?php echo $event['Offering']['company_names']; ?></td>
							<td style="text-align:right !important;"><?php echo $event['Offering']['number_of_participants']; ?></td>
							<td style="text-align:right !important;"><?php echo $event['Offering']['number_of_days']; ?></td>
							<td style="text-align:right !important;"><?php echo $event['Offering']['course_man_days']; ?></td>
						</tr>
		    <?php endforeach; unset($event); ?>
				</tbody>
		    <tfoot>
		        <tr style="background-color:#F4FAFF;">
		          <td colspan="2"><b>TOTAL:</b></td>
		          <td colspan="2">&nbsp;</td>
		          <td style="text-align:right !important;"><b><?php echo $totalNoOfParticipants; ?></b></td>
		          <td style="text-align:right !important;"><b><?php echo $totalNoOfDays; ?></b></td>
		          <td style="text-align:right !important;"><b><?php echo $totalCourseManDays; ?></b></td>
		        </tr>
		    </tfoot>
		</table>
<?php
				        $smry_counter++;
				    }
				}
				else
				{
						echo "<div class=\"clearfix\" style=\"text-align:center;\">No records found!</div>";
				}
		}
		else
		{
				echo "<div class=\"clearfix\" style=\"text-align:center;\">Training summaries will be displayed here.</div>";
		}
?>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("reports/report.main"));
		echo $this->fetch("script");
?>
