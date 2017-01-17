<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GigaMare Inc. - Learning Management System</title>
<style type="text/css">
	body{margin:0px;padding:0px;font-family:Arial;font-size:13px;}
	table{border-collapse: collapse;}
	thead {display: table-header-group;}
</style>
</head>

<body>
	<div style="width: 1024px; margin: auto;">
    	<div style="width:100%;height:160px;margin: 0px 0px 15px 0px;background: transparent url(<?php echo $this->Html->url('/img/gmi/gigamare_medium.jpg', true); ?>) top left no-repeat;">
        	<div style="width:100%;float:left;">
	        	<div style="float:left;padding-left:225px;width:800px;">
                	<div style="float: left;width:100%;">
                        <h1 style="margin:5px 0px 15px 0px;">GIGAMARE, INC.</h1>
                        <b>Student Personal Accident Insurance</b>
                    </div>
                    <div style="float:left;width:100%;margin-top:10px;margin-bottom:3px;">
		            	<div style="float:left;width:120px;"><b>Course Name</b></div><div style="float:left;width:10px;text-align:center !important;">:</div><div style="float:left;width:600px;"><?php echo $offerParticipants[0]['Course']['title']; ?></div>
                    </div>
                    <div style="float:left;width:100%;margin-bottom:3px;">
		            	<div style="float:left;width:120px;"><b>Week No.</b></div><div style="float:left;width:10px;text-align:center !important;">:</div><div style="float:left;width:600px;"><?php $d = new DateTime($offerParticipants[0]['Offering']['date_start']); echo $d->format("W"); ?></div>
                    </div>
                    <div style="float:left;width:100%;">
		            	<div style="float:left;width:120px;"><b>Policy Period</b></div><div style="float:left;width:10px;text-align:center !important;">:</div><div style="float:left;width:600px;"><?php echo $this->DateRangeFormat->FormatDateRange(strtotime($offerParticipants[0]['Offering']['date_start']), strtotime($offerParticipants[0]['Offering']['date_end'])); ?></div>
                    </div>
	            </div>
	            <div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
		<table width="100%" border="1" bordercolor="#999" cellspacing="0" cellpadding="6">
        	<thead>
				<tr>
					<th style="width:40px;text-align:left !important;">No.</th>
					<th style="text-align:left !important;">Name of Enrollee</th>
					<th style="width:140px;">AD &amp; D / UM &amp; A</th>
					<th style="width:140px;">AMR</th>
					<th style="width:140px;">ABE</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($offerParticipants as $key => $participant) {?>
				<tr>
				    <td><?php echo ($key+1); ?></td>
				    <td><?php echo $participant['OfferingParticipant']['fullname']; ?></td>
            <td style="text-align: center !important;">Php 100,000</td>
            <td style="text-align: center !important;">Php 10,000</td>
            <td style="text-align: center !important;">Php 10,000</td>
				</tr>
				<?php } ?>
			</tbody>
        </table>
	</div>
</body>
</html>
