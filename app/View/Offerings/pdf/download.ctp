<?php
	switch($what)
	{
		case "participantsid":
			include("participants_id.php");
		break;

		case "tablenametags":
			include("table_name_tags.php");
		break;

		case "registrationform":
			$standard = "ISO-8601";
			$week = "1 / ".date("Y");
			switch($standard)
			{
					case "ISO-8601":
						$timestamp = $offering[0]['Offering']['date_start'];
						$date = new DateTime($timestamp);
						$week = $date->format("W / Y");
					break;

					default:
						$timestamp = strtotime($offering[0]['Offering']['date_start']);
						$sYear = date("Y", $timestamp);
						$add = date('N', strtotime($sYear."-01-01 00:00:00"));
						$week = ceil(((date('z', $timestamp)+$add)/7));
						$week = ($week>9?"":"0").$week." / ".$sYear;
					break;
			}
			include("registration_form.php");
		break;

		case "attendancesheet":
			include("attendance_sheet.php");
		break;

		case "insurance":
			include("insurance.php");
		break;

		default:
		break;
	}
?>
