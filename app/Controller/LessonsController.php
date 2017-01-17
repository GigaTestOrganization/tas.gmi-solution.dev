<?php
		class LessonsController extends AppController
		{
				public $scaffold;
				public $paginate;

				public function isAuthorized($user)
				{
				    if(strtolower($this->action) === 'get_default_schedule') { return true;  }

					if(trim($user['role'])==='instructor') return true;

				    return parent::isAuthorized($user);
				}

				public function index()
				{
						$this->Lesson->recursive = -1;
					    /*$this->paginate = array('joins'=>array(array('table' => 'lesson_contents', 'alias' => 'LessonContent', 'type' => 'LEFT', 'conditions' =>array('LessonContent.lesson_id = Lesson.id'))),
												'limit'=>25,
												'fields'=>array('Lesson.*', 'LessonContent.duration', '(SELECT COUNT(*) AS Revision FROM lesson_contents WHERE lesson_contents.lesson_id = Lesson.id) AS Revision'),
												'order'=>array('Lesson.created' => 'ASC'),
												'conditions'=>array('LessonContent.published'=>'1'));*/
						$this->paginate = array('table'=>array('lessons', 'alias' => 'Lesson'), 'limit'=>25, 'fields'=>array('Lesson.*'), 'order'=>array('Lesson.created' => 'DESC'));//, 'conditions'=>array('Lesson.published'=>1));
		   			$this->set('lessons', $this->paginate());
				}

				public function add()
				{
						if($this->request->is('post') || $this->request->is('put'))
						{
								$user_id = $this->Auth->user('id');
								$link_to_material = "";
								if(isset($this->request->data['link_to_material']))
								{
										foreach($this->request->data['link_to_material'] as $key => $ltm)
										{
												if(trim($ltm)!='') $link_to_material .= (trim($link_to_material)!=''?"<-:::->":"").$ltm;
										}
								}
								$this->request->data['Lesson']['link_to_material'] = $link_to_material;
								$this->request->data['Lesson']['user_id'] = $user_id;
								$this->Lesson->recursive = -1;
								if($this->Lesson->save($this->request->data['Lesson']))
								{
										$unique_id = $this->Lesson->id;

										$lesson_data['Lesson']['code'] = 'L'.(strlen($unique_id)<3?sprintf('%05d',$unique_id):$unique_id);
										if($this->Lesson->save($lesson_data)) $this->Session->setFlash(__('New lesson has been created.'));
										else $this->Session->setFlash(__('New lesson has been successfully created, though a unique code for the lesson failed to be generated. Please contact the administrator.'));

										$this->redirect(array('action'=>'edit', $unique_id));
								}
								else
								{
										$this->Session->setFlash(__('Unable to create new lesson.'));
								}
						}
				}

				public function edit($id)
				{
						$this->Lesson->id = $id;

						if(!$this->Lesson->exists($id)) throw new NotFoundException(__('Lesson could not be found!'));

						if($this->request->is('post') || $this->request->is('put'))
						{
								$user_id = $this->Auth->user('id');
								$link_to_material = "";
								if(isset($this->request->data['link_to_material']))
								{
										foreach($this->request->data['link_to_material'] as $key => $ltm)
										{
												if(trim($ltm)!='') $link_to_material .= (trim($link_to_material)!=''?"<-:::->":"").$ltm;
										}
								}
								$this->request->data['Lesson']['link_to_material'] = $link_to_material;
								$this->request->data['Lesson']['last_modifier_id'] = $user_id;
								$this->request->data['Lesson']['published'] = (isset($this->request->data['Lesson']['published'])?1:0);
								if($this->Lesson->save($this->request->data['Lesson']))
								{
										$this->Session->setFlash(__('Lesson has been successfully updated.'), 'flash/success');
								}
								else
								{
										$this->Session->setFlash(__('Unable to update your lesson.'), 'flash/error');
								}
						}

						$this->Lesson->recursive = -1;
						$this->request->data = $lesson = $this->Lesson->find('first', array('fields'=>array('Lesson.*'), 'conditions'=>array('Lesson.id'=>$id)));
						$this->set(compact('lesson'));
				}

				public function view($id)
				{
						if(!$this->Lesson->exists($id)) throw new NotFoundException(__('Lesson not found.'));

						$this->Lesson->recursive = -1;
						$lesson = $this->Lesson->find('first', array('fields'=>array('Lesson.*'), 'conditions'=>array('Lesson.id'=>$id)));

						$this->paginate = array('joins'=>array(array('table'=>'course_lessons', 'alias'=>'CourseLesson', 'type'=>'RIGHT', 'conditions'=>array('CourseLesson.lesson_id = Lesson.id')),
																								   array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = CourseLesson.course_id')),
																								   array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'LEFT', 'conditions'=>array('CourseCategory.id = Course.course_category_id'))),
																		'fields'=>array('Course.id', 'Course.code', 'Course.title', 'CourseCategory.id', 'CourseCategory.name'),
																		'conditions'=>array('Lesson.id'=>$id),
																		'order'=>array('Course.title'=>'ASC'),
																		'group'=>'Course.id',
																		'limit'=>10);

						$courses = $this->paginate();
						$this->set(compact('lesson', 'courses'));
				}

				public function search()
				{
						$this->layout = NULL;
						$data = "";
						if(($this->request->is('post') || $this->request->is('put')) && isset($this->request->data['has_any']))
						{
								$this->Lesson->recursive = -1;
								$data = $this->Lesson->find('all', array('joins'=>array(array('table'=>'lesson_contents', 'alias'=>'LessonContent', 'type'=>'LEFT',
																																							'conditions'=>array('LessonContent.lesson_id = Lesson.id', 'LessonContent.published'=>'1'))),
																		 										 'fields'=>array('Lesson.id', 'Lesson.title', 'LessonContent.id', 'LessonContent.duration'),
																												 'conditions'=>array('LessonContent.published'=>1, 'Lesson.title LIKE'=>"%".$this->request->data['has_any']."%")));

						}
						$this->set(compact('data'));
						$this->render('/elements/json');
				}
		}
	?>
