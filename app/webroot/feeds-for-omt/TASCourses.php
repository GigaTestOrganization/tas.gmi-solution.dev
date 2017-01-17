<?php
	class TASCourses
	{
		public function __construct()
		{
		}
		
		public function get_categories($parent=NULL)
		{
			$rs->isError = false;
			$rs->categories = "";
			$getAll = "SELECT id, name, parent_id FROM list_of_course_categories_for_omt WHERE parent_id ".($parent==NULL?"IS NULL":"= ".intval($parent))." ORDER BY lft ASC;";		
			if($result = mysql_query($getAll))
			{
				while($row = mysql_fetch_array($result))
				{
					$getCat = $this->get_categories($row['id']);
					if(!$getCat->isError && trim($getCat->categories)!="")
					{
						$rs->categories .= "<category id=\"".$row['id']."\" name=\"".htmlentities($row['name'])."\">";
						$rs->categories .= $getCat->categories;
						$rs->categories .= "</category>";
					} 
					else 
					{										
						$rs->categories .= "<category id=\"".$row['id']."\" name=\"".htmlentities($row['name'])."\"/>";
					}
				}
			} else $rs->isError = true;
			return $rs;
		}
		
		public function categories()
		{
			$rs = $this->get_categories(NULL);
			if(!$rs->isError)
				return "<list>".$rs->categories."</list>";
			else return "<list/>";
		}
		
		public function find_course($cat=NULL, $name=NULL)
		{
			$rs->isError = false;
			$rs->courses = "<list/>";
			if($cat!=NULL || $name!=NULL)
			{
				$getAllCors = "SELECT course_id, course_title, category_id, category_name FROM list_of_courses_for_omt WHERE ".($cat!=NULL?"category_id = ".$cat:"").($cat!=NULL&&$name!=NULL?" AND ":" ").($name!=NULL?"course_title LIKE \"%".$name."%\"":"")." ORDER BY category_name ASC, course_title ASC;";
				if($result = mysql_query($getAllCors))
				{
					$rs->courses = "<list>";
					while($row = mysql_fetch_array($result))
					{
						$rs->courses .= "<course id=\"".$row['course_id']."\" name=\"".htmlentities($row['course_title'])."\" category=\"".htmlentities($row['category_name'])."\" category_id=\"".$row['category_id']."\"/>";
					}
					$rs->courses .= "</list>";
				} else $rs->isError = true;
			}
			return $rs;
		}
	}
?>