<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GigaMare Inc. - Training Administration System</title>
<style type="text/css">
	body{margin:0px;padding:0px;font-size:0.9em;font-family:Tahoma;letter-spacing:1px;}
	table{border-collapse: collapse;line-height:18px;}
	thead {display: table-header-group;}
	h3 {margin:0px;padding:0px 0px 4px 0px;}
	h1 {margin:0px 0px 3px 0px;padding:0px;}
	p {line-height:18px;}
</style>
</head>

<body>
	<div style="width: 800px; margin: auto;">
    	<?php
			$arr_stats = array('Failed', 'Passed', 'Cancelled', 'Attended');
			$trainingRecord = array();
			foreach($courses_taken as $course) $trainingRecord[$course['Person']['id']][] = $course;
			foreach($trainingRecord as $records):
		?>
    	<div style="width:100%;height:150px;padding:0px;margin:0px;background:transparent url(<?php echo $this->Html->url('/img/gmi/gigamare_mid_sm.jpg', true); ?>) top left no-repeat;">
        	<div style="width:100%;float:left;">
	        	<div style="float:left;padding-left:175px;width:620px;">
                	<div style="float:left;width:100%;"><h1>TRAINING REPORT</h1></div>
                    <div style="float:left;width:100%;margin-top:2px;margin-bottom:2px;">
		            	<div style="float:left;width:80px;"><b>Name</b></div><div style="float:left;width:10px;text-align:center !important;"><b>:&nbsp;</b></div><div style="float:left;width:510px;"><?php echo $records[0]['Person']['last_name'].", ".$records[0]['Person']['first_name']; ?></div>
                    </div>
                    <div style="float:left;width:100%;margin-bottom:2px;">
		            	<div style="float:left;width:80px;"><b>Date</b></div><div style="float:left;width:10px;text-align:center !important;"><b>:&nbsp;</b></div><div style="float:left;width:510px;"><?php echo date('F d, Y'); ?></div>
                    </div>
                    <div style="float:left;width:100%;margin-bottom:2px;">
		            	<div style="float:left;width:80px;"><b>Company</b></div><div style="float:left;width:10px;text-align:center !important;"><b>:&nbsp;</b></div><div style="float:left;width:510px;"><?php echo $records[0]['Person']['company_name']; ?></div>
                    </div>
                    <div style="float:left;width:100%;">
		            	<div style="float:left;width:80px;"><b>Course</b></div><div style="float:left;width:10px;text-align:center !important;"><b>:&nbsp;</b></div><div style="float:left;width:510px;">Structured Enhancement Training Program for <?php echo (trim($records[0]['Person']['cadet_type'])=='ETO'?'Electro Technical Officer':$records[0]['Person']['cadet_type'].' Cadet'); ?></div>
                    </div>
	            </div>
	            <div style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <h3>PERSONALITY ENHANCEMENT TRAINING</h3>
        <table width="100%" border="1" bordercolor="#999" cellspacing="0" cellpadding="4">
        	<thead>
						<tr>
							<th width="538" style="text-align: left !important;">TOPIC</th>
							<th width="125">FINAL GRADE</th>
							<th width="105">REMARKS</th>
						</tr>
					</thead>
					<tbody>
						<tr>
					    <td>Self Awareness and Stress Management Seminar</td>
					    <td align="center">Attended</td>
					    <td align="center">Passed</td>
	          </tr>
	          <tr>
					    <td>Team Building Seminar</td>
					    <td align="center">Attended</td>
					    <td align="center">Passed</td>
	          </tr>
	          <tr>
	            <td>Physical Fitness Training (See Attached File)</td>
					    <td align="center">Attended</td>
					    <td align="center">Passed</td>
		        </tr>
					</tbody>
        </table>
        <br/><br/>
        <h3>TECHNICAL SKILLS</h3>
				<table width="100%" border="1" bordercolor="#999" cellspacing="0" cellpadding="4" style="page-break-inside:avoid;">
        	<thead>
						<tr>
							<th width="538" style="text-align: left !important;">TOPIC</th>
							<th width="125">FINAL GRADE</th>
							<th width="105">REMARKS</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$noOfCourses = 0;
							$summationOfGrades = 0;
							foreach($records as $record):
								if(trim($record['OfferingParticipant']['status'])!=''&&strtolower($arr_stats[$record['OfferingParticipant']['status']])!='attended'):
									$noOfCourses++;
									$summationOfGrades += $record['OfferingParticipant']['grade'];
								endif;
						?>
						<tr>
					    <td><?php echo $record['Course']['title']; ?></td>
					    <td align="center"><?php echo (trim($record['OfferingParticipant']['status'])!=''&&$arr_stats[$record['OfferingParticipant']['status']]=='Attended'?'Attended':(str_replace(",","",trim($record['OfferingParticipant']['grade']))!=''&&is_numeric(str_replace(",","",trim($record['OfferingParticipant']['grade'])))?number_format(str_replace(",","",trim($record['OfferingParticipant']['grade'])), 2):$record['OfferingParticipant']['grade']));?></td>
	            <td align="center"><?php echo (trim($record['OfferingParticipant']['status'])!=''?($arr_stats[$record['OfferingParticipant']['status']]=='Attended'?'Passed':$arr_stats[$record['OfferingParticipant']['status']]):''); ?></td>
		        </tr>
						<?php
							endforeach;
							$average = ($summationOfGrades>0?($summationOfGrades/$noOfCourses):0);
						?>
            <tr>
            	<td align="right"><b>AVERAGE</b></td>
              <td align="center"><?php echo number_format($average, 2);?></td>
              <td align="center"><?php echo (intval($average)>=70?'Passed':'Failed'); ?></td>
          	</tr>
					</tbody>
        </table>
        <p style="width:100%;margin:0px;padding:15px 0px 0px 0px;text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that the above stated information are true and correct based on the records on file with this center. Signed this <b><?php echo date('jS \o\f F Y'); ?></b> at <b>GigaMare Inc.</b>, Bldg. 2082 Corregidor Highway, Naval Magazine Area, Subic Bay Freeport Zone, Philippines.</p>
        <div style="clear:both;"></div>
        <div style="width:100%;float:left;padding:0px;margin:0px;">
        	<div style="width:230px;float:left;border-top:1px solid #333;text-align:center;margin:70px 0px 0px 0px;padding:5px 0px 0px 0px;"><b>ERIC M. SAMUELSON</b><br/>Structured Training Program Manager</div>
        	<div style="width:230px;float:right;border-top:1px solid #333;text-align:center;margin:70px 0px 0px 0px;padding:5px 0px 0px 0px;"><b>CAPT. PETER SARS</b><br/>Head of Training Operations</div>
        </div>
        <br/><br/>
        <div style="clear:both;page-break-after:always;"></div>
        <?php endforeach; ?>
	</div>
</body>
</html>
