<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default"><small>[ <?php echo $offering['Offering']['code']; ?> ]</small> <?php echo $offering['Offering']['course_title']; ?> <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $offering['Offering']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($offering['Offering']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($offering['Offering']['modified']));?></small></h3>
</div>

<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-2 col-lg-8">
						<?php echo $this->Form->create('Offering', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'EditOfferForm', 'class'=>'form-horizontal', 'role' => 'form', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>General Information</b></h4>
						</div>
							<?php if(AuthComponent::user('role')!=='customer'): ?>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">SO Number:</label>
										<div class="col-sm-10">
												<input name="data[Offering][sales_order_no]" maxlength="60" style="width:500px;" type="text" value="<?php echo $offering['Offering']['sales_order_no']; ?>" id="OfferingSONum" class="form-control easyui-textbox" data-options="required:true"/>
										</div>
								</div>
							<?php endif; ?>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Course:</label>
										<div class="col-sm-10">
												<input type="hidden" name="data[Offering][id]" id="OfferingId" value="<?php echo $offering['Offering']['id']; ?>"/>
												<input type="hidden" name="data[Offering][last_modifier_id]" id="activeuserid" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/>
												<input type="text" name="data[Offering][course_id]" value="<?php echo $offering['Offering']['course_id']."-CORS"; ?>" id="OfferingCourseID" style="width:500px;" class="form-control"/>
										</div>
								</div>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Date Start/End:</label>
										<div class="col-sm-10">
												<input name="data[Offering][date_start]" style="width:130px;" type="text" value="<?php echo date('Y-m-d', strtotime($offering['Offering']['date_start']));?>" id="OfferingDateStart" class="form-control"/> - <input name="data[Offering][date_end]" style="width:130px;" type="text" value="<?php echo date('Y-m-d', strtotime($offering['Offering']['date_end'])); ?>" id="OfferingDateEnd" class="form-control"/>
										</div>
								</div>
							<?php if(AuthComponent::user('role')!=='customer'): ?>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Status:</label>
										<div class="col-sm-10">
												<select name="data[Offering][status]" class="form-control easyui-combobox" id="OfferingStatus" data-options="{panelHeight:'auto'}" style="width:170px;">
													 <option value="" disabled selected>--- please select status ---</option>
													 <option value="0"<?php echo ($offering['Offering']['status']==0?' selected':'');?>>For Confirmation</option>
													 <option value="1"<?php echo ($offering['Offering']['status']==1?' selected':'');?>>Confirmed</option>
													 <option value="2"<?php echo ($offering['Offering']['status']==2?' selected':'');?>>Delivered</option>
													 <option value="3"<?php echo ($offering['Offering']['status']==3?' selected':'');?>>Invoiced</option>
													 <option value="4"<?php echo ($offering['Offering']['status']==4?' selected':'');?>>Cancelled</option>
												</select>
										</div>
								</div>
								<div class="page-header">
										<h4 class="text-default"><b>Resources</b></h4>
								</div>
								<div class="form-group form-group-sm">
										<div class="col-sm-12" style="margin-bottom:5px;">
												<select name="InstructorsList" class="easyui-combobox" id="InstructorsList" style="width:250px;" data-options="{panelHeight:'150px'}">
														<option value="" disabled selected>--- please select instructor ---</option>
														<?php foreach($instructors as $instructor):?>
														<option value="<?php echo $instructor['Instructor']['id']; ?>"><?php echo $instructor['Instructor']['fullname']; ?></option>
														<?php endforeach; unset($instructor); ?>
												</select>
												<input type="hidden" name="default_inst" id="default_inst" value="0"/>
												<a href="#" class="easyui-linkbutton tool_tips" title="Add Instructors" id="addofferinstructor" data-options="iconCls:'icon-add'">add</a>
										</div>
										<div class="col-sm-12">
												<table class="table table-bordered table-hover table-striped">
														<thead class="thead-default">
																<th>Instructor(s)</th>
																<th width="50" style="text-align:center;">Lead</th>
																<th width="30">&nbsp;</th>
														</thead>
														<tbody id="AddedOfferInstructors">
																<?php foreach($offerInstructors as $offerInstructor): ?>
																<tr>
																		<td><label for="OfferInstructor<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>"><?php echo $offerInstructor['OfferInstructor']['fullname']; ?></label><input type="hidden" name="data[OfferInstructor][<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>][id]" value="<?php echo $offerInstructor['OfferInstructor']['id']; ?>"/><input type="hidden" name="data[OfferInstructor][<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>][instructor_id]" value="<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>"/><input type="hidden" name="data[OfferInstructor][<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>][last_modifier_id]" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/></td>
																		<td style="text-align:center;"><input type="radio" name="data[lead]" id="OfferInstructor<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>" value="<?php echo $offerInstructor['OfferInstructor']['instructor_id']; ?>"<?php echo (intval($offerInstructor['OfferInstructor']['lead'])==1?' checked="checked"':""); ?>/></td>
																		<td style="text-align:center;"><a href="#" class="removeitem" name="instructor" data-id="<?php echo $offerInstructor['OfferInstructor']['id']; ?>"><span class="text-danger fa fa-times"></span></a></td>
																</tr>
																<?php endforeach; unset($offerInstructor)?>
														</tbody>
												</table>
										</div>
								</div>
								<br/>
								<div class="form-group form-group-sm">
										<div class="col-sm-12" style="margin-bottom:5px;">
												<select name="ClassroomsList" class="easyui-combobox" id="ClassroomsList" style="width:250px;" data-options="{panelHeight:'150px'}">
														<option value="" disabled selected>--- please select classroom ---</option>
														<?php foreach($classrooms as $classroom):?>
														<option value="<?php echo $classroom['Classroom']['id']; ?>"><?php echo $classroom['Classroom']['name']; ?></option>
														<?php endforeach; unset($classroom); ?>
												</select>
												<a href="#" class="easyui-linkbutton tool_tips" title="Add Room" id="addofferclassroom" data-options="iconCls:'icon-add'">add</a>
										</div>
										<div class="col-sm-12">
												<table class="table table-bordered table-hover table-striped">
														<thead class="thead-default">
																<th>Classroom(s)</th>
																<th width="30">&nbsp;</th>
														</thead>
														<tbody id="AddedOfferClassrooms">
																<?php foreach($offerClassrooms as $offerClassroom): ?>
																<tr>
																		<td><?php echo $offerClassroom['Classroom']['name']; ?><input type="hidden" name="data[OfferClassroom][<?php echo $offerClassroom['OfferClassroom']['classroom_id']; ?>][id]" value="<?php echo $offerClassroom['OfferClassroom']['id']; ?>"/><input type="hidden" name="data[OfferClassroom][<?php echo $offerClassroom['OfferClassroom']['classroom_id']; ?>][classroom_id]" value="<?php echo $offerClassroom['OfferClassroom']['classroom_id']; ?>"/><input type="hidden" name="data[OfferClassroom][<?php echo $offerClassroom['OfferClassroom']['classroom_id']; ?>][last_modifier_id]" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/></td>
																		<td style="text-align:center;"><a href="#" class="removeitem" name="classroom" data-id="<?php echo $offerClassroom['OfferClassroom']['id']; ?>"><span class="text-danger fa fa-times"></span></a></td>
																</tr>
																<?php endforeach; unset($offerClassroom)?>
														</tbody>
												</table>
										 </div>
								</div>
							<?php endif; ?>
								<div class="page-header">
										<h4 class="text-default"><b>Course Program</b> | <a href="#" class="easyui-linkbutton tool_tips" title="Reset the course program to default." id="usedefault" data-options="iconCls:'icon-reload'">Default</a></h4>
								</div>
								<div class="form-group form-group-sm">
										<div class="col-sm-12" id="course_program">
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
														 $lesson_index = 0;
														 for($i=1; $i<=$nw; $i++):
																 if($i>1):
											 ?>
											  <center><small>...</small></center>
													 <?php endif; ?>
												<p data-week="<?php echo $i; ?>">
														<table id="timetable" class="table table-bordered table-hover table-striped">
																<thead class="thead-default">
																		<th width="115">Days</th>
																		<th valign="bottom">Lessons</th>
																		<th width="165">Instructor</th>
																		<th width="135" align="center">Duration</th>
																		<th width="145" align="center">Time Slot</th>
																</thead>
																<tbody>
																<?php
																		for($cntr=1; $cntr<=7; $cntr++):
																				if(((strtotime(date('Y-m-d', $current_date))>=strtotime($start_date))&&(strtotime(date('Y-m-d', $current_date))<=strtotime($end_date))) && !in_array(date('w', $current_date), $not_allowed_days)):
																?>
																<tr height="50">
																		<td class="time"><?php echo date('l', $current_date).'<br/><span style="font-size: 10px;">'.date('M d, Y', $current_date).'</span>'; ?></td>
																		<td colspan="4" class="schedules" data-week="<?php echo $i; ?>" data-day="<?php echo (intval(date('w', $current_date))+1); ?>">
																		<?php
																				if(isset($lessons[$daily_sched_index])):
																						$daily_sched = @$lessons[$daily_sched_index];
																		?>
																				<table class="schedule table" style="border:none !important;background:transparent !important;" border="0" width="100%" cellpadding="5" cellspacing="0">
																						<?php
																								$order = 0;
																								foreach($daily_sched['children'] as $lesson):
																						?>
																								<tr style="background:transparent;border-bottom:1px solid #dedede !important;" class="draggablelesson">
																										<td width="165" style="border-top:none !important;"><?php echo $lesson['title']; ?><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][id]" value="<?php echo $lesson['id']; ?>"/><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][last_modifier_id]" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][lesson_id]" value="<?php echo $lesson['lesson_id']; ?>"/></td>
																										<td width="165" style="border-top:none !important;"><img src="/img/searchbox_button.png" id="findInstructor" class="tool_tips" title="Change Instructor" data-course_lesson_id="<?php echo $lesson['id']; ?>" border="0"/>&nbsp;<span id="instructorname"><?php echo $lesson['instructor'];?><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][instructor_id]" value="<?php echo $lesson['instructor_id']; ?>"/></span></td>
																										<td width="120" valign="top" style="border-top:none !important;"><?php echo $lesson['duration']; ?><input type="hidden" id="weeknum" name="data[Schedule][<?php echo $lesson_index; ?>][week]" value="<?php echo $i; ?>"/><input type="hidden" id="lessonday" name="data[Schedule][<?php echo $lesson_index; ?>][day]" value="<?php echo (intval(date('w', $current_date))+1); ?>"/><input type="hidden" id="lessonorder" name="data[Schedule][<?php echo $lesson_index; ?>][order]" value="<?php echo $order; ?>"/></td>
																										<td width="145" valign="top" style="border-top:none !important;"><select name="data[Schedule][<?php echo $lesson_index; ?>][time_start]" data-duration="<?php echo $lesson['duration']; ?>" class="drop_start_time" style="width:65px;">
																										<?php
																												for($t=8; $t<24; $t++):
																														$time00 = ($t>9?$t:'0'.$t).':00';
																														echo '<option'.($time00==$lesson['time_start']?' selected="selected"':'').'>'.$time00.'</option>';

																														$time15 = ($t>9?$t:'0'.$t).':15';
																														echo '<option'.($time15==$lesson['time_start']?' selected="selected"':'').'>'.$time15.'</option>';

																														$time30 = ($t>9?$t:'0'.$t).':30';
																														echo '<option'.($time30==$lesson['time_start']?' selected="selected"':'').'>'.$time30.'</option>';

																														$time45 = ($t>9?$t:'0'.$t).':45';
																														echo '<option'.($time45==$lesson['time_start']?' selected="selected"':'').'>'.$time45.'</option>';
																												endfor;
																										?></select> - <input type="text" class="t_end" name="data[Schedule][<?php echo $lesson_index; ?>][time_end]" readonly="readonly" style="border:none;background-color:transparent;width:55px;" value="<?php echo $lesson['time_end']; ?>"/></td>
																								</tr>
																						<?php
																										$order++;
																										$lesson_index++;
																								endforeach;
																						?>
																				</table>
																		<?php
																						$daily_sched_index++;
																				endif;
																		?>
																		</td>
																</tr>
																<?php else:	?>
																<tr height="50">
																		<td class="time"><?php echo date('l', $current_date).'<br/><span style="font-size: 10px;">'.date('M d, Y', $current_date).'</span>'; ?></td>
																		<td colspan="4" class="schedules" data-week="<?php echo $i; ?>" data-day="<?php echo (intval(date('w', $current_date))+1); ?>">&nbsp;<br/><br/></td>
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
												</p>
											<?php endfor; ?>
										</div>
								</div>
								<hr/>
								<div class="form-group form-group-sm">
										<div class="col-sm-2"></div>
										<div class="col-sm-10">
												<span class="pull-right">
														<input type="submit" value="Save" class="btn btn-sm btn-primary" id="SubmitEditOfferForm"/>
														<a class="btn btn-sm btn-default" id="cancelOfferForm" href="<?=$this->Html->url(array('action' => 'view', $offering['Offering']['id']))?>">Cancel</a>
												</span>
										</div>
								</div>
						<?php echo $this->Form->end(); ?>
				</div>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("offerings/offering.edit"));
		echo $this->fetch("script");
?>
