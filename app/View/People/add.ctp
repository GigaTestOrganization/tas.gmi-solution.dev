<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
		echo $this->fetch("css");
?>
<div class="page-header">
    <h3 class="text-default">New Person</h3>
</div>
<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-2 col-lg-8">
						<?php echo $this->Form->create('Person', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'AddPersonForm', 'class'=>'form-horizontal', 'role' => 'form', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Personal Information</b></h4>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">First Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('first_name', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>'required:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Middle Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('middle_name', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"prompt:'(optional)'")); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Last Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('last_name', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>'required:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Date of Birth:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('date_of_birth', array('id'=>'PersonDateOfBirth', 'type'=>'text', 'class' => 'form-control', 'style'=>'width:180px;', 'maxlength'=>'200', 'data-options'=>'required:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Home Address:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('home_address', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">E-mail Add:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('email_add', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"validType:'email'")); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Mobile Number:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('mobile_number', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Telephone Number:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('telephone_number', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Education:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('education', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Degree:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('degree', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">PRC License:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('prc_license', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>'prompt:"( if there\'s any )"')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Company:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('customer_id', array('class' => 'form-control easyui-combobox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"onLoadSuccess: function(){\$(this).combobox('setValue','');},panelHeight:'150px',required:true,prompt:'--- please select company ---'")); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Cadet Type:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('cadet_type', array('options'=>$cadetTypes, 'class'=>'form-control easyui-combobox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"onLoadSuccess: function(){\$(this).combobox('setValue','');},panelHeight:'150px',required:true,prompt:'--- please select type ---'")); ?>
								</div>
						</div>
						<br/>
						<div class="page-header">
								<h4 class="text-default"><b>Applicable for Marines only.</b></h4>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Years of Service:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('years_of_service', array('type'=>'text', 'class'=>'form-control easyui-numberspinner', 'style'=>'width:70px;', 'data-options'=>'min:0,max:900,maxlength:3,suffix:" yrs."')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Last Vessel:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('last_vessel', array('class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Next Vessel:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('next_vessel', array('class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Rank:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('rank_id', array('class'=>'form-control easyui-combobox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"panelHeight:'auto',prompt:'--- please select rank ---'")); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Principal:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('principal', array('class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Manning Agent:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('manning_agent', array('class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
								</div>
						</div>
						<hr/>
						<div class="form-group form-group-sm">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
										<span class="pull-right">
												<input type="submit" value="Submit" class="btn btn-sm btn-primary" data-target="#AddPersonForm" id="js-btnValidateBeforeSubmit"/>
												<a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'/')); ?>">Cancel</a>
										</span>
								</div>
						</div>
	          <?php echo $this->Form->end();?>
				</div>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("jquery.easyui.min", "people/person.main"));
		echo $this->fetch("script");
?>
