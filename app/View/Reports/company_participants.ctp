<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'reports/report.main'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min', 'amcharts/amcharts', 'amcharts/pie', 'amcharts/serial', 'amcharts/themes/none', 'amcharts/plugins/dataloader/dataloader.min'));
?>
<div class="page-header">
    <h3 class="text-default">NO. OF PARTICIPANTS PER COMPANY</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<span class="pull-right">
								<?php echo $this->Form->input('customer_id', array("div"=>false, "label"=>false, 'options'=>$customers, 'id'=>'CustomerID', 'class'=>'easyui-combobox', 'style'=>'width:500px;', 'maxlength'=>'200', 'data-options'=>"onLoadSuccess: function(){\$(this).combobox('setValue','".(isset($customer_id)&&trim($customer_id)!=''?$customer_id:'')."');},panelHeight:'150px',prompt:'--- choose company ---'")); ?>&nbsp;&nbsp;<input id="YearStart" class="easyui-numberspinner" data-options="min:2013,max:2099,prompt:'-- year --'" value="<?php echo (isset($year)&&trim($year)!=''?$year:''); ?>" type="text" style="width:85px;"/>&nbsp;&nbsp;<?php echo $this->Html->link('Go', array('controller'=>'reports','action'=>'company_participants'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Apply filter', "data-options"=>"iconCls:'icon-filter'", "style"=>"padding: 0px 0px 0px 0px;", "id"=>"filtertrainingsummary"));?>&nbsp;<?php echo $this->Html->link('', array('controller'=>'reports','action'=>'company_participants'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Reset filter',  "data-options"=>"iconCls:'icon-reload'", "style"=>"padding: 0px 3px 0px 3px;"));?>
						</span>
						<div class="clearfix"></div>
				</div>
		</div>
</div>
<div class="box">
		<?php
				if(isset($nopPerCustomer))
				{
		        if(count($nopPerCustomer)>0)
		        {
		?>
		<h4 class="text-default"><button class="btn btn-xs btn-default tool_tips" style="margin-bottom:3px;" data-toggle="collapse" data-target="#chart" title="Hide/Show Chart"></button> <small>[ graphical presentation ]</small></h4>
    <div id="chart" class="well collapse in">
				<div class="row">
						<div id="noppercompany_cc" data-url="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'company_participants', (isset($year)&&trim($year)!=''?$year:'all'), (isset($customer_id)&&trim($customer_id)!=''?$customer_id:'customer'), 'json'));?>" class="col-sm-12" style="height:400px;"></div>
				</div>
    </div>
		<h4 class="text-default"><button class="btn btn-xs btn-default tool_tips collapsed" style="margin-bottom:3px;" data-toggle="collapse" data-target="#tableSummary" title="Hide/Show Detailed Summary"></button> <b>Detailed Summary</b></h4>
		<table class="table table-bordered table-striped table-hover">
				<thead class="thead-default">
						<tr>
								<th>Companies</th>
								<th>NoP</th>
						</tr>
				</thead>
				<tbody id="tableSummary" class="collapse out">
						<?php
								$totalParticipants = 0;
								foreach($nopPerCustomer as $customer)
								{
										if(intval($customer['Customer']['nop'])>0)
										{
												$totalParticipants += intval($customer['Customer']['nop']);
						?>
						<tr>
								<td><?php echo $customer['Customer']['name']; ?></td>
								<td><b><?php echo $customer['Customer']['nop']; ?></b></td>
						</tr>
						<?php
										}
								}
						?>
				</tbody>
				<tfoot>
						<tr style="background-color:#F2F9FF;">
								<td><b>TOTAL:</b></td>
								<td><b><?php echo $totalParticipants; ?></b></td>
						</tr>
				</tfoot>
		</table>
    <?php
		        }
		        else
		        {
		            echo "<div class=\"clearfix\" style=\"text-align:center;\">No records found!</div>";
		        }
				}
		    else
		    {
		        echo "<div class=\"clearfix\" style=\"text-align:center;\">Summary of participants per company will be displayed here.</div>";
		    }
    ?>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("reports/company.participants"));
		echo $this->fetch("script");
?>
