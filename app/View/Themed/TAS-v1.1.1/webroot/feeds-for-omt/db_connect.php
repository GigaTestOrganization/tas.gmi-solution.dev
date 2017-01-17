<?php
	require("dbconf.php");
	mysql_connect(DB_HOST, DB_UNAME, DB_PWORD) or die(mysql_error());
	mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
	mysql_select_db(DB_NAME) or die(mysql_error());
?>