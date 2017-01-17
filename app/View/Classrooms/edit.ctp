<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
		<h3 class="text-default"><small>[ edit ]</small> <?php echo $classroom['Classroom']['name']; ?> <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $classroom['Classroom']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($classroom['Classroom']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($classroom['Classroom']['modified']));?></small></h3>
</div>

<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-1 col-lg-10">
						<?php echo $this->Form->create('Classroom', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'EditClassroomForm', 'class'=>'form-horizontal', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Basic Information</b></h4>
								<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('name', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:500px;', 'data-options'=>'required:true', 'maxlength'=>200)); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Description:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('description', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:500px;height:80px;', 'data-options'=>'multiline:true')); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Capacity:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('capacity', array('class'=>'easyui-numberspinner', 'type'=>'text', 'style'=>'width:100px;')); ?> <span class="form-control-static">pax</span>
								</div>
						</div>
						<?php echo $this->Form->end();?>
				</div>

				<div class="clearfix"></div>
        <div class="col-xs-12 col-lg-offset-1 col-lg-10">
	        	<br/><br/>
						<hr/>
						<span class="pull-right">
								<a class="btn btn-sm btn-primary" href="/" data-target="#EditClassroomForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
								<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'classrooms', 'action'=>'view', $classroom['Classroom']['id'])); ?>"><span class="fa fa-times"></span> Cancel</a>
						</span>
        </div>

		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("instructors/instructor.main"));
		echo $this->fetch("script");
?>
