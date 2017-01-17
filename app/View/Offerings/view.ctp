<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'offerings/offering.view'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min'));
		$arr_stats = array('Failed', 'Passed', 'Cancelled', 'Attended');
?>
<div class="page-header">
    <h3 class="text-default"><small>[ <?php echo $offering['Offering']['code']; ?> ]</small> <?php echo $this->Html->link($offering['Offering']['course_title'], array('controller'=>'courses', 'action' => 'view', $offering['Offering']['course_id'])); ?> <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $offering['Offering']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:ia', strtotime($offering['Offering']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:ia', strtotime($offering['Offering']['modified']));?></small></h3>
</div>

<div class="row">

		<div class="col-lg-12" style="margin-bottom:5px;">
				<span class="pull-right">
						<?php if(AuthComponent::user()): ?>
							<a href="#" class="easyui-menubutton" data-options="menu:'#mm1',iconCls:'icon-print'">Print-outs</a>
							<div id="mm1" style="width:150px;">
								<div class="js-download" data-options="iconCls:'icon-participantsid'" data-file="<?php echo time()."/participantsid/".$offering['Offering']['id']."/".iconv('utf-8', 'us-ascii//TRANSLIT', 'participants_id').".pdf"; ?>">Participants ID</div>
								<div class="js-download" data-options="iconCls:'icon-tablenametag'" data-file="<?php echo time()."/tablenametags/".$offering['Offering']['id']."/".iconv('utf-8', 'us-ascii//TRANSLIT', 'table_name_tags').".pdf"; ?>">Table Name Tags</div>
								<div class="menu-sep"></div>
								<div class="js-download" data-file="<?php echo time()."/registrationform/".$offering['Offering']['id']."/".iconv('utf-8', 'us-ascii//TRANSLIT', 'registration_form').".pdf"; ?>">Registration Form</div>
								<div class="js-download" data-file="<?php echo time()."/attendancesheet/".$offering['Offering']['id']."/".iconv('utf-8', 'us-ascii//TRANSLIT', 'attendance_sheet').".pdf"; ?>">Attendance Sheet</div>
								<div class="menu-sep"></div>
								<div class="js-download" data-file="<?php echo time()."/insurance/".$offering['Offering']['id']."/".iconv('utf-8', 'us-ascii//TRANSLIT', 'insurance').".pdf"; ?>">Insurance</div>
								<div class="menu-sep"></div>
								<div>Certificates</div>
								<div class="menu-sep"></div>
								<div>Feedback Form</div>
								<div class="menu-sep"></div>
								<div class="tool_tips" title="Download Offer and Course Specification.">Download Offer</div>
							</div>
						<?php endif; ?>
						<small>&nbsp;&nbsp; | &nbsp;&nbsp;</small>
						<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-edit"></i> Edit'), array('action' => 'edit', $offering['Offering']['id']), array('class' => 'btn btn-sm btn-primary', "title"=>"Edit Event", 'escape' => false)); ?>
						<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-remove"></i> Close'), array('controller'=>'offerings', 'action' => '/'), array("id"=>"cancelOfferForm", 'class'=>'btn btn-sm btn-default', "title"=>"Go to Log List", 'escape'=>false)); ?>
				</span>
				<div class="clearfix"></div>
		</div>

		<div class="col-lg-12">
				<div class="row">
						<div class="col-lg-6" style="margin-bottom:15px;">
								<div class="box">
										<div class="page-header">
										    <h3 class="text-default">Resources</h3>
										</div>
										<table class="table table-bordered table-hover table-striped">
												<thead class="thead-default">
														<tr>
									            <th>Instructor(s)</th>
									            <th>Lead</th>
														</tr>
								        </thead>
												<tbody>
										        <?php foreach($offerInstructors as $offerInstructor): ?>
										        <tr>
										            <td><?php echo $offerInstructor['OfferInstructor']['fullname']; ?></td>
										            <td><?php echo (intval($offerInstructor['OfferInstructor']['lead'])==1?"Yes":""); ?></td>
										        </tr>
										        <?php endforeach; unset($offerInstructor)?>
												</tbody>
								    </table>
										<br/>
								    <table class="table table-bordered table-hover table-striped">
												<thead class="thead-default">
														<tr>
								            		<th>Classroom(s)</th>
														</tr>
								        </thead>
												<tbody>
										        <?php foreach($offerClassrooms as $offerClassroom): ?>
										        <tr>
										            <td><?php echo $offerClassroom['Classroom']['name']; ?></td>
										        </tr>
										        <?php endforeach; unset($offerClassroom)?>
												</tbody>
								    </table>
								</div>
						</div>

				  	<div class="col-lg-6" style="margin-bottom:15px;">
								<div class="well well-info">
										<div class="page-header">
										    <h3 class="text-default">General Information</h3>
										</div>
										<dl class="dl-horizontal">
								        <dt>SO Number</dt> <dd>&nbsp;&nbsp;&nbsp;: <?php echo $offering['Offering']['sales_order_no'];?></dd>
								        <dt>Date Start</dt> <dd>&nbsp;&nbsp;&nbsp;: <?php echo (trim($offering['Offering']['date_start'])!=''?date('M d, Y', strtotime($offering['Offering']['date_start'])):'');?></dd>
								        <dt>Date End</dt> <dd>&nbsp;&nbsp;&nbsp;: <?php echo (trim($offering['Offering']['date_end'])!=''?date('M d, Y', strtotime($offering['Offering']['date_end'])):'');?></dd>
								        <dt>Status</dt> <dd>&nbsp;&nbsp;&nbsp;: <?php echo $statuses[$offering['Offering']['status']];?></dd>
										</dl>
								</div>
						</div>

				</div>
		</div>

		<div class="col-lg-12">
				<div class="tabular">
						<ul class="nav nav-pills">
								<li class="active"><a href="#course-program" class="tabs-btn rounded-top-left" data-toggle="tab">Course Program</a></li>
								<li><a href="#participants" class="tabs-btn" data-toggle="tab">Participants <small>(<span id="js-participants-count"><?php echo count($offerParticipants); ?></span>)</small></a></li>
						</ul>
						<div class="tab-content clearfix">
								<div id="course-program" class="tab-pane active">
											<?php
					                $start_date = $offering['Offering']['date_start'];
					                $end_date = $offering['Offering']['date_end'];
					                $swd = date('w', strtotime($start_date));
					                $new_start_date = ($swd==1?strtotime($start_date):strtotime("last Monday", strtotime($start_date)));

					                $ewd = date('w', strtotime($end_date));
					                $new_end_date = ($ewd==0?strtotime($end_date):strtotime("next Sunday", strtotime($end_date)));

					                $d1 = new DateTime(date('Y-m-d', $new_start_date));
					                $d2 = new DateTime(date('Y-m-d', $new_end_date));
					                $interval = $d1->diff($d2);
					                $nw = ceil(intval($interval->format('%a'))/7);

					                $lessons = array();
													if(isset($course_lessons[0])):
					                		foreach($course_lessons as $weekly_sched) $lessons = array_merge($lessons, $weekly_sched['children']);
													endif;

					                $current_date = strtotime(date('Y-m-d', $new_start_date));
					                $not_allowed_days = array(6,0);
					                $daily_sched_index = 0;

					                for($i=1; $i<=$nw; $i++):
															if($i>1):
					            ?>
											<center><small>...</small></center>
					            <?php	  endif; ?>
											<table class="table table-hover table-striped" style="border:none !important;margin-bottom:0px;">
													<thead class="theader-default">
															<tr>
					                        <th width="115">Days</th>
					                        <th valign="bottom">Lessons</th>
					                        <th width="165">Instructor</th>
					                        <th width="140" align="center">Duration</th>
					                        <th width="145" align="center">Time Slot</th>
															</tr>
			                    </thead>
													<tbody>
			                    <?php
			                        for($cntr=1; $cntr<=7; $cntr++):
			                            if(((strtotime(date('Y-m-d', $current_date))>=strtotime($start_date))&&(strtotime(date('Y-m-d', $current_date))<=strtotime($end_date))) && !in_array(date('w', $current_date), $not_allowed_days)):
			                    ?>
					                    <tr height="50">
					                        <td class="time"><?php echo date('l', $current_date).'<br/><span style="font-size: 10px;">'.date('M d, Y', $current_date).'</span>'; ?></td>
					                        <td colspan="4" class="schedules">
						                        <?php
																				if(isset($lessons[$daily_sched_index])):
																						$daily_sched = @$lessons[$daily_sched_index];
																		?>
						                            <table class="schedule" border="0" width="100%" cellpadding="5" cellspacing="0">
						                                <?php foreach($daily_sched['children'] as $lesson): ?>
						                                    <tr style="background-color: transparent;">
						                                        <td><?php echo $lesson['title']; ?></td>
						                                        <td width="165"><span id="instructorname"><?php echo $lesson['instructor'];?></span></td>
						                                        <td width="125" valign="top"><?php echo $lesson['duration']; ?></td>
						                                        <td width="140" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lesson['time_start']; ?> - <?php echo $lesson['time_end']; ?></td>
						                                    </tr>
						                                <?php endforeach; ?>
						                            </table>
						                        <?php
						                                $daily_sched_index++;
						                            endif;
						                        ?>
					                        	</td>
					                    	</tr>
			                    <?php 	else: ?>
						                    <tr height="50">
						                        <td class="time"><?php echo date('l', $current_date).'<br/><span style="font-size: 10px;">'.date('M d, Y', $current_date).'</span>'; ?></td>
						                        <td colspan="4" class="schedules">&nbsp;<br/><br/></td>
						                    </tr>
				                  <?php
																	endif;

				                          $current_date = new DateTime(date('Y-m-d', $current_date));
				                          $current_date->add(new DateInterval('P1D'));
				                          $current_date = strtotime($current_date->format('Y-m-d'));
					                    endfor;
				                  ?>
													</tbody>
			                </table>
										<?php endfor; ?>
								</div>
								<div id="participants" class="tab-pane">
										<?php if(AuthComponent::user()): ?>
										<span class="pull-right" style="position:relative; margin-top:-62px;padding:10px !important;">
												<input type="hidden" name="offer_id" id="offer_id" value="<?php echo $offering['Offering']['id'];?>"/>
												<a href="#" id="addparticipant" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Enroll</a>
												<a href="#" id="remove_button" class="btn btn-sm btn-default disabled"><span class="glyphicon glyphicon-minus"></span> Remove</a>
										</span>
								    <table class="table table-hover table-striped" style="border:none !important;margin-bottom:0px;">
												<thead class="theader-default">
														<tr>
										            <th width="30"><input type="checkbox" value="" id="select_all_participants"/></th>
										            <th>Name</th>
										            <th>Company</th>
								                <th width="90">Grade</th>
								                <th width="100">Status</th>
										            <th width="160">Date Enrolled</th>
								                <th width="125" class="participant_tbl_actions"><?php if(isset($current_user) && $current_user['role']!=='customer'){?><a href="#" id="edit_grades_and_stats">edit</a><?php } else echo "&nbsp;"; ?></th>
														</tr>
								        </thead>
								        <tbody id="offerParticipantList">
										        <?php foreach($offerParticipants as $offerParticipant): ?>
										        <tr height="39">
							              		<td><input type="checkbox" value="<?php echo $offerParticipant['OfferingParticipant']['id']; ?>"/><input type="hidden" value="<?php echo $offerParticipant['OfferingParticipant']['person_id']; ?>"/></td>
										        		<td><?php echo $this->Html->link($offerParticipant['OfferingParticipant']['fullname'], array('controller'=>'people', 'action'=>'view', $offerParticipant['OfferingParticipant']['person_id']), array("target"=>"_blank")); ?></td>
									            	<td><?php echo $this->Html->link($offerParticipant['Customer']['name'], array('controller'=>'customers', 'action'=>'view', $offerParticipant['Customer']['id']), array("target"=>"_blank")); ?></td>
							                  <td><span class="grade_n"><?php echo (trim($offerParticipant['OfferingParticipant']['grade'])!=""?$offerParticipant['OfferingParticipant']['grade']:"&nbsp;"); ?></span></td>
							                  <td><span class="stat_name"><?php echo (trim($offerParticipant['OfferingParticipant']['status'])!=''?$arr_stats[$offerParticipant['OfferingParticipant']['status']]:"-"); ?></span><input type="hidden" name="stat_id" class="stat_id" value="<?php echo (trim($offerParticipant['OfferingParticipant']['status'])!=""?$offerParticipant['OfferingParticipant']['status']:""); ?>"/></td>
									              <td><?php echo date('M d, Y - h:ia', strtotime($offerParticipant['OfferingParticipant']['created'])); ?></td>
							                  <td>&nbsp;</td>
										        </tr>
										        <?php endforeach; unset($offerParticipant)?>
								        </tbody>
								    </table>
									<?php endif; ?>
								</div>

						</div>

				</div>
		</div>

</div>
<br/><br/>
<?php
		echo $this->Html->script(array("offerings/offering.view.js?v=1.001"));
		echo $this->fetch("script");
?>
