<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'jquery.tagsinput'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min', 'jquery.tagsinput.min'));
?>
<div class="page-header">
    <h3 class="text-default">New Lesson</h3>
</div>
<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-1 col-lg-10">
						<?php echo $this->Form->create('Lesson', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'AddLessonForm', 'class'=>'form-horizontal', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Lesson Information</b></h4>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Duration:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('duration', array('class'=>'easyui-timespinner', 'style'=>'max-width:110px;', 'data-options'=>'required:true', 'alt'=>'time')); ?> <small class="text-default">(hh:mm)</small>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Title:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('title', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:100%;', 'data-options'=>'required:true', 'maxlength'=>200)); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Description:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('description', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:100%;height:80px;', 'data-options'=>'multiline:true')); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Learning Objective:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('objective', array('class'=>'easyui-textbox', 'type'=>'text', 'style'=>'width:100%;height:80px;', 'data-options'=>'multiline:true')); ?>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Link to Material:</label>
								<div class="col-sm-10" id="ltm_lst">
										<div class="btn-g" id="ltm">
												<input name="data[link_to_material][]" type="text" class="easyui-textbox" data-options="validType:'url'" style="width:93%;"/>
												<a href="/" class="btn btn-xs btn-success addlink"><span class="glyphicon glyphicon-plus-sign"></span></a>
												<a href="/" class="btn btn-xs btn-warning removelink"><span class="glyphicon glyphicon-minus-sign"></span></a>
										</div>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Tag(s):</label>
								<div class="col-sm-10">
										<input type="text" name="data[Lesson][tag]" id="LessonTag" value=""/>
								</div>
						</div>

						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">&nbsp;</label>
								<div class="col-sm-10">
										<label for="LessonPublished"><input name="data[Lesson][published]" value="1" type="checkbox" id="LessonPublished"/> Publish</label>
								</div>
						</div>
						<?php echo $this->Form->end(); ?>
				</div>

				<div class="clearfix"></div>
        <div class="col-xs-12 col-lg-offset-1 col-lg-10">
	        	<br/><br/>
						<hr/>
						<span class="pull-right">
								<a class="btn btn-sm btn-primary" href="/" data-target="#AddLessonForm" id="js-btnValidateBeforeSubmit"><span class="glyphicon glyphicon-floppy-disk"></span> Save</a>
								<a class="btn btn-sm btn-default text-warning" href="<?php echo $this->Html->url(array('controller'=>'lessons', 'action'=>'/')); ?>"><span class="fa fa-times"></span> Cancel</a>
						</span>
        </div>

		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("lessons/lesson.main"));
		echo $this->fetch("script");
?>
