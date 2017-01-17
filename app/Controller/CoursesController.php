<?php
	class CoursesController extends AppController
	{
		public $scaffold;
		public $paginate;
		public $components = array('RequestHandler');
		//public $day = array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

		public function beforeFilter()
		{
			$this->Auth->allow('download');
		}

		public function isAuthorized($user)
		{
		    if(in_array(trim($user['role']), array('sales', 'registrar', 'instructor')))
			{
				return true;
			}

		    return parent::isAuthorized($user);
		}

		public function index()
		{
			$this->Course->recursive = -1;
			$this->paginate = array('joins'=>array(array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'LEFT', 'conditions'=>array('CourseCategory.id = Course.course_category_id'))),
									'limit'=>15,
									'fields'=>array('Course.*', 'CourseCategory.name', 'CourseCategory.id'),
									'order'=>array('Course.created'=>'DESC'));
   			$this->set('courses', $this->paginate());
		}

		public function add()
		{
				if($this->request->is('post') || $this->request->is('put'))
				{
						$user_id = $this->Auth->user('id');
						$this->request->data['Course']['user_id'] = $user_id;
						$this->Course->recursive = -1;
						if($this->Course->save($this->request->data['Course']))
						{
								$unique_id = $this->Course->id;

								$category = $this->Course->CourseCategory->find('first', array('fields'=>array('CourseCategory.code','CourseCategory.name'),
																																							 'conditions'=>array('CourseCategory.id'=>$this->request->data['Course']['course_category_id'])));
								$course_data['Course']['code'] = 'C'.$category['CourseCategory']['code'].(strlen($unique_id)<5?sprintf('%05d',$unique_id):$unique_id);
								if($this->Course->save($course_data)):
										$this->Session->setFlash(__('New course has been created successfully.'), 'flash/success');
								else:
									 	$this->Session->setFlash(__('New course has been successfully created, though a unique code for the course failed to be generated. Please contact the administrator.'), 'flash/warning');
								endif;

								$this->request->data['CourseSpecification']['course_id'] = $unique_id;
								$this->request->data['CourseSpecification']['user_id'] = $user_id;
								$this->Course->CourseSpecification->save($this->request->data['CourseSpecification']);

								$this->redirect(array('action'=>'edit', $unique_id));
						}
						else
						{
							$this->Session->setFlash(__('Unable to update your course.'));
						}
				}
				$this->set('data', $this->request->data);
		}

		public function edit($id)
		{
				if(!$this->Course->exists($id)) throw new NotFoundException(__('Course could not be found!'));

				if($this->request->is('post') || $this->request->is('put')):
						$user_id = $this->Auth->user('id');
						$this->request->data['Course']['last_modifier_id'] = $user_id;
						$this->request->data['Course']['published'] = (isset($this->request->data['Course']['published'])?1:0);
						if($this->Course->save($this->request->data['Course']))
						{
								$category = $this->Course->CourseCategory->find('first', array('fields'=>array('CourseCategory.code','CourseCategory.name'),
																																							 'conditions'=>array('CourseCategory.id'=>$this->request->data['Course']['course_category_id'])));
								$course_data['Course']['code'] = 'C'.$category['CourseCategory']['code'].(strlen($id)<5?sprintf('%05d',$id):$id);
								if($this->Course->save($course_data)):
										$this->Session->setFlash(__('Course has been successfully updated.'), 'flash/success');
								else:
										$this->Session->setFlash(__('Course has been successfully updated, though a unique code for the course failed to be generated. Please contact the administrator.'), 'flash/warning');
								endif;

								$this->request->data['CourseSpecification']['last_modifier_id'] = $user_id;
								$this->Course->CourseSpecification->save($this->request->data['CourseSpecification']);
						}
						else
						{
								$this->Session->setFlash(__('Failed to update course.'), 'flash/error');
						}
				endif;

				$this->Course->recursive = -1;
				$course = $this->Course->find('first', array('joins'=>array(array('table'=>'course_specifications', 'alias'=>'CourseSpecification', 'type'=>'LEFT', 'conditions'=>array('CourseSpecification.course_id = Course.id'))),
																										 'fields'=>array('Course.*', 'CourseSpecification.*'),
																										 'conditions'=>array('CourseSpecification.published'=>1, 'Course.id'=>$id)));
				$this->request->data = $course;
				$this->set(compact('course'));

				$this->Course->CourseLesson->Lesson->recursive = -1;
				$lessons = $this->Course->CourseLesson->Lesson->find('all', array('fields'=>array('Lesson.*'), 'conditions'=>array('Lesson.published'=>1)));
				$this->set(compact('lessons'));

				$this->Course->CourseLesson->recursive = -1;
				$course_lessons = $this->_restructure($this->Course->CourseLesson->find('all', array('joins'=>array(array('table'=>'lessons', 'alias'=>'Lesson', 'type'=>'LEFT', 'conditions'=>array('Lesson.id = CourseLesson.lesson_id')),
																																																				 	 array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id=CourseLesson.instructor_id'))),
																		 					   					 																	 'fields'=>array('Lesson.id', 'Lesson.title', 'Lesson.duration', 'CourseLesson.id', 'CourseLesson.lesson_id', 'CourseLesson.week',
																																														 								 'CourseLesson.day', 'CourseLesson.order', 'CourseLesson.time_start', 'CourseLesson.time_end', 'Instructor.id',
																																																						 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'),
																																													 	 'conditions'=>array('CourseLesson.course_id'=>$id),
																																													   'order'=>array('CourseLesson.week'=>'ASC', 'CourseLesson.day'=>'ASC', 'CourseLesson.order'=>'ASC', 'CourseLesson.created'=>'ASC'))));
				$this->set(compact('course_lessons'));

				$week_days_name = $this->day;
				$this->set(compact('week_days_name'));

				$this->Course->CourseCategory->recursive = -1;
				$categories = $this->Course->CourseCategory->find('threaded', array('fields'=>array('id', 'name', 'parent_id'), 'order'=>array('CourseCategory.lft')));
				$this->set(compact('categories'));
		}



		public function view($id)
		{
			if(!$id) throw new NotFoundException(__('Course not found.'));

			$this->Course->recursive = -1;
			$course = $this->Course->find('first', array('joins'=>array(array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'LEFT', 'conditions'=>array('CourseCategory.id = Course.course_category_id')),
																	    array('table'=>'course_specifications', 'alias'=>'CourseSpecification', 'type'=>'LEFT', 'conditions'=>array('CourseSpecification.course_id = Course.id'))),
														 'fields'=>array('Course.*', 'CourseCategory.name', 'CourseSpecification.*'),
														 'conditions'=>array('CourseSpecification.published'=>1, 'Course.id'=>$id)));
			$this->set(compact('course'));
			if(!$course) throw new NotFoundException(__('Course not found.'));

			$this->Course->CourseLesson->recursive = -1;
			$course_lessons = $this->_restructure($this->Course->CourseLesson->find('all', array('joins'=>array(array('table'=>'lessons', 'alias'=>'Lesson', 'type'=>'LEFT', 'conditions'=>array('Lesson.id = CourseLesson.lesson_id')),
																												array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = CourseLesson.instructor_id'))),
														 					 'fields'=>array('Lesson.id', 'Lesson.title', 'Lesson.duration', 'CourseLesson.id', 'CourseLesson.lesson_id', 'CourseLesson.week', 'CourseLesson.day', 'CourseLesson.order',
																							 'CourseLesson.time_start', 'CourseLesson.time_end', 'Instructor.id', 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'),
														 					 'conditions'=>array('CourseLesson.course_id'=>$id),
																			 'order'=>array('CourseLesson.week'=>'ASC', 'CourseLesson.day'=>'ASC', 'CourseLesson.order'=>'ASC', 'CourseLesson.created'=>'ASC'))));
			$this->set(compact('course_lessons'));

			$week_days_name = $this->day;
			$this->set(compact('week_days_name'));
		}

		public function download($what, $id, $coursename)
		{
			switch($what)
			{
				case "specification":

					if(!$this->Course->exists($id)) throw new NotFoundException(__('Course not found.'));

					$this->Course->recursive = -1;
					$course = $this->Course->find('first', array('joins'=>array(array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'LEFT', 'conditions'=>array('CourseCategory.id = Course.course_category_id')),
																			    array('table'=>'course_specifications', 'alias'=>'CourseSpecification', 'type'=>'LEFT', 'conditions'=>array('CourseSpecification.course_id = Course.id'))),
																 'fields'=>array('Course.*', 'CourseCategory.name', 'CourseSpecification.*'),
																 'conditions'=>array('CourseSpecification.published'=>1, 'Course.id'=>$id)));
					$this->set(compact('course'));

					$this->Course->CourseLesson->recursive = -1;
					$course_lessons = $this->_restructure($this->Course->CourseLesson->find('all', array('joins'=>array(array('table'=>'lessons', 'alias'=>'Lesson', 'type'=>'LEFT', 'conditions'=>array('Lesson.id = CourseLesson.lesson_id')),
																													array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = CourseLesson.instructor_id'))),
																 					 'fields'=>array('Lesson.id', 'Lesson.title', 'Lesson.duration', 'CourseLesson.id', 'CourseLesson.lesson_id', 'CourseLesson.week', 'CourseLesson.day',
																			'CourseLesson.order', 'CourseLesson.time_start', 'CourseLesson.time_end', 'Instructor.id', 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'),
																 					 'conditions'=>array('CourseLesson.course_id'=>$id),
																					 'order'=>array('CourseLesson.week'=>'ASC', 'CourseLesson.day'=>'ASC', 'CourseLesson.order'=>'ASC', 'CourseLesson.created'=>'ASC'))));
					$this->set(compact('course_lessons'));

					$week_days_name = $this->day;
					$this->set(compact('week_days_name'));

					$coursename .= '.pdf';
					$this->pdfConfig = array('options'=>array('dpi'=>96), 'orientation' => 'portrait', 'filename' => $coursename);
				break;

				default:
					throw new NotFoundException(__('Invalid URL'));
				break;
			}
		}

		public function delete($id)
		{
				$this->Course->id = $id;

				if(!$this->Course->exists($id)) throw new NotFoundException(__('Course could be found!.'));

				// $this->Course->recursive = -1;
				// $course = $this->Course->find('first', array('fields'=>array('id'), 'conditions'=>array('Course.id'=>$id)));
				// $this->set(compact('course'));

				if($this->request->is('post') || $this->request->is('put'))
				{
						if($this->Course->CourseLesson->deleteAll(array('CourseLesson.course_id'=>$id), false) && $this->Course->CourseSpecification->deleteAll(array('CourseSpecification.course_id'=>$id), false))
						{
								$this->Course->delete($id);
								$this->Session->setFlash(__('Course has been deleted successfully.'), 'flash/success');
						} else throw new NotFoundException(__('Failed to delete course.'), 'flash/error');

				} else throw new NotFoundException(__('Method not accepted.'));

				$this->redirect(array('controller'=>'courses', 'action'=>'/'));
		}

		public function get_default_schedule()
		{
			$this->layout = NULL;
			if(($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['course_id']))
			{
				list($course_id, $salt) = split('-', $this->request->data['course_id']);
				$this->Course->CourseLesson->recursive = -1;
				$course_lessons = $this->_restructure($this->Course->CourseLesson->find('all', array('joins'=>array(array('table'=>'lessons', 'alias'=>'Lesson', 'type'=>'LEFT', 'conditions'=>array('Lesson.id = CourseLesson.lesson_id')),
																													array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = CourseLesson.instructor_id'))),
															 					 'fields'=>array('Lesson.id', 'Lesson.title', 'Lesson.duration', 'CourseLesson.id', 'CourseLesson.lesson_id', 'CourseLesson.week', 'CourseLesson.day', 'CourseLesson.order',
																				  				 'CourseLesson.time_start', 'CourseLesson.time_end', 'Instructor.id', 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'),
															 					 'conditions'=>array('CourseLesson.course_id'=>$course_id),
																				 'order'=>array('CourseLesson.week'=>'ASC', 'CourseLesson.day'=>'ASC', 'CourseLesson.order'=>'ASC', 'CourseLesson.created'=>'ASC'))));
				$this->set(compact('course_lessons'));

				$week_days_name = $this->day;
				$this->set(compact('week_days_name'));

				if(isset($this->request->data['start_date']) && trim($this->request->data['start_date'])!='') $this->set('start_date', $this->request->data['start_date']);
				if(isset($this->request->data['end_date']) && trim($this->request->data['end_date'])!='') $this->set('end_date', $this->request->data['end_date']);
			}
			$this->render('/Elements/default_schedule');
		}
	}
