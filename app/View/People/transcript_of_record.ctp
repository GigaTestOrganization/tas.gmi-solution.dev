<?php
	echo $this->Html->css(array('themes/default/easyui', 'themes/icon'), 'stylesheet', array('media'=>'all'));
	echo $this->Html->script(array('jquery.easyui.min'));
?>
<div class="page-header">
    <h3 class="text-default">Download Training Records</h3>
</div>
<div class="row">
		<div class="col-sm-12" style="margin-bottom:5px;">
				<small class="text-default form-control-static">Records of the trainees added in this list will be generated.</small>
				<span class="pull-right">
						<a href="#" class="easyui-menubutton" data-options="menu:'#mm1',iconCls:'icon-action'">Actions</a>
		        <div id="mm1">
		          <div class="tool_tips" title="Download Training Report" data-options="iconCls:'icon-save'" id="download_transcript">Download</div>
		          <div class="menu-sep"></div>
		          <div class="js-clicks tool_tips" data-options="iconCls:'icon-back'" data-url="<?php echo $this->Html->url("/people"); ?>">List of People</div>
		        </div>
						<small>&nbsp;&nbsp; | &nbsp;&nbsp;</small>
						<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-plus"></i> Choose'), array('/'), array('id'=>'addparticipant', 'class'=>'btn btn-sm btn-success', "title"=>"Find Trainees", 'escape' => false)); ?>
						<?php echo $this->Html->link(__('<i class="glyphicon glyphicon-minus"></i> Remove'), array('/'), array("id"=>"remove_button", 'class'=>'btn btn-sm btn-default disabled', "title"=>"Remove Trainee(s)", 'escape'=>false)); ?>
				</span>
				<div class="clearfix"></div>
		</div>
		<div class="col-sm-12">
	    	<form action="<?php echo $this->Html->url("download/".md5(time())."/training-report", true); ?>.pdf" id="list_of_people" name="list_of_people" method="post">
		        <table class="table table-bordered table-striped table-hover">
		        		<thead class="thead-default">
		                <tr>
												<th style="width:30px;"><input type="checkbox" value="" id="select_all_participants"/></th>
												<th style="width:300px;">Name</th>
												<th>Company</th>
		                </tr>
		            </thead>
		            <tbody id="participantsList">
		            </tbody>
		        </table>
	      </form>
		</div>
</div>
<br/><br/>
<?php
		echo $this->Html->script(array("people/training.report"));
		echo $this->fetch("script");
?>
