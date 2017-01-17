<?php
	class CourseLessonsController extends AppController
	{
		public function isAuthorized($user) 
		{
		    if(strtolower($this->action) === 'get_default_instructors') { return true;  }			
		    return parent::isAuthorized($user);
		}
		
		public function add()
		{
			$data->isError = false;
			$this->layout = false;
			if($this->request->is('post') || $this->request->is('put')) 
			{
				$user_id = $this->Auth->user('id');	
				$this->request->data['CourseLesson']['user_id'] = $user_id;
				if($this->CourseLesson->save($this->request->data)) 
				{
					$data->courseLessonID = $this->CourseLesson->id;
					$data->message = "Lesson successfully included to the course.";
				}
				else 
				{ 
					$data->message = "Failed to include lesson to the course.";
					$data->isError = true; 
				}
			}
			$this->set(compact('data'));
			$this->render('/Elements/json');
		}
		
		public function update_info()
		{
			$data->isError = false;
			$this->layout = false;
			if($this->request->is('post') || $this->request->is('put')) 
			{
				$user_id = $this->Auth->user('id');	
				$this->request->data['CourseLesson']['last_modifier_id'] = $user_id;
				if($this->CourseLesson->save($this->request->data)) 
				{					
					$data->message = "Lesson info successfully updated.";
				}
				else 
				{ 
					$data->message = "Failed to update lesson info.";
					$data->isError = true; 
				}
			}
			$this->set(compact('data'));
			$this->render('/Elements/json');
		}
		
		public function delete()
		{
			if($this->request->is('post') || $this->request->is('put')) 
			{
				$data->isError = false;
				$this->layout = false;
				if($this->CourseLesson->delete($this->request->data['CourseLesson']['id'])) 
				{					
					$data->message = "Lesson successfully removed from schudule.";
				}
				else 
				{ 
					$data->message = "Failed to remove lesson from schedules.";
					$data->isError = true; 
				}
				$this->set(compact('data'));
				$this->render('/Elements/json');
			} else throw new BadRequestException(__('Invalid Request.'));
			
		}
		
		public function get_default_instructors()
		{
			$data->isError = true;
			$this->layout = false;
			if(($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['course_id'])) 
			{
				list($course_id, $salt) = split('-', $this->request->data['course_id']);
				$this->CourseLesson->recursive = -1;
				$data->default_instrutors = $this->CourseLesson->find('all', array('joins'=>array(array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = CourseLesson.instructor_id'))),									
																			  'fields'=>array('Instructor.id', 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'), 
														 					  'conditions'=>array('CourseLesson.course_id'=>$course_id, 'CourseLesson.instructor_id IS NOT NULL'),
																			  'group'=>array('Instructor.id')));
				$data->isError = false;
			}
			$this->set(compact('data'));
			$this->render('/Elements/json');
		}
	}
?>