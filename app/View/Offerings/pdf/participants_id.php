<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GigaMare Inc. - Learning Management System</title>
<style type="text/css">
	body{font-family:Arial;}
</style>
</head>
<body>
	<div>
		<?php $cntr = 0; foreach($offerParticipants as $participant) { $cntr++; ?>
		<div style="float:left;border:2px #999999 solid;width:410px;height:245px;padding:2px 0px 0px 2px;margin:0px 0px 10px 10px;">
			<div style="border:4px #333333 solid;width:398px;height:233px;padding:2px 0px 0px 2px;">
				<div style="border:2px #999999 solid;width:392px;height:227px;background:transparent url(<?php echo $this->Html->url('/img/gmi/gigamare_small.jpg', true); ?>) right 10px no-repeat;">
					<div style="width:376px;height:137px;padding:30px 5px 5px 10px;">
						<p style="font-size: 0.8em;"><b>GigaMare Inc.</b><br/><?php echo $participant['Course']['title']; ?><br/><i><?php echo $this->DateRangeFormat->FormatDateRange(strtotime($participant['Offering']['date_start']), strtotime($participant['Offering']['date_end'])); ?></i><br/>Subic Bay, Philippines</p>
					</div>
					<div style="border:1px #000000 solid;width:387px;height:42px;background-color:#0CF;padding-top:10px;margin-left:1px;overflow:hidden;">
						<center><b style="font-size: 1.3em;"><?php echo $participant['OfferingParticipant']['fullname']; ?></b></center>
					</div>
				</div>
			</div>
		</div>
		<?php if($cntr==9): ?>
		<div style="float:left;width:100%;page-break-after:always;">&nbsp;</div>
		<?php $cntr = 0; endif; } ?>
	</div>
</body>
</html>
