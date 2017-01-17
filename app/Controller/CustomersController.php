<?php
		class CustomersController extends AppController
		{
				public $scaffold;
				public $paginate;
				public $components = array('RequestHandler');

				public function beforeFilter(){}

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
						$this->Customer->recursive = -1;
						$this->paginate = array('table'=>array('customers', 'alias'=>'Customer'), 'limit'=>20, 'fields'=>array('Customer.*'), 'order'=>array('Customer.created'=>'DESC'));
		   			$this->set('customers', $this->paginate());
				}

				public function view($id)
				{
						if(!$id) throw new NotFoundException(__('Customer not found.'));
						$this->Customer->recursive = -1;
						$customer = $this->Customer->find('first', array('table'=>'customers', 'alias'=>'Customer', 'fields'=>array('Customer.*'), 'conditions'=>array('Customer.id'=>$id)));
						$this->set(compact('customer'));
						if(!$customer) throw new NotFoundException(__('Customer not found.'), 'flash/error');
				}

				public function add()
				{
						if($this->request->is('post') || $this->request->is('put'))
						{
								$user_id = $this->Auth->user('id');
								$this->request->data['Customer']['user_id'] = $user_id;
								$this->Customer->recursive = -1;
								if($this->Customer->save($this->request->data['Customer']))
								{
										$this->Session->setFlash(__('New customer has been added.'), 'flash/success');
										$this->redirect(array('action' => 'index'));
								}
								else
								{
										$this->Session->setFlash(__('Unable to add new customer.'), 'flash/error');
								}
						}
				}

				public function edit($id = null)
				{
						if (!$this->Customer->exists($id)) throw new NotFoundException(__('Customer not found.'));

						if($this->request->is('post') || $this->request->is('put')):
								$this->Customer->id = $id;
								$user_id = $this->Auth->user('id');
								$this->request->data['Customer']['last_modifier_id'] = $user_id;
								if($this->Customer->save($this->request->data)):
										$this->Session->setFlash(__('Customer has been successfully updated.'), 'flash/success');
										//$this->redirect(array('action' => 'index'));
								else:
										$this->Session->setFlash(__('Unable to update customer.'), 'flash/error');
								endif;
						endif;

						$this->Customer->recursive = -1;
						$this->request->data = $customer = $this->Customer->find('first', array('table'=>'customers', 'alias'=>'Customer', 'fields'=>array('Customer.*'), 'conditions'=>array('Customer.id'=>$id)));
						$this->set(compact('customer'));
				}

				public function delete($id)
				{
					 $this->Customer->delete($id);
				}
		}
?>
