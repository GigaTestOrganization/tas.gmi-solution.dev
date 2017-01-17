<?php
	echo $this->Html->css(array('jquery.tagsinput'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">
	      INSTRUCTOR INFORMATION
				<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $instructor['Instructor']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($instructor['Instructor']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($instructor['Instructor']['modified']));?></small>
    </h3>
</div>
<div class="box">
    <div class="row">
				<div class="container-fluid">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-3"><?php echo $this->Html->image("person-avatar.png", array('class' => 'img-circle  img-responsive')); ?></div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-9">
								<br/>
								<div class="page-header">
										<h3 class="text-default">
												<small>Full Name</small> <b><?php echo $instructor['Instructor']['first_name'].' '.$instructor['Instructor']['last_name']; ?></b>
												<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Flex Instructor: <?php echo (intval($instructor['Instructor']['flex'])==1?'Yes':'No');?></small>
										</h3>
								</div>
								<br/>
								<div class="container-fluid">
										<?php if(isset($instructor['Instructor']['qualification']) && !empty($instructor['Instructor']['qualification'])): ?>
										<h4 class="text-default"><b>Qualification(s)</b></h4>
										<div class="tagsinput">
										<?php
												$tags = explode(',',$instructor['Instructor']['qualification']);
												if($tgcntr = count($tags)):
													for($i=0; $i<$tgcntr; $i++){ if(trim($tags[$i])!='') echo '<span class="tag">'.$tags[$i].'</span>'; }
												endif;
										?>
											<div class="clearfix"></div>
										</div>
										<?php endif; ?>
								</div>
						</div>
						<?php if(count($courses)>0): ?>
						<div class="clearfix"></div>
						<div class="col-lg-12">
								<br/><br/>
								<div class="page-header">
										<h4 class="text-default"><b>Delivered Course<?php echo (count($courses)>1?'s':''); ?></b></h4>
								</div>
								<table class="table table-bordered table-hover table-striped">
										<thead class="thead-default">
												<tr>
														<th><?php echo $this->Paginator->sort('Offering.code', 'Code'); ?></th>
														<th><?php echo $this->Paginator->sort('Course.title', 'Title'); ?></th>
														<th><?php echo $this->Paginator->sort('CourseCategory.name', 'Category'); ?></th>
												</tr>
										</thead>
										<tbody>
											<?php foreach($courses as $course): ?>
												<tr>
													<td><?php echo $course['Offering']['code']; ?></td>
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

						<div class="col-lg-12">
								<br/><br/>
								<hr/>
								<small class="pull-right">
					          <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'instructors', 'action'=>'edit', $instructor['Instructor']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
					          <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'instructors', 'action'=>'/')); ?>"><i class="fa fa-times"></i> Close</a>
					      </small>
						</div>
				</div>
		</div>
</div>
<br/><br/>
