<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'jquery.tagsinput'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'jquery.tagsinput.min'));
?>
<div class="page-header">
    <h3 class="text-default">New Instructor</h3>
</div>
<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-1 col-lg-10">
						<?php echo $this->Form->create('Instructor', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'AddInstructorForm', 'class'=>'form-horizontal', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Basic Information</b></h4>
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
										<input type="text" name="data[Instructor][qualification]" id="InstructorQualification" value=""/>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">&nbsp;</label>
								<div class="col-sm-10">
										<label for="InstructorFlex"><input name="data[Instructor][flex]" value="1" type="checkbox" id="InstructorFlex"/> Flex</label>
								</div>
						</div>
						<?php echo $this->Form->end(); ?>
				</div>

				<div class="clearfix"></div>
        <div class="col-xs-12 col-lg-offset-1 col-lg-10">
	        	<br/><br/>
						<hr/>
						<span class="pull-right">
								<a class="btn btn-sm btn-primary" href="/" data-target="#AddInstructorForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
								<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'instructors', 'action'=>'/')); ?>"><span class="fa fa-times"></span> Cancel</a>
						</span>
        </div>

		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("instructors/instructor.main"));
		echo $this->fetch("script");
?>
