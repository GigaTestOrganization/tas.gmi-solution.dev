<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GigaMare Inc. - Learning Management System</title>
<style type="text/css">
	body{margin:0px;padding:0px;font-family:Arial;}
	table{border-collapse: collapse;}
	thead {display:table-header-group;}
</style>
</head>
<body>
	<div style="width:2238px;margin:auto;">
		<table width="2230" border="1" bordercolor="#999" cellspacing="0" cellpadding="6">
        	<thead>
						<tr>
							<th width="50" rowspan="2" style="vertical-align: middle !important;">No.</th>
							<th width="300" rowspan="2" style="vertical-align: middle !important;" align="left">Name of Enrollee</th>
							<th width="238" rowspan="2" style="vertical-align: middle !important;">Rank / Rating</th>
							<th colspan="2" style="text-align: center !important;">Monday</th>
							<th colspan="2" style="text-align: center !important;">Tuesday</th>
							<th colspan="2" style="text-align: center !important;">Wednesday</th>
							<th colspan="2" style="text-align: center !important;">Thursday</th>
							<th colspan="2" style="text-align: center !important;">Friday</th>
							<th colspan="2" style="text-align: center !important;">Saturday</th>
						</tr>
						<tr>
							<th width="130" style="text-align: center !important;">AM</th>
							<th width="130" style="text-align: center !important;">PM</th>
							<th width="130" style="text-align: center !important;">AM</th>
							<th width="130" style="text-align: center !important;">PM</th>
							<th width="130" style="text-align: center !important;">AM</th>
							<th width="130" style="text-align: center !important;">PM</th>
							<th width="130" style="text-align: center !important;">AM</th>
							<th width="130" style="text-align: center !important;">PM</th>
							<th width="130" style="text-align: center !important;">AM</th>
							<th width="130" style="text-align: center !important;">PM</th>
							<th width="130" style="text-align: center !important;">AM</th>
							<th width="130" style="text-align: center !important;">PM</th>
						</tr>
          </thead>
          <tbody>
					<?php foreach($offerParticipants as $key => $participant) {?>
						<tr>
							<td><?php echo ($key+1); ?></td>
							<td><?php echo $participant['OfferingParticipant']['fullname']; ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
			            </tr>
					<?php } ?>
        	</tbody>
		</table>
	</div>
</body>
</html>
