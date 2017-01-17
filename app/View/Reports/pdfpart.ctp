<?php
	switch($for)
	{
		case "training_report":
			switch($what)
			{
				case "header":
					include('hf/header.php');
				break;

				case "footer":
					include('hf/footer.php');
				break;
			}
		break;

		default:
		break;
	}
?>
