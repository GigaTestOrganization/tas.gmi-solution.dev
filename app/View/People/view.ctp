<div class="page-header">
    <h3 class="text-default">PERSON INFORMATION <small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoded By: <?php echo $person['Person']['encoder_name'];?>&nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:ia', strtotime($person['Person']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:ia', strtotime($person['Person']['modified']));?></small></h3>
</div>
<div class="row">
		<div class="col-lg-12" style="margin-bottom:5px;">
        <span class="pull-right">
            <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'edit', $person['Person']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
            <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'people', 'action'=>'/')); ?>"><i class="glyphicon glyphicon-remove"></i> Close</a>
        </span>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-info">
          <div class="panel-heading">
              <div class="row">
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3"><?php echo $this->Html->image("person-avatar.png", array('class' => 'img-circle  img-responsive')); ?></div>
                  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-9">
              		    <h1><?php echo ucwords(strtolower($person['Person']['fullname'])); ?></h1>
              		    <h3 class="panel-title">
                          <small style="font-size:10px !important;">
                              <dl class="dl-horizontal dl-bottom-margins">
                                  <dt>Mobile Number : </dt> <dd><?php echo (trim($person['Person']['mobile_number'])!=''?$person['Person']['mobile_number']:'- not specified -');?></dd>
                                  <dt>Tel. Number : </dt> <dd><?php echo (trim($person['Person']['telephone_number'])!=''?$person['Person']['telephone_number']:'- not specified -');?></dd>
                                  <dt>E-mail Address : </dt> <dd><?php echo (trim($person['Person']['email_add'])!=''?$this->Text->autoLinkEmails($person['Person']['email_add']):'- not specified -');?></dd>
                  				    </dl>
                          </small>
                      </h3>
                  </div>
              </div>
          </div>
          <div class="panel-body">
              <dl class="dl-horizontal dl-bottom-margins">
                  <dt>&nbsp;</dt> <dd>&nbsp;</dd>
                  <dt>Date of Birth : </dt> <dd><?php echo (trim($person['Person']['date_of_birth'])!=''?date('M d, Y', strtotime($person['Person']['date_of_birth'])):'- not specified -');?></dd>
                  <dt>Company : </dt> <dd><?php echo (trim($person['Customer']['name'])!=''?$this->Html->link($person['Customer']['name'], array('controller'=>'customers', 'action'=>'view', $person['Person']['customer_id'])):'N/A');?></dd>
                  <dt>Cadet Type : </dt> <dd><?php echo (empty($person['Person']['cadet_type'])?'N/A':$person['Person']['cadet_type']);?></dd>
                  <dt>Degree : </dt> <dd><?php echo (trim($person['Person']['degree'])!=''?$person['Person']['degree']:'- not specified -');?></dd>
                  <dt>Education : </dt> <dd><?php echo (trim($person['Person']['education'])!=''?$person['Person']['education']:'- not specified -');?></dd>
                  <dt>PRC License : </dt> <dd><?php echo (trim($person['Person']['prc_license'])!=''?$person['Person']['prc_license']:'N/A');?></dd>
                  <dt>Home Address : </dt> <dd><?php echo (trim($person['Person']['home_address'])!=''?$person['Person']['home_address']:'- not specified -');?></dd>
              </dl>
          </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="box">
            <div class="page-header">
                <h2 class="text-default">Marine Sea-going Service Info</h2>
            </div>
            <dl class="dl-horizontal dl-bottom-margins">
        				<dt>Rank : </dt> <dd><?php echo (trim($person['Person']['rank_id'])!=''?$person['Person']['rank_id']:'N/A');?></dd>
        		    <dt>Years of Service : </dt> <dd><?php echo (trim($person['Person']['years_of_service'])!=''?$person['Person']['years_of_service'].' yr'.(intval($person['Person']['years_of_service'])>1?'s':'').'.':'N/A');?></dd>
        				<dt>Last Vessel : </dt> <dd><?php echo (trim($person['Person']['last_vessel'])!=''?$person['Person']['last_vessel']:'N/A');?></dd>
        				<dt>Next Vessel : </dt> <dd><?php echo (trim($person['Person']['next_vessel'])!=''?$person['Person']['next_vessel']:'N/A');?></dd>
        				<dt>Principal : </dt> <dd><?php echo (trim($person['Person']['principal'])!=''?$person['Person']['principal']:'N/A');?></dd>
        				<dt>Manning Agent : </dt> <dd><?php echo (trim($person['Person']['manning_agent'])!=''?$person['Person']['manning_agent']:'N/A');?></dd>
      			</dl>
        </div>
    </div>

    <?php if(count($courses)>0): ?>
    <div class="col-lg-12">
        <div class="page-header">
            <h3 class="text-default">Course<?php (count($courses)>1?'s':''); ?> Taken</h3>
        </div>
        <table class="table table-bordered table-hover table-striped">
						<thead class="thead-default">
                <tr>
                    <th><?php echo $this->Paginator->sort('Course.code', 'Code'); ?></th>
		                <th><?php echo $this->Paginator->sort('Course.title', 'Title'); ?></th>
		                <th><?php echo $this->Paginator->sort('CourseCategory.name', 'Category'); ?></th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($courses as $course): ?>
                <tr>
                  <td><?php echo $course['Course']['code']; ?></td>
                  <td><?php echo $this->Html->link($course['Course']['title'], array('controller'=>'courses', 'action' => 'view', $course['Course']['id'])); ?></td>
                  <td><?php echo $this->Html->link($course['CourseCategory']['name'], array('controller' => 'coursecategories', 'action' => 'view', $course['CourseCategory']['id'])); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
						<div class="col-lg-12">
								<p class="pull-left"><?php echo $this->Paginator->counter('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}');?></p>
								<div class="pull-right">
										<ul class="pagination pagination-margin-0 pagination-xs">
												<?php
														echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
														echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
														echo $this->Paginator->next(__('next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
												?>
										</ul>
								</div>
						</div>
				</div>
    </div>
    <?php endif; ?>

</div>
