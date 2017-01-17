<?php
		class PeopleController extends AppController
		{
				public $scaffold;
				public $paginate;
				public $components = array('RequestHandler');

				public function beforeFilter()
				{
					$this->Auth->allow('pdfpart');
				}

				public function isAuthorized($user)
				{
				    if(in_array(trim($user['role']), array('admin', 'sales', 'registrar', 'instructor')))
						{
				        return true;
				    }

				    return parent::isAuthorized($user);
				}

				public function index()
				{
						$this->Person->recursive = -1;
						$active_user = AuthComponent::user();
						if($active_user['role']==='customer')
						{
								$this->paginate = array('joins'=>array(array('table'=>'customers', 'alias'=>'Customer', 'type'=>'LEFT', 'conditions'=>array('Customer.id = Person.customer_id'))),
																				'limit'=>25,
																				'fields'=>array('Customer.name', 'Customer.id', 'Person.*'),
																				'order'=>array('Person.created'=>'DESC'),
																				'conditions'=>array('Person.customer_id'=>$active_user['UserProfile']['customer_id']));
						}
						else
						{
								$this->paginate = array('joins'=>array(array('table'=>'customers', 'alias'=>'Customer', 'type'=>'LEFT', 'conditions'=>array('Customer.id = Person.customer_id'))),
																				'limit'=>25,
																				'fields'=>array('Customer.name', 'Customer.id', 'Person.*'),
																				'order'=>array('Person.created'=>'DESC'));
						}
			   		$this->set('people', $this->paginate());
				}

				public function view($id)
				{
						if(!$this->Person->exists($id)) throw new NotFoundException(__('Person not found.'));

						$this->Person->recursive = -1;
						$person = $this->Person->find('first', array('joins'=>array(array('table'=>'customers', 'alias'=>'Customer', 'type'=>'LEFT', 'conditions'=>array('Customer.id = Person.customer_id'))),
																												 'fields'=>array('Person.*', 'Customer.name'), 'conditions'=>array('Person.id'=>$id)));

						$this->paginate = array('joins'=>array(array('table'=>'offering_participants', 'alias'=>'OfferingParticipant', 'type'=>'RIGHT', 'conditions'=>array('OfferingParticipant.person_id = Person.id')),
																								   array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'LEFT', 'conditions'=>array('Offering.id = OfferingParticipant.offering_id')),
																								   array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id')),
																								   array('table'=>'course_categories', 'alias'=>'CourseCategory', 'type'=>'LEFT', 'conditions'=>array('CourseCategory.id = Course.course_category_id'))),
																		'fields'=>array('Course.id', 'Course.code', 'Course.title', 'CourseCategory.id', 'CourseCategory.name'),
																		'conditions'=>array('Person.id'=>$id),
																		'order'=>array('Course.title'=>'ASC'),
																		'group'=>'Course.id',
																		'limit'=>10);
						$courses = $this->paginate();

						$this->set(compact('person', 'courses'));
				}

				public function add()
				{
						$u = AuthComponent::user();
						if($this->request->is('post') || $this->request->is('put')):
								$this->request->data['Person']['user_id'] = $u['id'];
								$this->Person->recursive = -1;
								if($this->Person->save($this->request->data['Person'])):
										$this->Session->setFlash(__('New person has been added.'));
										$this->redirect(array('action' => 'index'));
								else:
										$this->Session->setFlash(__('Unable to add new person.'));
								endif;
						endif;

						$cust_cond = array();
						if($u['role']==='customer') $cust_cond = array('Customer.id = '.$u['UserProfile']['customer_id']);

						$this->Person->Customer->recursive = -1;
						$customers = $this->Person->Customer->find('list', array('conditions'=>$cust_cond));

						$cadetTypes = array('N/A'=>'N/A', 'Deck'=>'Deck', 'Engine'=>'Engine', 'ETO'=>'ETO', 'Gas'=>'Gas', 'PCG'=>'PCG');

						$this->set(compact('customers', 'cadetTypes'));
				}

				public function edit($id)
				{
						if(!$this->Person->exists($id)) throw new NotFoundException(__('Person not found.'));

						$u = AuthComponent::user();

						if($this->request->is('post') || $this->request->is('put')):
								$this->request->data['Person']['last_modifier_id'] = $u['id'];
								if($this->Person->save($this->request->data)):
										$this->Session->setFlash(__('Person details has been successfully updated.'), 'flash/success');
								else:
										$this->Session->setFlash(__('Unable to update person details.'), 'flash/error');
								endif;
						endif;

						$this->Person->recursive = -1;
						$this->request->data = $person = $this->Person->find('first', array('table'=>'people', 'alias'=>'Person', 'fields'=>array('Person.*'), 'conditions'=>array('Person.id'=>$id)));

						$cust_cond = array();
						if($u['role']==='customer') $cust_cond = array('Customer.id = '.$u['UserProfile']['customer_id']);

						$this->Person->Customer->recursive = -1;
						$customers = $this->Person->Customer->find('list', array('conditions'=>$cust_cond));

						$cadetTypes = array('N/A'=>'N/A', 'Deck'=>'Deck', 'Engine'=>'Engine', 'ETO'=>'ETO', 'Gas'=>'Gas', 'PCG'=>'PCG');

						$this->set(compact('person', 'customers', 'cadetTypes'));
				}

				public function select()
				{
						$this->layout = NULL;
						$this->Person->recursive = -1;
						$u = AuthComponent::user();
						$conditions = array();
						if($this->request->is('post') || $this->request->is('put')):
								extract($this->request->data);
								$this->set('search', true);
								$conditions[] = (isset($keyword)&&trim($keyword)!=''?"CONCAT_WS(' ', Person.first_name, Person.last_name) LIKE '%".$keyword."%'":"");
								if($u['role']!=='customer') $conditions[] = (isset($customerid)&&trim($customerid)!=''?"Person.customer_id = ".$customerid:"");
						endif;

						if($u['role']==='customer') $conditions[] = "Person.customer_id = ".$u['UserProfile']['customer_id'];

						$this->paginate = array('joins'=>array(array('table'=>'customers', 'alias'=>'Customer', 'type'=>'LEFT', 'conditions'=>array('Customer.id = Person.customer_id'))),
																		'fields'=>array('Customer.id', 'Customer.name', 'Person.id', 'Person.first_name', 'Person.last_name'),
																		'conditions'=>$conditions,
																		'order'=>array('Person.first_name'=>'ASC'));
			   		$this->set('people', $this->paginate());

						$this->Person->Customer->recursive = -1;
						$cust_cond = array();
						if($u['role']==='customer') $cust_cond = array('Customer.id = '.$u['UserProfile']['customer_id']);
						$customers = $this->Person->Customer->find('all', array('fields'=>array('Customer.id', 'Customer.name'), 'conditions'=>$cust_cond));
						$this->set(compact('customers'));

						$this->render('/Elements/people');
				}

				public function transcript_of_record()
				{
				}

				public function download($dynamic, $what)
				{
						if($this->request->is('post') || $this->request->is('put')):
								if($what=='training-report' && !empty($this->request->data['person'])):
									$this->layout = NULL;
									$persons_id = "";
									$this->set('data', $this->request->data);
									foreach($this->request->data['person']['id'] as $key => $val) $persons_id .= (trim($persons_id)!=''?',':'').$val;
									if(trim($persons_id)!=""):
											$this->Person->recursive = -1;
											$courses_taken = $this->Person->find('all', array('joins'=>array(array('table'=>'offering_participants', 'alias'=>'OfferingParticipant', 'type'=>'LEFT', 'conditions'=>array('OfferingParticipant.person_id = Person.id')),
																			  								 array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'LEFT', 'conditions'=>array('Offering.id = OfferingParticipant.offering_id')),
																											 array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
																							  'fields'=>array('Person.id', 'Person.cadet_type', 'Person.first_name', 'Person.last_name', 'Person.company_name', 'Course.title',
																							  				  'OfferingParticipant.grade', 'OfferingParticipant.status'),
																							  'conditions'=>array('Person.id IN ('.$persons_id.')', 'Offering.id IS NOT NULL'),
																							  'group'=>array('Course.id'),
																							  'order'=>array('Offering.date_end'=>'ASC')));
											$this->set(compact('courses_taken'));

											$filename = 'TrainingReports_TAS_'.date('Y-d-m_His').'.pdf';
											$base_URI = Router::url('/', true);
											$footer_URI = $base_URI.'people/pdfpart/'.$what.'/footer';
											$this->pdfConfig = array('options'=>array('footer-html'=>$footer_URI, 'dpi'=>96), 'margin'=>array('bottom'=>20, 'left'=>10, 'right'=>10, 'top'=>10), 'orientation'=>'portrait', 'filename'=>$filename);
									else:
										 throw new NotFoundException(__('Invalid URL'));
									endif;
								else:
										throw new NotFoundException(__('Invalid URL'));
								endif;
						else:
								throw new NotFoundException(__('Invalid URL'));
						endif;
				}

				public function pdfpart($for, $what)
				{
						$this->layout = NULL;
						$this->set(compact("for"));
						$this->set(compact("what"));
				}
		}
?>
