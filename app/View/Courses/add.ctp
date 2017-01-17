<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'jquery.meio.mask.min', 'ckeditor/ckeditor'));
?>
<div class="page-header">
    <h3 class="text-default">New Course
				<small class="pull-right">
						<a class="btn btn-sm btn-primary" href="/" data-target="#AddCourseForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
						<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'/')); ?>"><span class="fa fa-times"></span> Cancel</a>
				</small>
		</h3>
</div>
<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-1 col-lg-10">
						<?php echo $this->Form->create('Course', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'AddCourseForm', 'class'=>'form-horizontal', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Basic Information</b></h4>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Category:</label>
								<div class="col-sm-10">
										<input id="CourseCategoryID" data-source-url="<?php echo $this->Html->url(array('controller'=>'course_categories', 'action'=>'generatejsontreestructure')); ?>" type="text" name="data[Course][course_category_id]" value="<?php echo (isset($this->params['pass'][0])&&trim($this->params['pass'][0])=='custom'?11:''); ?>" style="width:100%;"/>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Title:</label>
								<div class="col-sm-10">
										<input name="data[Course][title]" class="easyui-textbox" data-options="required:true" maxlength="200" style="width:100%;" type="text" value="" id="CourseTitle"/>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">&nbsp;</label>
								<div class="col-sm-10">
										<label for="CoursePublished"><input type="checkbox" name="data[Course][published]" value="1" id="CoursePublished"/> Publish</label>
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
										<label class="control-label control-label-left control-label-bottom-space col-sm-12">The Course Program</label>
										<div class="col-sm-12">
												<div class="input text" id="course_program">
		                         <p data-week="1">
															 	<table id="timetable" class="table table-bordered table-hover table-striped">
								                     <thead class="thead-default">
								                         <th style="width:115px;">Days</th>
								                         <th style="vertical-align:bottom;">Lessons</th>
								                         <th style="width:165px;">Instructor</th>
								                         <th style="width:135px;">Duration</th>
								                         <th style="width:145px;">Time Slot</th>
								                     </thead>
								                     <tr style="height:65px;">
								                         <td class="time">Monday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="1">&nbsp;<br/><br/></td>
								                     </tr>
								                     <tr style="height:65px;">
								                         <td class="time">Tuesday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="2">&nbsp;<br/><br/></td>
								                     </tr>
								                     <tr style="height:65px;">
								                         <td class="time">Wednesday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="3">&nbsp;<br/><br/></td>
								                     </tr>
								                     <tr style="height:65px;">
								                         <td class="time">Thursday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="4">&nbsp;<br/><br/></td>
								                     </tr>
								                     <tr style="height:65px;">
								                         <td class="time">Friday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="5">&nbsp;<br/><br/></td>
								                     </tr>
								                     <tr style="height:65px;">
								                         <td class="time">Saturday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="6">&nbsp;<br/><br/></td>
								                     </tr>
								                     <tr style="height:65px;">
								                         <td class="time">Sunday</td>
								                         <td colspan="4" class="schedules" data-week="1" data-day="7">&nbsp;<br/><br/></td>
								                     </tr>
								                </table>
		                        </p>
		                    </div>
										</div>
								</div>

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
								<a class="btn btn-sm btn-primary" href="/" data-target="#AddCourseForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
								<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'/')); ?>"><span class="fa fa-times"></span> Cancel</a>
						</span>
        </div>

		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("courses/course.main"));
		echo $this->fetch("script");
?>
