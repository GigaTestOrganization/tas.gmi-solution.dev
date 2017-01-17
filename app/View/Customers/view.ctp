<div class="page-header">
    <h3 class="text-default">COMPANY INFORMATION <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $customer['Customer']['encoder_name'];?>&nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:ia', strtotime($customer['Customer']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:ia', strtotime($customer['Customer']['modified']));?></small></h3>
</div>
<div class="row">
		<div class="col-lg-12" style="margin-bottom:5px;">
        <span class="pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'customers', 'action'=>'edit', $customer['Customer']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
            <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'customers', 'action'=>'/')); ?>"><i class="glyphicon glyphicon-remove"></i> Close</a>
        </span>
        <div class="clearfix"></div>
    </div>
</div>
<div class="box">
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2"><?php echo $this->Html->image("no-logo.png", array('class' => 'img-circle  img-responsive')); ?></div>
        <div class="col-xs-9 col-sm-9 col-md-10 col-lg-10">
    		    <h1><small>[ <?php echo sprintf("%'.07d\n",$customer['Customer']['id']); ?> ]</small> <?php echo ucwords(strtolower($customer['Customer']['name'])); ?></h1>
    		    <h3 class="panel-title">
                <small style="font-size:11px !important;">
                    <dl class="dl-horizontal dl-bottom-margins">
                        <dt>&nbsp;</dt> <dd>&nbsp;</dd>
                        <dt>Address:</dt> <dd><?php echo $customer['Customer']['address'];?></dd>
            						<dt>Contact Number :</dt> <dd><?php echo $customer['Customer']['contact_number'];?></dd>
                        <?php if(isset($customer['Customer']['contact_person']) && trim($customer['Customer']['contact_person'])!=''):?>
            						<dt>Contact Person:</dt> <dd><?php echo $customer['Customer']['contact_person'];?></dd>
            						<?php endif; ?>
            						<dt>E-mail Address :</dt> <dd><?php echo $this->Text->autoLinkEmails($customer['Customer']['email_add']);?></dd>
        				    </dl>
                </small>
            </h3>
        </div>
    </div>
</div>
