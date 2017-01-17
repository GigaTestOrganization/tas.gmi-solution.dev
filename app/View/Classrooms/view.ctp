<div class="page-header">
    <h3 class="text-default">
	      CLASSROOM INFORMATION
				<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $classroom['Classroom']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($classroom['Classroom']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($classroom['Classroom']['modified']));?></small>
    </h3>
</div>
<div class="box">
    <div class="row">
				<div class="col-lg-offset-1 col-lg-10">
						<div class="col-lg-12">
								<div class="page-header">
										<h3 class="text-default">
												<small>Room Name</small> <b><?php echo $classroom['Classroom']['name']; ?></b>
												<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Capacity: <?php echo (trim($classroom['Classroom']['capacity'])!=''?$classroom['Classroom']['capacity']:'-- not specified --'); ?></small>
										</h3>
								</div>
								<br/>
								<div class="container-fluid">
										<?php if(isset($classroom['Classroom']['description']) && !empty($classroom['Classroom']['description'])): ?>
										<h4 class="text-default"><b>Description</b></h4>
								    <p><?php echo $classroom['Classroom']['description']; ?></p>
								    <br/>
										<?php endif; ?>
								    <?php if(count($courses)>0): ?>
												<h4 class="text-default"><b>Conducted Course<?php echo (count($courses)>1?'s':''); ?></b></h4>
							        	<table class="table table-bordered table-hover table-striped">
													<thead class="thead-default">
							                <tr>
							                    <th><?php echo $this->Paginator->sort('Offering.code', 'Code'); ?></th>
									                <th><?php echo $this->Paginator->sort('Course.title', 'Title'); ?></th>
									                <th><?php echo $this->Paginator->sort('CourseCategory.name', 'Category'); ?></th>
									                <th><?php echo $this->Paginator->sort('Offering.date_start', 'Date Start'); ?></th>
									                <th><?php echo $this->Paginator->sort('Offering.date_end', 'Date End'); ?></th>
							                </tr>
							            </thead>
							            <tbody>
							              <?php foreach($courses as $course): ?>
															<tr>
								                	<td><?php echo $course['Offering']['code']; ?></td>
								                	<td><?php echo $this->Html->link($course['Course']['title'], array('controller'=>'courses', 'action' => 'view', $course['Course']['id'])); ?></td>
								                	<td><?php echo $this->Html->link($course['CourseCategory']['name'], array('controller' => 'coursecategories', 'action' => 'view', $course['CourseCategory']['id'])); ?></td>
								                  <td><?php echo date('M d, Y', strtotime($course['Offering']['date_start'])); ?></td>
								                  <td><?php echo date('M d, Y', strtotime($course['Offering']['date_end'])); ?></td>
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
								    <?php endif; ?>
								</div>
						</div>

						<div class="col-lg-12">
								<br/><br/>
								<hr/>
								<small class="pull-right">
					          <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'classrooms', 'action'=>'edit', $classroom['Classroom']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
					          <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'classrooms', 'action'=>'/')); ?>"><i class="fa fa-times"></i> Close</a>
					      </small>
						</div>
				</div>
		</div>
</div>
<br/><br/>
