<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'jquery.tagsinput'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min', 'jquery.tagsinput.min'));
?>
<div class="page-header">
		<h3 class="text-default"><small>[ edit ]</small> <?php echo $instructor['Instructor']['first_name'].' '.$instructor['Instructor']['last_name']; ?> <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $instructor['Instructor']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($instructor['Instructor']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($instructor['Instructor']['modified']));?></small></h3>
</div>

<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-1 col-lg-10">
						<?php echo $this->Form->create('Instructor', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'EditInstructorForm', 'class'=>'form-horizontal', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Basic Information</b></h4>
								<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">First Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('first_name', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:500px;', 'data-options'=>'required:true', 'maxlength'=>200)); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Last Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('last_name', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:500px;', 'data-options'=>'required:true', 'maxlength'=>200)); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Qualification(s):</label>
								<div class="col-sm-10">
										<input type="text" name="data[Instructor][qualification]" id="InstructorQualification" value="<?php echo $instructor['Instructor']['qualification']; ?>"/>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">&nbsp;</label>
								<div class="col-sm-10">
										<label for="InstructorFlex"><input name="data[Instructor][flex]" value="1" type="checkbox"<?php echo ($instructor['Instructor']['flex']==1?' checked':''); ?> id="InstructorFlex"/> Flex</label>
								</div>
						</div>
						<?php echo $this->Form->end(); ?>
				</div>

				<div class="clearfix"></div>
        <div class="col-xs-12 col-lg-offset-1 col-lg-10">
	        	<br/><br/>
						<hr/>
						<span class="pull-right">
								<a class="btn btn-sm btn-primary" href="/" data-target="#EditInstructorForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
								<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'instructors', 'action'=>'view', $instructor['Instructor']['id'])); ?>"><span class="fa fa-times"></span> Cancel</a>
						</span>
        </div>

		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("instructors/instructor.main"));
		echo $this->fetch("script");
?>
