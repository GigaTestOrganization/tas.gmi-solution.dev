<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'reports/report.main'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header _head">
    <h3 class="text-default">TRAINING SERVICE REPORT</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar" style="margin-bottom:-1px;">
						<span class="pull-right">
								<form id="MonthlyReportForm" action="<?php echo $this->Html->url(array('action' => 'training_report')); ?>" method="get" enctype="application/x-www-form-urlencoded" style="margin:0px;padding:0px;width:100%;">Date Period: <input id="js-date-start" name="data[date_start]" type="text" value="<?php echo (isset($start_date)?$start_date:''); ?>"> - <input id="js-date-end" name="data[date_end]" type="text" value="<?php echo (isset($end_date)?$end_date:''); ?>"> <a href="#" class="easyui-linkbutton tool_tips" title="Filter Events" data-options="iconCls:'icon-search'" data-url="<?php echo $this->Html->url(array("action"=>"training_report")); ?>" id="js-search-events" style="width: 85px;">Search</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'download', 'training_report', (isset($start_date)?$start_date:''), (isset($end_date)?$end_date:''))); ?>.pdf" class="easyui-linkbutton tool_tips" title="Download Report" data-options="iconCls:'icon-save'<?php echo (!isset($start_date)?',disabled:true':''); ?>" style="padding: 0px 3px 0px 3px;">download</a></form>
						</span>
						<div class="clearfix"></div>
				</div>
		</div>
		<div class="col-lg-12">
			<div id="workspace">
					<?php if(isset($trainings)): ?>
					<div id="document-content">
							<div class="row" style="color:#2c6877">
								<div class="col-sm-2">
									<img src="<?php echo $this->Html->url('/img/gmi/gigamare_mid_sm.jpg', true); ?>"/>
								</div>
								<div class="col-sm-10">
									<h2>Training Service Report</h2>
									<h4>Provider: GigaMare Inc.</h4>
									<h4>Date Period: <?php echo (isset($start_date)?date('d.m.Y', strtotime($start_date)):'').(isset($end_date)?' - '.date('d.m.Y', strtotime($end_date)):''); ?></h4>
								</div>
							</div>
							<br/>
							<table class="table table-striped" style="border:0px !important;">
									<thead>
										<tr>
											<th>Course Name</th>
											<th style="width:100px;">Start Date</th>
											<th style="width:100px;">End Date</th>
											<th style="width:100px;text-align:center;">Man Days</th>
											<th style="text-align:center;">Participants</th>
											<th style="width:50px;">Status</th>
										</tr>
									</thead>
									<tbody id="eventslist">
										<?php
										$totalNoOfCourses = 0;
										$totalNotCancelledCourses = 0;
										$totalCMD = 0;
										$totalNoP = 0;
										foreach($trainings as $event):
											?>
											<tr>
												<td><?php echo $this->Html->link($event['Offering']['course_name'], array('controller' => 'courses', 'action' => 'view', $event['Offering']['course_id'])); ?></td>
												<td><?php echo date('d.m.Y', strtotime($event['Offering']['date_start'])); ?></td>
												<td><?php echo date('d.m.Y', strtotime($event['Offering']['date_end']));?></td>
												<td style="text-align:center;"><?php echo $event['Offering']['course_man_days']; ?></td>
												<td style="text-align:center;"><?php echo $event['Offering']['number_of_participants']; ?></td>
												<td style="text-align:right"><?php echo $statuses[$event['Offering']['status']]; ?></td>
											</tr>
											<?php
											$totalCMD += $event['Offering']['course_man_days'];
											$totalNoP += $event['Offering']['number_of_participants'];
											$totalNoOfCourses++;
											if($event['Offering']['status']!=4) $totalNotCancelledCourses++;
										endforeach;
										unset($event);
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" style="text-align:right;"><b>Total Courses: <?php echo $totalNoOfCourses;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Non-Cancelled Courses: <?php echo $totalNotCancelledCourses; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
											<td style="text-align:center;"><b><?php echo $totalCMD; ?></b></td>
											<td style="text-align:center;"><b><?php echo $totalNoP; ?></b></td>
											<td></td>
										</tr>
									</tfoot>
							</table>
							<br/><br/><br/>
							<div class="row">
								<div class="col-sm-5">
									<span style="color:#81c8ef;font-weight:bold;font-size:1.2em !important;">GigaMare Inc.</span><br/>
									<small style="color:#8c8c8c;">Bldg 2082, Corregidor Highway,<br/>Naval Magazine Area, Subic Bay Freeport Zone,<br/>Philippines 2222<br/></small>
								</div>
								<div class="col-sm-7">
									<small style="color:#8c8c8c;">
										<dl class="dl-horizontal">
											<dt style="text-align:left !important;width:30px;">Tel</dt> <dd style="margin-left:0px;">: +63 (047) 252 6402 / 6483</dd>
											<dt style="text-align:left !important;width:30px;">Fax</dt> <dd style="margin-left:0px;">: +63 (047) 252 6482</dd>
											<dt style="text-align:left !important;width:30px;">TIN</dt> <dd style="margin-left:0px;">: 008-492-451-000</dd>
										</dl>
									</small>
								</div>
							</div>
					</div>
					<?php endif; ?>
			</div>
		</div>
</div>
<?php
		echo $this->Html->script(array("reports/training.report"));
		echo $this->fetch("script");
?>
