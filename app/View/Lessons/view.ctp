<?php
	echo $this->Html->css(array('jquery.tagsinput'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.tagsinput.min'));
?>
<div class="page-header">
    <h3 class="text-default">
	      LESSON INFORMATION
				<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Encoder: <?php echo $lesson['Lesson']['encoder_name'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Date Created: <?php echo date('M d, Y - h:i a', strtotime($lesson['Lesson']['created']));?>&nbsp;&nbsp;|&nbsp;&nbsp;Last Modified: <?php echo date('M d, Y - h:i a', strtotime($lesson['Lesson']['modified']));?></small>
    </h3>
</div>
<div class="box">
    <div class="row">
				<div class="col-lg-offset-1 col-lg-10">
						<div class="col-lg-12">
								<div class="page-header">
										<h3 class="text-default">
												<small>[ <?php echo $lesson['Lesson']['code']; ?> ]</small> <b><?php echo $lesson['Lesson']['title']; ?></b>
												<small class="pull-right" style="font-size:10px !important;margin-top:15px;">Duration (hh:mm): <?php echo $lesson['Lesson']['duration'];?> &nbsp;&nbsp;|&nbsp;&nbsp;Published: <?php echo (intval($lesson['Lesson']['published'])==1?'Yes':'No');?></small>
										</h3>
								</div>
								<br/>
								<div class="container-fluid">
										<?php if(isset($lesson['Lesson']['description']) && !empty($lesson['Lesson']['description'])): ?>
										<h4 class="text-default"><b>Description</b></h4>
								    <p><?php echo $lesson['Lesson']['description']; ?></p>
								    <br/>
										<?php endif; ?>
										<?php if(isset($lesson['Lesson']['objective']) && !empty($lesson['Lesson']['objective'])): ?>
								    <h4 class="text-default"><b>Objective</b></h4>
								    <p><?php echo $lesson['Lesson']['objective'];?></p>
								    <br/>
										<?php endif; ?>
										<?php if(isset($lesson['Lesson']['link_to_material']) && !empty($lesson['Lesson']['link_to_material'])): ?>
										<h4 class="text-default"><b>Link to Materials</b></h4>
								    <?php
												$ltms = explode('<-:::->', $lesson['Lesson']['link_to_material']);
												if(count($ltms)):
														foreach($ltms as $key => $ltm):
										?>
								    <p><a href="<?php echo $ltm; ?>"><?php echo $ltm; ?></a></p>
										<?php
														endforeach;
												endif;
										?>
								    <br/>
										<?php endif; ?>
										<?php if(isset($lesson['Lesson']['tag']) && !empty($lesson['Lesson']['tag'])): ?>
								    <h4 class="text-default"><b>Tag(s)</b></h4>
								    <div class="tagsinput">
								    <?php
												$tags = explode(',',$lesson['Lesson']['tag']);
												if($tgcntr = count($tags)):
													for($i=0; $i<$tgcntr; $i++){ if(trim($tags[$i])!='') echo '<span class="tag">'.$tags[$i].'</span>'; }
												endif;
										?>
										<div class="clearfix"></div>
								    </div>
								    <br/>
										<?php endif; ?>
								    <?php if(count($courses)>0): ?>

												<h4 class="text-default"><b>Course<?php echo (count($courses)>1?'s':''); ?> Taken</b></h4>
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
								    <?php endif; ?>
								</div>
						</div>

						<div class="col-lg-12">
								<br/><br/>
								<hr/>
								<small class="pull-right">
					          <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'lessons', 'action'=>'edit', $lesson['Lesson']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
					          <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'lessons', 'action'=>'/')); ?>"><i class="fa fa-times"></i> Close</a>
					      </small>
						</div>
				</div>
		</div>
</div>
<br/><br/>
