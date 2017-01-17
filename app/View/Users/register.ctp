<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'jquery.meio.mask.min'));
?>
<div class="page-header">
		<h3 class="text-default">Account Registration</h3>
</div>
<div class="box">
	<div class="row">
			<div class="col-sm-offset-2	col-sm-8">
					<?php echo $this->Form->create('Users', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'RegisterAccountForm', 'accept-charset'=>'utf-8', 'class'=>'form-horizontal', 'autocomplete'=>'off', 'role' => 'form', 'data-toggle'=>'validator')); ?>
					<div class="page-header">
							<h4 class="text-default"><b>Personal Information</b></h4>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">First Name:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('UserProfile.first_name', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>'required:true')); ?>
							</div>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Last Name:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('UserProfile.last_name', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>'required:true')); ?>
							</div>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">E-mail:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('UserProfile.email_add', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"required:true,validType:'email'")); ?>
							</div>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Mobile Number:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('UserProfile.mobile_number', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
							</div>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Telephone Number:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('UserProfile.telephone_number', array('class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200')); ?>
							</div>
					</div>

					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Company:</label>
							<div class="col-sm-9">
									<div class="row">
											<div class="col-sm-12" style="margin-bottom:10px;">
													<input type="radio" name="isanewcompany" value="0" checked="checked" class="pull-left"/>
													<span class="pull-left" style="margin-left:5px;">
														<select name="data[UserProfile][customer_id]" id="UserProfileCustomerId" class="form-control easyui-combobox" data-options="onLoadSuccess: function(){$(this).combobox('setValue','');},panelHeight:'150px',required:true,prompt:'--- please select company ---'" style="width:480px;">
																<?php foreach($customers as $customer):?>
																<option value="<?php echo $customer['Customer']['id']; ?>"><?php echo $customer['Customer']['name']; ?></option>
																<?php endforeach; unset($customer); ?>
														</select>
													</span>
											</div>
											<div class="col-sm-12">
													<input type="radio" name="isanewcompany" value="1" class="pull-left"/>
													<span class="pull-left" style="margin-left:5px;">
														<input name="data[company_name]" id="NewCompany" class="easyui-textbox" type="text" style="width:480px;" data-options="prompt:'[new company name here]',required:true,disabled:true"/>
														<div id="CompanyAdditionalInfo" style="margin-top:5px;display:none;">
															<input name="data[company_address]" id="NewCompanyAddress" class="easyui-textbox" type="text" style="width:480px;min-height:60px;" data-options="multiline:true,prompt:'please type the company address here...',required:true,disabled:true"/>
														</div>
													</span>
											</div>
									</div>
							</div>
					</div>
					<br/>
					<div class="page-header">
							<h4 class="text-default"><b>Credentials</b></h4>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Username:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('User.username', array('class' => 'form-control easyui-textbox', 'style'=>'width:300px;', 'maxlength'=>'200', 'data-options'=>"required:true,iconCls:'icon-man',iconWidth:38")); ?>
							</div>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Password:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('User.password', array('type'=>'password', 'id'=>'UserPassword', 'class' => 'form-control easyui-textbox', 'style'=>'width:300px;', 'maxlength'=>'200', 'data-options'=>"required:true,iconCls:'icon-lock',iconWidth:38")); ?>
							</div>
					</div>
					<div class="form-group form-group-sm">
							<label class="control-label col-sm-3">Re-type Password:</label>
							<div class="col-sm-9">
									<?php echo $this->Form->input('User.retype_password', array('type'=>'password', 'class' => 'form-control easyui-textbox', 'style'=>'width:300px;', 'maxlength'=>'200', 'data-options'=>"required:true,iconCls:'icon-lock',iconWidth:38,validType:'equals[\'#UserPassword\']'")); ?>
							</div>
					</div>
					<hr/>
					<div class="form-group form-group-sm">
							<div class="col-sm-2"></div>
							<div class="col-sm-10">
									<span class="pull-right">
											<input type="submit" value="Submit" class="btn btn-sm btn-primary" data-target="#RegisterAccountForm" id="js-btnValidateBeforeSubmit"/>
											<a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'/')); ?>" id="js-clearForm">Cancel</a>
									</span>
							</div>
					</div>
					<?php $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function()
	{
			$.extend($.fn.validatebox.defaults.rules, {equals: {validator: function(value,param){return value == $(param[0]).val();}, message: "Password don't match."}});

			$("#js-btnValidateBeforeSubmit").click(function($e){ $e.preventDefault(); if($('#RegisterAccountForm').form('validate')) $('#RegisterAccountForm').submit();});
			$("#js-clearForm").click(function($e){ $e.preventDefault(); $('#RegisterAccountForm').form('clear'); });
			$("input[name='isanewcompany']:radio").change(function($e)
			{
					$("#UserProfileCustomerId").combobox({disabled:parseInt($(this).val())});					
					$("#UserProfileCustomerId").combobox('setValue','');
					$("#NewCompany").textbox({disabled:!parseInt($(this).val())});
					$("#NewCompanyAddress").textbox({disabled:!parseInt($(this).val())});
					if(parseInt($(this).val())) $("#CompanyAdditionalInfo").fadeIn('slow'); else $("#CompanyAdditionalInfo").hide();
			});
	});
</script>
