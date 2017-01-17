<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default"><small>[ <?php echo sprintf("%'.07d\n",$customer['Customer']['id']); ?> ]</small> <?php echo $customer['Customer']['name']; ?> <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $customer['Customer']['encoder_name'];?>&nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:ia', strtotime($customer['Customer']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:ia', strtotime($customer['Customer']['modified']));?></small></h3>
</div>
<div class="box">
		<div class="row">
				<div class="col-xs-12 col-lg-offset-2 col-lg-8">
						<?php echo $this->Form->create('Customer', array('inputDefaults'=>array('div'=>false, 'label'=>false), 'id'=>'EditCustomerForm', 'class'=>'form-horizontal', 'role' => 'form', 'data-toggle'=>'validator')); ?>
						<div class="page-header">
								<h4 class="text-default"><b>Customer Information</b></h4>
								<?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Name:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('name', array('id'=>'CustomerName', 'class' => 'form-control easyui-textbox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>'required:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Address:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('address', array('id'=>'CustomerAddress', 'class'=>'form-control easyui-textbox', 'style'=>'width:500px;height:80px;', 'maxlength'=>'200',  'data-options'=>'required:true, multiline:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Contact Number:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('contact_number', array('id'=>'CustomerContactNumber', 'class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'data-options'=>'required:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">Contact Person:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('contact_person', array('id'=>'CustomerContactPerson', 'class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'data-options'=>'required:true')); ?>
								</div>
						</div>
						<div class="form-group form-group-sm">
								<label class="control-label col-sm-2">E-mail Add:</label>
								<div class="col-sm-10">
										<?php echo $this->Form->input('email_add', array('id'=>'CustomerEmailAdd', 'class'=>'form-control easyui-textbox', 'style'=>'width:500px;', 'data-options'=>'required:true,validType:"email"')); ?>
								</div>
						</div>
						<hr/>
						<div class="form-group form-group-sm">
								<div class="col-sm-2"></div>
								<div class="col-sm-10">
										<span class="pull-right">
												<input type="submit" value="Submit" class="btn btn-sm btn-primary" data-target="#EditCustomerForm" id="js-btnValidateBeforeSubmit"/>
												<a class="btn btn-sm btn-default" id="cancelCustomerForm" href="<?php echo $this->Html->url(array('controller'=>'customers', 'action'=>'view', $customer['Customer']['id'])); ?>">Cancel</a>
										</span>
								</div>
						</div>
						<?php echo $this->Form->end();?>
				</div>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("customers/customer.main"));
		echo $this->fetch("script");
?>
