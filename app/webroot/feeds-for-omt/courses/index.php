<?php
	include_once("../db_connect.php");
	include("../TASCourses.php");	
	if(isset($_GET))
	{
		$param = array_keys($_GET);		
		$cat = (isset($param[0])?$param[0]:NULL);
		if($cat!=NULL && strpos($cat, 'corscat-')!==false)
			$cat = str_replace("corscat-", "", $cat);
		else $cat = NULL;
		$name = ($cat!=NULL? (isset($param[1])?$param[1]:NULL) : (isset($param[0])?$param[0]:NULL) );
		
		$tas = new TASCourses();
		$resultSet = $tas->find_course($cat, $name);
		if(!$resultSet->isError) echo $resultSet->courses;
		else echo "<list/>";		
	}
?>