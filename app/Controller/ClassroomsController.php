<?php
		class ClassroomsController extends AppController
		{
				public $scaffold;
				public $paginate;
				public $components = array('RequestHandler');

				public function beforeFilter() {}

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
						$this->Classroom->recursive = -1;
						$this->paginate = array('limit'=>25, 'fields'=>array('Classroom.*'), 'order'=>array('Classroom.created'=>'DESC'));
		   			$this->set('classrooms', $this->paginate());
				}

				public function add()
				{
						if($this->request->is('post') || $this->request->is('put'))
						{
								$user_id = $this->Auth->user('id');
								$this->request->data['Classroom']['user_id'] = $user_id;
								$this->Classroom->recursive = -1;
								if($this->Classroom->save($this->request->data['Classroom'])):
										$this->Session->setFlash(__('New classroom has been added.'), 'flash/success');
										$this->redirect(array('action' => '/'));
								else:
										$this->Session->setFlash(__('Unable to add new classroom.'), 'flash/error');
								endif;
						}
				}

				public function view($id)
				{
						if(!$this->Classroom->exists($id)) throw new NotFoundException(__('Classroom could not be found.'));

						$this->Classroom->recursive = -1;
						$classroom = $this->Classroom->find('first', array('fields'=>array('Classroom.*'), 'conditions'=>array('Classroom.id'=>$id)));

						$this->paginate = array('joins'=>array(array('table'=>'offer_classrooms', 'alias'=>'OfferClassroom', 'type'=>'INNER', 'conditions'=>array('OfferClassroom.classroom_id = Classroom.id')),
																									 array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'INNER', 'conditions'=>array('Offering.id = OfferClassroom.offering_id')),
																								   array('table'=>'courses', 'alias'=>'Course', 'type'=>'INNER', 'conditions'=>array('Course.id = Offering.course_id')),
																								   array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'INNER', 'conditions'=>array('CourseCategory.id = Course.course_category_id'))),
																		'fields'=>array('Offering.code', 'Course.id', 'Course.code', 'Course.title', 'CourseCategory.id', 'CourseCategory.name', 'Offering.date_start', 'Offering.date_end'),
																		'conditions'=>array('Classroom.id'=>$id),
																		'order'=>array('Course.title'=>'ASC'),
																		'group'=>'Course.id',
																		'limit'=>10);
						$courses = $this->paginate();

						$this->set(compact('classroom', 'courses'));
				}

				public function edit($id)
				{
						$this->Classroom->id = $id;

						if(!$this->Classroom->exists($id)) throw new NotFoundException(__('Classroom could not be found!'));

						if($this->request->is('post') || $this->request->is('put'))
						{
								$user_id = $this->Auth->user('id');
								$this->request->data['Classroom']['last_modifier_id'] = $user_id;
								if($this->Classroom->save($this->request->data['Classroom'])):
										$this->Session->setFlash(__('Classroom has been successfully updated.'), 'flash/success');
								else:
										$this->Session->setFlash(__('Unable to update classroom.'), 'flash/error');
								endif;
						}

						$this->Classroom->recursive = -1;
						$this->request->data = $classroom = $this->Classroom->find('first', array('fields'=>array('Classroom.*'), 'conditions'=>array('Classroom.id'=>$id)));
						$this->set(compact('classroom'));
				}

				public function delete($id)
				{
						$this->Classroom->id = $id;

						if(!$this->Classroom->exists($id)) throw new NotFoundException(__('Classroom could not be found!'));

						if($this->request->is('post') || $this->request->is('put'))
						{
								if($this->Classroom->OfferClassroom->deleteAll(array('OfferClassroom.classroom_id'=>$id), false))
								{
										$this->Classroom->delete($id);
										$this->Session->setFlash(__('Classroom has been deleted successfully.'), 'flash/success');
								} else throw new NotFoundException(__('Failed to delete classroom.'), 'flash/error');

						} else throw new NotFoundException(__('Method not accepted.'));

						$this->redirect(array('controller'=>'classrooms', 'action'=>'/'));
				}
		}
?>
