<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3><span class="glyphicon glyphicon-education"></span> ON-GOING EVENTS <small>( present week)</small></h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<?php if(count($thisWeeksEvents) > 0): ?>
				<div class="table-responsive">
						<table id="Sectors" class="table table-bordered table-hover table-striped">
								<thead class="thead-default">
										<tr>
												<th>Code</th>
												<th>Name</th>
												<th>Start</th>
												<th>End</th>
												<th style="text-align:right !important;"><span class="tool_tips" title="Number of Participants">NoP</span></th>
										</tr>
								</thead>
								<tbody>
										<?php foreach($thisWeeksEvents as $event): ?>
										<tr>
												<td><?php echo $event['Offering']['code']; ?></td>
												<td><?php echo $this->Html->link($event['Course']['title'], array('controller' => 'offerings', 'action' => 'view', $event['Offering']['id'])); ?></td>
												<td><?php echo date('M d, Y', strtotime($event['Offering']['date_start'])); ?></td>
												<td><?php echo date('M d, Y', strtotime($event['Offering']['date_end'])); ?></td>
												<td style="text-align:right !important;"><?php echo $event['Offering']['number_of_participants']; ?></td>
										</tr>
										<?php endforeach; ?>
										<?php unset($event); ?>
								</tbody>
						</table>
				</div>
				<?php
						else:
								echo "No event is currently scheduled!";
						endif;
				?>
				<div class="page-header">
				    <h3><span class="glyphicon glyphicon-education"></span> FUTURE EVENTS <small>( next three weeks )</small></h3>
				</div>
				<?php if(count($nextThreeWeeksEvents) > 0): ?>
				<div class="table-responsive">
						<table id="Sectors" class="table table-bordered table-hover table-striped">
								<thead class="thead-default">
										<tr>
								        <th>Code</th>
								        <th>Name</th>
								        <th>Start</th>
								        <th>End</th>
								        <th style="text-align:right !important;"><span class="tool_tips" title="Number of Participants">NoP</span></th>
								  	</tr>
								</thead>
								<tbody>
							      <?php foreach($nextThreeWeeksEvents as $nextEvent): ?>
							      <tr>
							          <td><?php echo $nextEvent['Offering']['code']; ?></td>
							          <td><?php echo $this->Html->link($nextEvent['Course']['title'], array('controller' => 'offerings', 'action' => 'view', $nextEvent['Offering']['id'])); ?></td>
							          <td><?php echo date('M d, Y', strtotime($nextEvent['Offering']['date_start'])); ?></td>
							          <td><?php echo date('M d, Y', strtotime($nextEvent['Offering']['date_end']));?></td>
							         <td style="text-align:right !important;"><?php echo $nextEvent['Offering']['number_of_participants']; ?></td>
							      </tr>
							      <?php endforeach; ?>
							      <?php unset($nextEvent); ?>
								</tbody>
						</table>
				</div>
				<?php
						else:
								echo "No event is currently scheduled!";
						endif;
				?>
		</div>
</div>
