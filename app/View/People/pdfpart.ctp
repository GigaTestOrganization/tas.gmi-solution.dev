<?php
	switch($for)
	{
		case "training-report":
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
