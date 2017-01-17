<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">Export Training Schedule <small><i>( All events within the chosen dates will be included. )</i></small></h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<div class="pull-left">
								<form id="training_events" action="<?php echo $this->Html->url(array('action' => 'download', md5(time()), 'schedule', 1, 'Weekly_Schedule_'.date("\w\k-W-Y", strtotime($date_start)).'_'.date('Ymd_his').'.xlsx')); ?>" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal">Status: <select name="data[status]" class="easyui-combobox" id="js-event-status" data-options="{panelHeight:'auto',width:135}">
													 <option value="all"<?php echo ($event_status==='all'?' selected':'');?>>--------- All ---------</option>
													 <option value="0"<?php echo ($event_status==='0'?' selected':'');?>>For Confirmation</option>
													 <option value="1"<?php echo ($event_status==='1'?' selected':'');?>>Confirmed</option>
													 <option value="2"<?php echo ($event_status==='2'?' selected':'');?>>Delivered</option>
													 <option value="3"<?php echo ($event_status==='3'?' selected':'');?>>Invoiced</option>
													 <option value="4"<?php echo ($event_status==='4'?' selected':'');?>>Cancelled</option>
												</select>&nbsp;&nbsp; Date Range: <input id="js-date-start" name="data[date_start]" type="text" value="<?php echo $date_start; ?>"> - <input id="js-date-end" name="data[date_end]" type="text" value="<?php echo $date_end; ?>"> <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-search'" id="js-search-schedule" style="width: 85px;">Search</a></form>
						</div>
						<a href="#" class="easyui-menubutton pull-right" data-options="menu:'#mm1',iconCls:'icon-action'">Actions</a>
						<div id="mm1">
							<div class="tool_tips" title="Download Training Schedule" data-options="iconCls:'icon-save'" id="dl_training_schedule">Download</div>
							<div class="menu-sep"></div>
							<div class="tool_tips" title="Back to the list of Training Events" data-options="iconCls:'icon-back'" id="back_to_list_of_events">List of Events</div>
						</div>
						<div class="clearfix"></div>
				</div>
		</div>
		<div class="col-lg-12">
				<table class="table table-bordered table-hover table-striped">
						<thead class="thead-default">
		            <tr>
		                <th>Name</th>
		                <th>Status</th>
		                <th>Start</th>
		                <th>End</th>
		                <th width="50">NoP</th>
		            </tr>
		        </thead>
		        <tbody id="eventslist">
		        <?php
								if(!empty($events)):
										foreach($events as $event):
						?>
		            <tr>
		                <td><?php echo $this->Html->link($event['Course']['title'], array('action' => 'view', $event['Offering']['id'])); ?></td>
		                <td><?php echo $statuses[$event['Offering']['status']]; ?></td>
		                <td><?php echo date('M d, Y', strtotime($event['Offering']['date_start'])); ?></td>
		                <td><?php echo date('M d, Y', strtotime($event['Offering']['date_end']));?></td>
		                <td><center><?php echo $this->Html->link($event['Offering']['number_of_participants'], array('action' => 'view', $event['Offering']['id'])); ?></center></td>
		            </tr>
						<?php
									endforeach;
							else:
						?>
								<tr>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		                <td>&nbsp;</td>
		            </tr>
						<?php
							endif;
							unset($event);
						?>
		        </tbody>
				</table>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("offerings/offering.schedule"));
		echo $this->fetch("script");
?>
