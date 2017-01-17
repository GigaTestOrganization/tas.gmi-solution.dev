<?php
	class InstructorsController extends AppController
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
				$this->Instructor->recursive = -1;
				$this->paginate = array('limit'=>25, 'fields'=>array('Instructor.*'), 'order'=>array('Instructor.created'=>'DESC'));
				$this->set('instructors', $this->paginate());
		}

		public function add()
		{
				if($this->request->is('post') || $this->request->is('put'))
				{
						$user_id = $this->Auth->user('id');
						$this->request->data['Instructor']['user_id'] = $user_id;
						$this->Instructor->recursive = -1;
						if($this->Instructor->save($this->request->data['Instructor'])):
								$this->Session->setFlash(__('New instructor has been added.'), 'flash/success');
								$this->redirect(array('action' => 'index'));
						else:
								$this->Session->setFlash(__('Unable to add new instructor.'), 'flash/error');
						endif;
				}
		}

		public function view($id)
		{
				if(!$this->Instructor->exists($id)) throw new NotFoundException(__('Instructor not found.'));

				$this->Instructor->recursive = -1;
				$instructor = $this->Instructor->find('first', array('fields'=>array('Instructor.*'), 'conditions'=>array('Instructor.id'=>$id)));

				$this->paginate = array('joins'=>array(array('table'=>'offer_instructors', 'alias'=>'OfferInstructor', 'type'=>'RIGHT', 'conditions'=>array('OfferInstructor.instructor_id = Instructor.id')),
																							 array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'LEFT', 'conditions'=>array('Offering.id = OfferInstructor.offering_id')),
																						   array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id')),
																						   array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'LEFT', 'conditions'=>array('CourseCategory.id = Course.course_category_id'))),
																'fields'=>array('Offering.code', 'Course.id', 'Course.code', 'Course.title', 'CourseCategory.id', 'CourseCategory.name'),
																'conditions'=>array('Instructor.id'=>$id),
																'order'=>array('Course.title'=>'ASC'),
																'group'=>'Course.id',
																'limit'=>10);
				$courses = $this->paginate();

				$this->set(compact('instructor', 'courses'));
		}

		public function edit($id)
		{
				$this->Instructor->id = $id;

				if(!$this->Instructor->exists($id)) throw new NotFoundException(__('Instructor could not be found!'));

				if($this->request->is('post') || $this->request->is('put'))
				{
						$user_id = $this->Auth->user('id');
						$this->request->data['Instructor']['last_modifier_id'] = $user_id;
						$this->request->data['Instructor']['flex'] = (isset($this->request->data['Instructor']['flex'])?1:0);
						if($this->Instructor->save($this->request->data['Instructor'])):
								$this->Session->setFlash(__('Instructor has been successfully updated.'), 'flash/success');
						else:
								$this->Session->setFlash(__('Unable to update instructor.'), 'flash/error');
						endif;
				}

				$this->Instructor->recursive = -1;
				$this->request->data = $instructor = $this->Instructor->find('first', array('fields'=>array('Instructor.*'), 'conditions'=>array('Instructor.id'=>$id)));
				$this->set(compact('instructor'));
		}

		public function delete($id)
		{
				$this->Instructor->id = $id;

				if(!$this->Instructor->exists($id)) throw new NotFoundException(__('Instructor could not be found!'));

				if($this->request->is('post') || $this->request->is('put'))
				{
						if($this->Instructor->OfferInstructor->deleteAll(array('OfferInstructor.instructor_id'=>$id), false))
						{
								$this->Instructor->delete($id);
								$this->Session->setFlash(__('Instructor has been deleted successfully.'), 'flash/success');
						} else throw new NotFoundException(__('Failed to delete instructor.'), 'flash/error');

				} else throw new NotFoundException(__('Method not accepted.'));

				$this->redirect(array('controller'=>'instructors', 'action'=>'/'));
		}

		public function select()
		{
				$this->layout = NULL;
				$this->Instructor->recursive = -1;
				$conditions = array();
				if($this->request->is('post') || $this->request->is('put'))
				{
						extract($this->request->data);
						$this->set('search', true);
						$conditions[] = (isset($keyword)&&trim($keyword)!=''?"CONCAT_WS(' ', Instructor.first_name, Instructor.last_name) LIKE '%".$keyword."%'":"");
						$conditions[] = (isset($isflex)&&trim($isflex)!=''&&trim($isflex)!=0?"Instructor.flex = ".$isflex:"");
				}
				$this->paginate = array('limit'=>25, 'fields'=>array('Instructor.id', 'Instructor.first_name', 'Instructor.last_name'),
																'conditions'=>$conditions,
																'order'=>array('Instructor.first_name'=>'ASC'));
	   			$this->set('instructors', $this->paginate());

				$this->render('/Elements/instructors');
		}
	}
?>
