<?php
	App::uses('AppHelper', 'View/Helper');
	class CategoryHelper extends AppHelper
	{
		public function __construct(View $view, $settings=array())
		{
			parent::__construct($view, $settings);
		}
		
		public function GenerateULTreeStructure($array, $addFirstULtag=true) 
		{
			if(count($array)) 
			{
				echo ($addFirstULtag?"\n<ul>\n":"");
				foreach($array as $vals):
					echo "<li rel=\"".$vals['CourseCategory']['id']."\">".$vals['CourseCategory']['name'];
					if(count($vals['children'])) 
					{
						echo $this->GenerateULTreeStructure($vals['children']);
					}
					echo "</li>\n";
				endforeach;
				echo ($addFirstULtag?"</ul>\n":"");
			}
		}
	}