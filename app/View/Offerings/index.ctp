<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'calendar/fullcalendar', 'qtip/jquery.qtip', 'offerings/offering.index'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">TRAINING EVENTS</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<div class="btn-group" role="toolbar" aria-label="View Mode">
							  <button type="button" class="btn btn-info tool_tips js-viewmode" data-target="#view-list" title="List View" disabled><span class="glyphicon glyphicon-list"></span></button>
							  <button type="button" class="btn btn-info tool_tips js-viewmode" data-target="#calendar-events" title="Calendar View"><span class="glyphicon glyphicon-calendar"></span></button>
						</div>
						<small><i>(view mode)</i></small>
						<a href="#" class="easyui-menubutton pull-right"  data-options="menu:'#mm1',iconCls:'icon-action'">Actions</a>
						<div id="mm1">
								<div class="tool_tips js-open-url" title="Add new training event." data-options="iconCls:'icon-add'" data-href="<?php echo $this->Html->url("add"); ?>">Add New</div>
								<div class="menu-sep"></div>
								<div class="tool_tips js-open-url" title="Export training schedules in excel format." data-options="iconCls:'icon-calendar'" data-href="<?php echo $this->Html->url('schedule'); ?>">Export Schedule</div>
								<div class="menu-sep"></div>
								<div class="tool_tips" title="Search for training event." data-options="iconCls:'icon-search'">Find</div>
						</div>
						<div class="clearfix"></div>
				</div>
		</div>
		<div class="col-lg-12">
				<div class="view-stack">
						<div id="view-list" class="view-pane">
								<table class="table table-bordered table-hover table-striped">
										<thead class="thead-default">
						            <tr>
						                <th><?php echo $this->Paginator->sort('Offering.code', 'Code');?></th>
						                <th><?php echo $this->Paginator->sort('Course.title', 'Name');?></th>
						                <th><?php echo $this->Paginator->sort('Offering.status', 'Status');?></th>
						                <th><?php echo $this->Paginator->sort('Offering.date_start', 'Start');?></th>
						                <th><?php echo $this->Paginator->sort('Offering.date_end', 'End');?></th>
						                  <th width="50"><?php echo $this->Paginator->sort('Offering.number_of_participants', 'NoP', array('class'=>'tool_tips', 'title'=>'Number of Participants'));?></th>
						            </tr>
										</thead>
										<tbody>
						            <?php foreach($offerings as $offering): ?>
						            <tr>
						                <td><?php echo $offering['Offering']['code']; ?></td>
						                <td><?php echo $this->Html->link($offering['Course']['title'], array('action' => 'view', $offering['Offering']['id'])); ?></td>
						                <td><?php echo $statuses[$offering['Offering']['status']]; ?></td>
						                <td><?php echo date('M d, Y', strtotime($offering['Offering']['date_start'])); ?></td>
						                <td><?php echo date('M d, Y', strtotime($offering['Offering']['date_end']));?></td>
						                <td align="center"><center><?php echo $this->Html->link($offering['Offering']['number_of_participants'], array('action' => 'view', $offering['Offering']['id'])); ?></center></td>
						            </tr>
						            <?php endforeach; ?>
						            <?php unset($offering); ?>
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
						<div id="calendar-events" class="view-pane inactive"></div>
						<div id="loading-events"><?php echo $this->Html->image("/img/waiting.gif"); ?><br/>loading events...</div>
				</div>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("qtip/jquery.qtip", "calendar/lib/moment.min", "calendar/fullcalendar.min", "offerings/offering.index"));
		echo $this->fetch("script");
?>
