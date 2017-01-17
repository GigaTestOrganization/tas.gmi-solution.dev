<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'jquery.meio.mask.min', 'ckeditor/ckeditor'));
?>
<div class="page-header">
    <h3 class="text-default">
				<small>[ <?php echo $course['Course']['code']; ?> ]</small> <?php echo $course['Course']['title']; ?>
				<small class="pull-right">
						<a class="btn btn-sm btn-primary" href="/" data-target="#EditCourseForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
						<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'view', $course['Course']['id'])); ?>"><span class="fa fa-times"></span> Close</a>
				</small>
		</h3>
</div>
<div class="box">

		<div class="actions hidden-xs hidden-sm hidden-md" style="position:fixed;margin-top:-15px;right:35px;">
				<div class="box">
						<div class="page-header">
								<h3 class="text-default">Search for Lessons</h3>
						</div>
						<div class="pull-left" style="width: 100%;">
								<?php echo $this->Form->input('CourseLesson.name', array('label'=>false, 'div'=>false, 'type'=>'text', 'id'=>'courseLessons', 'class'=>'form-control easyui-textbox', 'style'=>'width:270px;height:27px;display:inline;')); ?>
								<?php echo $this->Html->link('...', '/', array('id'=>'add_lesson', 'class'=>'btn btn-sm btn-default')); ?>
						</div>
						<div id="dialogbox" title="Found Lessons">&nbsp;</div>
							 <table id="lessonslist" class="table table-hover table-striped" style="border:none !important;">
									 <thead>
											<tr>
													<th>&nbsp;</th>
													<th style="width:45px;">(hh:mm)</th>
											</tr>
									 </thead>
								<?php
								if(isset($lessons) && $lessons)
								{
										foreach($lessons as $lesson):
								?>
								<tr class="draggablelesson" data-lesson_id="<?php echo $lesson['Lesson']['id']; ?>">
										<td><?php echo $lesson['Lesson']['title']; ?></td>
										<td><?php echo $lesson['Lesson']['duration']; ?></td>
								</tr>
								<?php
										endforeach;
								}
								?>
						</table>
						<div class="clearfix"></div>
				</div>
		</div>

		<div class="row">
				<div class="col-xs-12 col-lg-offset-1 col-lg-10">
						<?php echo $this->Form->create('Course', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'EditCourseForm', 'class'=>'form-horizontal', 'data-toggle'=>'validator')); ?>
								<div class="page-header">
										<h4 class="text-default">
												<b>Basic Information</b>
												<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $course['Course']['author'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($course['Course']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($course['Course']['modified']));?></small>
										</h4>
										<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
										<?php echo $this->Form->input('CourseSpecification.id', array('class' => 'form-control')); ?>
								</div>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Category:</label>
										<div class="col-sm-10">
												<input id="CourseCategoryID" data-source-url="<?php echo $this->Html->url(array('controller'=>'course_categories', 'action'=>'generatejsontreestructure')); ?>" type="text" name="data[Course][course_category_id]" value="<?php echo $course['Course']['course_category_id']; ?>" style="width:100%;"/>
										</div>
								</div>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">Title:</label>
										<div class="col-sm-10">
												<input name="data[Course][title]" class="easyui-textbox" data-options="required:true" maxlength="200" style="width:100%;" type="text" value="<?php echo $course['Course']['title']; ?>" id="CourseTitle"/>
										</div>
								</div>
								<div class="form-group form-group-sm">
										<label class="control-label col-sm-2">&nbsp;</label>
										<div class="col-sm-10">
												<label for="CoursePublished"><input type="checkbox" id="CoursePublished" name="data[Course][published]" value="1"<?php echo ($course['Course']['published']==1?' checked':''); ?>/> Publish</label>
										</div>
								</div>

								<br/>
								<br/>

								<div class="page-header">
										<h4 class="text-default"><b>Course Specification</b> <small>[ click immediately after the section title and start typing. ]</small></h4>
								</div>

								<div class="container-fluid">

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Course Description</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.description', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Target Group</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.target_audience', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Prerequisites</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.prerequisites', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Price of the Course</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.price', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Objective of the Course</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.objective', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Summary</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.summary', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Duration of the Course</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.duration', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Location of the Course</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.location', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Training Materials</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.training_materials', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>
										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">The Course Program&nbsp;&nbsp;<small class="hidden-xs hidden-sm hidden-md" style="font-weight:normal !important;color:#777777;">[ drag and drop lessons here. ]</small></label>
												<div class="col-sm-12">
														<div id="course_program">
				                        <?php
				                            if(isset($course_lessons) && $course_lessons)
				                            {
				                                foreach($course_lessons as $weekly_sched):
				                        ?>
				                        <p data-week="<?php echo $weekly_sched['week']; ?>" class="week<?php echo $weekly_sched['week']; ?>">
																	<table id="timetable" class="table table-bordered table-hover table-striped week<?php echo $weekly_sched['week']; ?>">
																			<thead class="thead-default">
																				 		<tr>
																								<th style="width:115px;">Days</th>
																								<th>Lessons</th>
																								<th style="width:165px;">Instructor</th>
																								<th style="width:140px;">Duration</th>
																								<th style="width:125px;">Time Slot</th>
																								<th style="width:50px;text-align:center;"><button type="button" class="btn btn-xs btn-default text-warning" id="js-remove_week" data-target=".week<?php echo $weekly_sched['week']; ?>" title="Remove Entire Week"><span class="fa fa-times"></span></button></th>
																				 		</tr>
				                                </thead>
																				<tbody>
						                                <?php
						                                    for($cntr=1; $cntr<=7; $cntr++):
						                                        if(isset($weekly_sched['children'][$cntr]) && $weekly_sched['children'][$cntr])
						                                        {
						                                            $daily_sched = $weekly_sched['children'][$cntr];
						                                ?>
						                                <tr style="height:65px;">
						                                    <td class="time"><?php echo $daily_sched['name']; ?></td>
						                                    <td colspan="5" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $daily_sched['day']; ?>">
																										<table class="schedule table" style="border:none !important;background:transparent !important;">
						                                            <?php foreach($daily_sched['children'] as $lesson): ?>
																														<tr style="background:transparent;border-bottom:1px solid #dedede !important;">
						                                                    <td style="border-top:none !important;"><?php echo $lesson['title']; ?></td>
						                                                    <td style="width:165px;border-top:none !important;"><img src="/img/searchbox_button.png" id="findInstructor" data-course_lesson_id="<?php echo $lesson['id']; ?>"/>&nbsp;<span id="instructorname"><?php echo $lesson['instructor'];?></span></td>
						                                                    <td style="width:135px;vertical-align:top;border-top:none !important;"><?php echo $lesson['duration']; ?></td>
						                                                    <td style="width:140px;vertical-align:top;border-top:none !important;">&nbsp;&nbsp;<select data-duration="<?php echo $lesson['duration']; ?>" data-course_lesson_id="<?php echo $lesson['id']; ?>" class="drop_start_time" style="width:65px;">
						                                                    <?php for($i=8; $i<24; $i++) {
						                                                            $time00 = ($i>9?$i:'0'.$i).':00';
						                                                            echo '<option'.($time00==$lesson['time_start']?' selected="selected"':'').'>'.$time00.'</option>';

						                                                            $time15 = ($i>9?$i:'0'.$i).':15';
						                                                            echo '<option'.($time15==$lesson['time_start']?' selected="selected"':'').'>'.$time15.'</option>';

						                                                            $time30 = ($i>9?$i:'0'.$i).':30';
						                                                            echo '<option'.($time30==$lesson['time_start']?' selected="selected"':'').'>'.$time30.'</option>';

						                                                            $time45 = ($i>9?$i:'0'.$i).':45';
						                                                            echo '<option'.($time45==$lesson['time_start']?' selected="selected"':'').'>'.$time45.'</option>';
						                                                        } ?></select> - <span class="t_end"><?php echo $lesson['time_end']; ?></span></td>
						                                                    <td style="width:35px;text-align:center;border-top:none !important;"><a href="/course_lessons/delete" data-id="<?php echo $lesson['id']; ?>" id="remove_from_schedule" title="Remove"><span class="text-danger fa fa-times"></span></a></td>
						                                                </tr>
						                                            <?php endforeach; ?>
						                                        </table>
						                                    </td>
						                                </tr>
						                                <?php
						                                        }
						                                        else
						                                        {
						                                ?>
						                                <tr style="height:65px;">
						                                    <td class="time"><?php echo $week_days_name[$cntr]; ?></td>
						                                    <td colspan="5" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $cntr; ?>">&nbsp;<br/><br/></td>
						                                </tr>
						                                <?php
						                                        }
						                                    endfor;
						                                ?>
																				</tbody>
				                            </table>
																</p>
				                        <?php
																				endforeach;
				                            }
				                            else
				                            {
				                        ?>
				                        <p data-week="1" class="week1">
																	 <table id="timetable" class="table table-bordered table-hover table-striped week1">
																				<thead class="thead-default">
																				 		<tr>
																								<th style="width:115px;">Days</th>
																								<th>Lessons</th>
																								<th style="width:165px;">Instructor</th>
																								<th style="width:140px;">Duration</th>
																								<th style="width:125px;">Time Slot</th>
																								<th style="width:50px;text-align:center;"><button type="button" class="btn btn-xs btn-default text-warning" id="js-remove_week" data-target=".week1" title="Remove Entire Week"><span class="fa fa-times"></span></button></th>
																				 		</tr>
				                                </thead>
																				<tbody>
																						<tr style="height:65px;">
																							<td class="time">Monday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="1">&nbsp;</td>
																						</tr>
																						<tr style="height:65px;">
																							<td class="time">Tuesday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="2">&nbsp;</td>
																						</tr>
																						<tr style="height:65px;">
																							<td class="time">Wednesday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="3">&nbsp;</td>
																						</tr>
																						<tr style="height:65px;">
																							<td class="time">Thursday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="4">&nbsp;</td>
																						</tr>
																						<tr style="height:65px;">
																							<td class="time">Friday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="5">&nbsp;</td>
																						</tr>
																						<tr style="height:65px;">
																							<td class="time">Saturday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="6">&nbsp;</td>
																						</tr>
																						<tr style="height:65px;">
																							<td class="time">Sunday</td>
																							<td colspan="5" class="schedules" data-week="1" data-day="7">&nbsp;</td>
																						</tr>
																				</tbody>
				                           </table>
				                        </p>
				                        <?php } ?>
				                    </div>
				                    <hr/>
				                    <div class="col-lg-12">
																<span class="pull-right">
																		<?php echo $this->Html->link('<span class="fa fa-calendar-plus-o" aria-hidden="true"></span> '.__('add week'), '/', array('class'=>'add_week btn btn-success', 'escape' => false)); ?>
																</span>
														</div>
												</div>
										</div>

										<br/>
										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Intake Limitation</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.intake_limitation', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>

										<br/>

										<div class="form-group form-group-sm">
												<label class="control-label control-label-left control-label-bottom-space col-sm-12">Certificate issuance and verification</label>
												<div class="col-sm-12">
														<?php echo $this->Form->input('CourseSpecification.certificate_issuance', array('class'=>'ckEditors', 'contenteditable'=>"true", 'cols'=>30, 'rows'=>6, 'placeholder'=>'[ add your content here ]')); ?>
												</div>
										</div>
								</div>
						<?php echo $this->Form->end(); ?>
				</div>

				<div class="clearfix"></div>
        <div class="col-xs-12 col-lg-offset-1 col-lg-10">
	        	<br/><br/>
						<hr/>
						<span class="pull-right">
								<a class="btn btn-sm btn-primary" href="/" data-target="#EditCourseForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
								<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'view', $course['Course']['id'])); ?>"><span class="fa fa-times"></span> Close</a>
						</span>
        </div>

		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("courses/course.main", "courses/course.edit"));
		echo $this->fetch("script");
?>
