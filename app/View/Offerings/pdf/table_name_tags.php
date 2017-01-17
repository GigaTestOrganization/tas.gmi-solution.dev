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
		<div style="width:1554px;margin:auto;">
		<?php
				$n = 0;
				$cntr = count($offerParticipants);
				foreach($offerParticipants as $key => $participant):
					$n++;
		?>
				<div style="border:4px #333333 solid;width:1548px;height:297px;text-align:center;padding-top:190px;background-image:url(<?php echo $this->Html->url('/img/gmi/gigamare_medium.jpg', true); ?>);background-position:center 15px;background-repeat:no-repeat;margin-bottom:50px;-webkit-transform:rotate(180deg);">
			    	<div style="color:#000000;font-size:6.3em;font-weight:bold;"><?php echo $participant['OfferingParticipant']['fullname']; ?></div>
			  </div>
		  	<div style="border:4px #333333 solid;width:1548px;height:297px;text-align:center;padding-top:190px;background-image:url(<?php echo $this->Html->url('/img/gmi/gigamare_medium.jpg', true); ?>);background-position:center 15px;background-repeat:no-repeat;">
		    		<div style="color:#000000;font-size:6.3em;font-weight:bold;"><?php echo $participant['OfferingParticipant']['fullname']; ?></div>
		    </div>
		<?php
				if(($n%2)!=0)
				{
		?>
				<div style="width:100%;height:2px;margin:34px 0px 34px 0px;padding:0px;border-top:2px #CCCCCC dashed;">&nbsp;</div>
		<?php
				}
				else
				{
		?>
				<div style="width:100%;page-break-after:always;">&nbsp;</div>
		<?php
				}
			endforeach;
		?>
		</div>
</body>
</html>
