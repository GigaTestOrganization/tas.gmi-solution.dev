<?php
	switch($for)
	{
		case "all":
			switch($what)
			{
				case "footer":
					include('hf/general_footer.php');
				break;
			}
		break;

		case "attendancesheet":
			switch($what)
			{
				case "header":
					include('hf/as_header.php');
				break;

				case "footer":
					include('hf/as_footer.php');
				break;
			}
		break;

		default:
		break;
	}
?>
