<?php
	class CourseCategoriesController extends AppController
	{
		public $scaffold;

		public function isAuthorized($user)
		{
		    if(strtolower($this->action) === 'generatejsontreestructure') { return true;  }
		    return parent::isAuthorized($user);
		}

		/*public function index()
		{
			$data = $this->CourseCategory->generateTreeList(null, null, null, '_');
			debug($data); die;
		}*/

		public function generateJSONTreeStructure($show_courses=0)
		{
			$this->layout = NULL;
			$data = "";
			if(($this->request->is('post') || $this->request->is('put'))) 
			{
				$this->CourseCategory->recursive = ($show_courses?1:-1);
				$data = $this->_restructureHeirarchy($this->CourseCategory->find('threaded', array('fields'=>array('id', 'name', 'parent_id'), 'order'=>array('CourseCategory.lft'))));
			}
			$this->set(compact('data'));
			$this->render('/Elements/json');
		}

		public function _restructureHeirarchy($array)
		{
			$result = "";
			if(count($array))
			{
				foreach($array as $vals):
					$arr = array('id'=>$vals['CourseCategory']['id'], 'text'=>$vals['CourseCategory']['name'], 'attributes'=>array('parent_id'=>$vals['CourseCategory']['parent_id']));
					$childrenArr = NULL;
					if(isset($vals['children'])&&count($vals['children'])) $childrenArr = $this->_restructureHeirarchy($vals['children']);
					if(isset($vals['Course'])&&count($vals['Course']))
					{
						foreach($vals['Course'] as $course):
							$childrenArr[] = array('id'=>$course['id']."-CORS", 'text'=>$course['title'], 'attributes'=>array('course_category_id'=>$course['course_category_id']));
						endforeach;
					}
					if($childrenArr!=NULL)
					{
						$arr['state'] = 'closed';
						$arr['children'] = $childrenArr;
					}
					$arr['selected'] = 0;
					$result[] = $arr;
				endforeach;
			}

			return $result;
		}
	}
?>
