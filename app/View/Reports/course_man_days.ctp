<?php
		echo $this->Html->css(array('themes/default/easyui', 'themes/icon', 'reports/report.main'), 'stylesheet', array('media'=>'all'));
		echo $this->Html->script(array('jquery.easyui.min', 'amcharts/amcharts', 'amcharts/pie', 'amcharts/serial', 'amcharts/themes/none', 'amcharts/plugins/dataloader/dataloader.min'));
?>
<div class="page-header">
    <h3 class="text-default">COURSE MAN DAYS</h3>
</div>
<div class="row">
		<div class="col-lg-12">
				<div class="actionbar">
						<span class="pull-right">
								<?php echo $this->Form->input("FromMonth", array('div'=>false, 'label'=>false, "type"=>"select", "options"=>$months, "id"=>"FromMonth", "class"=>"easyui-combobox", "data-options"=>(!isset($this->params['data']['FromMonth'])||trim($this->params['data']['FromMonth'])==''?"onLoadSuccess: function(){\$(this).combobox('setValue','');},":"")."panelHeight:'auto',prompt:'-- From --'", 'style'=>'width:95px;')); ?> - <?php echo $this->Form->input("ToMonth", array('div'=>false, 'label'=>false, "type"=>"select", "options"=>$months, "id"=>"ToMonth", "class"=>"easyui-combobox", "data-options"=>(!isset($this->params['data']['ToMonth'])||trim($this->params['data']['ToMonth'])==''?"onLoadSuccess: function(){\$(this).combobox('setValue','');},":"")."panelHeight:'auto',prompt:'-- From --'", 'style'=>'width:95px;')); ?>&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo $this->Form->input('year', array('div'=>false, 'label'=>false, "type"=>"text", 'id'=>'OfferYearStart', 'class'=>'easyui-numberspinner', 'data-options'=>"min:2013,max:2099,prompt:'-- year --'", 'style'=>'width:85px;')); ?>&nbsp;&nbsp;<?php echo $this->Html->link('Go', array('controller'=>'reports','action'=>'course_man_days'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Apply filter', "data-options"=>"iconCls:'icon-filter'", "style"=>"padding: 0px 0px 0px 0px;", "id"=>"filtercoursesummary"));?>&nbsp;<?php echo $this->Html->link('', array('controller'=>'reports','action'=>'course_man_days'), array("class"=>"easyui-linkbutton tool_tips", 'title'=>'Reset filter',  "data-options"=>"iconCls:'icon-reload'", "style"=>"padding: 0px 3px 0px 3px;"));?>
						</span>
						<div class="clearfix"></div>
				</div>
		</div>
</div>
<div class="box">
	  <?php
				if(isset($course_summary))
				{
		        if(count($course_summary)>0)
		        {
		            $smry_counter = 0;
		            foreach($course_summary as $year => $events)
		            {
    ?>
		<h4 class="text-default"><button class="btn btn-xs btn-default tool_tips" style="margin-bottom:3px;" data-toggle="collapse" data-target="#chart<?php echo $smry_counter; ?>" title="Hide/Show Chart"></button> <b>Year <?php echo $year; ?></b> <small>[ graphical presentation ]</small></h4>
    <div class="well collapse in" id="chart<?php echo $smry_counter; ?>">
				<div class="row">
					<div id="piechart_<?php echo $smry_counter; ?>" data-target="piechart_<?php echo $smry_counter; ?>" data-url="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'course_man_days', (isset($month_range)?$month_range:'month'), $year, 'json-permonth'));?>" class="col-sm-6 js-amcharts-pie" style="height:350px;"></div>
					<div id="columnchart_<?php echo $smry_counter; ?>" data-target="columnchart_<?php echo $smry_counter; ?>" data-url="<?php echo $this->Html->url(array('controller'=>'reports','action'=>'course_man_days', (isset($month_range)?$month_range:'month'), $year, 'json-percourse'));?>" class="col-sm-6 js-amcharts-column" style="height:350px;"></div>
				</div>
    </div>
		<h4 class="text-default"><button class="btn btn-xs btn-default tool_tips collapsed" style="margin-bottom:3px;" data-toggle="collapse" data-target="#table<?php echo $smry_counter; ?>" title="Hide/Show Detailed Summary"></button> <b>Detailed Summary</b></h4>
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-default">
            <tr>
                <th>Courses</th>
                <?php for($mnt=$mstart; $mnt<=$mend; $mnt++): ?><th style="text-align:right !important;"><?php echo date("M", mktime(0, 0, 0, $mnt, 10))?></th><?php endfor; ?>
                <th style="text-align:right !important;">TOTAL</th>
            </tr>
        </thead>
        <tbody class="collapse out" id="table<?php echo $smry_counter; ?>">
        <?php
            foreach($events['annual'] as $eventCode => $event)
            {
        ?>
            <tr>
                <td><span class="tool_tips" title="<?php echo $event['course_name'];?>"><?php echo $event['course_name']; ?></span></td>
                <?php for($mnth=$mstart; $mnth<=$mend; $mnth++): ?><td style="text-align:right !important;"><?php echo (isset($event[$mnth])?$event[$mnth]['course_man_days']:0); ?></td><?php endfor; ?>
                <td style="text-align:right !important;"><b><?php echo (isset($event['annual_course_man_days'])?$event['annual_course_man_days']:0); ?></b></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
        <tfoot>
						<tr style="background-color:#F4FAFF;">
                <td><b>TOTAL:</b></td>
              <?php $overallTotall = 0; for($ftmnt=$mstart; $ftmnt<=$mend; $ftmnt++): ?>
								<td style="text-align:right !important;font-weight:bold;">
										<?php
											if(isset($events['monthly'][$ftmnt]['all_course_monthly_man_days'])):
													echo $events['monthly'][$ftmnt]['all_course_monthly_man_days'];
													$overallTotall += intval($events['monthly'][$ftmnt]['all_course_monthly_man_days']);
											else:
													echo '0';
											endif;
										?>
								</td>
							<?php endfor; ?>
                <td style="text-align:right !important;font-weight:bold;"><?php echo $overallTotall; ?></td>
            </tr>
        </tfoot>
    </table>
    <?php
		                $smry_counter++;
		                if($smry_counter<count($course_summary)) echo "<hr style=\"border-color:#b4d4e7;border-style:dotted;margin:30px 0 30px 0;\"/>";
		            }
		        }
		        else
		        {
		            echo "<div class=\"clearfix\" style=\"text-align:center;\">No records found!</div>";
		        }
				}
				else
				{
						echo "<div class=\"clearfix\" style=\"text-align:center;\">Summary of course man days will be displayed here.</div>";
				}
    ?>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("reports/course.man.days"));
		echo $this->fetch("script");
?>
