<?php
	include_once("../db_connect.php");
	include("../TASCourses.php");
	$tas = new TASCourses();
	echo $tas->categories();
?>