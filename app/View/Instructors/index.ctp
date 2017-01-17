<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">INSTRUCTORS</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<a href="#" class="easyui-menubutton pull-right" data-options="menu:'#mm1',iconCls:'icon-action'">Actions</a>
						<div id="mm1">
							<div class="tool_tips js-open-url" title="Add new instructor." data-options="iconCls:'icon-add'" data-href="<?php echo $this->Html->url("add"); ?>" id="add_new_instructor">Add New</div>
							<div class="menu-sep"></div>
							<div class="tool_tips" title="Search for instructor." data-options="iconCls:'icon-search'" id="dl_find_instructor">Find</div>
						</div>
						<div class="clearfix"></div>
				</div>
		</div>
		<div class="col-lg-12">
				<table class="table table-bordered table-hover table-striped">
						<thead class="thead-default">
								<tr>
										<th><?php echo $this->Paginator->sort('Instructor.first_name', 'First Name');?></th>
										<th><?php echo $this->Paginator->sort('Instructor.last_name', 'Last Name');?></th>
										<th><?php echo $this->Paginator->sort('Instructor.flex', 'Flex');?></th>
										<th><?php echo $this->Paginator->sort('Instructor.created', 'Created');?></th>
								</tr>
						</thead>
						<tbody>
								<?php foreach($instructors as $instructor): ?>
								<tr>
										<td><?php echo $this->Html->link($instructor['Instructor']['first_name'], array('action' => 'view', $instructor['Instructor']['id'])); ?></td>
										<td><?php echo $this->Html->link($instructor['Instructor']['last_name'], array('action' => 'view', $instructor['Instructor']['id'])); ?></td>
										<td><?php echo (intval($instructor['Instructor']['flex'])?'Yes':'No'); ?></td>
										<td><?php echo date("M d, Y - h:ia", strtotime($instructor['Instructor']['created'])); ?></td>
								</tr>
								<?php endforeach; ?>
								<?php unset($instructor); ?>
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
</div>
<br/><br/>
