<?php echo $this->Html->docType('html5'); ?>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Training Administration System - Download Training Report</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('font-awesome.min', 'bootstrap.min.pdf.ready'), array('fullBase'=>true));
	?>
	<style media="all"> tr{page-break-inside: avoid !important;} </style>
</head>
<body>
	<div class="container">
			<div class="row">
					<div class="col-xs-12">
							<section class="content">
                  <?php if(isset($trainings)): ?>
										<div class="row" style="color:#2c6877 !important;">
											<div class="col-xs-2">
												<img src="<?php echo $this->Html->url('/img/gmi/gigamare_mid_sm.jpg', true); ?>"/>
											</div>
											<div class="col-xs-10">
												<h2 style="color:#2c6877 !important;">Training Report</h2>
												<h4 style="color:#2c6877 !important;">Service Provider: GigaMare Inc.</h4>
												<h4 style="color:#2c6877 !important;">Date Period: <?php echo (isset($start_date)?date('d.m.Y', strtotime($start_date)):'').(isset($end_date)?' - '.date('d.m.Y', strtotime($end_date)):''); ?></h4>
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
                              <td><?php echo $event['Offering']['course_name']; ?></td>
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
									<?php endif; ?>
							</section>
					</div>
			</div>
	</div>
</body>
</html>
