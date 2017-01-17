<?php
	class UsersController extends AppController
	{
		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow('register', 'logout');
		}

		public function login()
		{
				$this->layout = NULL;
				if($this->Auth->user()) $this->redirect(array('controller'=>'/', 'action'=>'/'));
				if ($this->request->is('post')) {
						if($this->Auth->login())
						{
								if(CakePlugin::loaded('YALP')):
										$this->User->UserProfile->recursive = -1;
										$auth_user = array_merge($this->Session->read('Auth.User'), $this->User->UserProfile->find('first', array('conditions'=>array('UserProfile.user_id'=>$this->Auth->user('id')))));
										$this->Session->write('Auth.User', $auth_user);
								endif;
								return $this->redirect($this->Auth->redirect());
						}
						$this->Session->setFlash(__('Invalid username or password, try again'), 'flash/error');
				}
		}

		public function logout() {
			return $this->redirect($this->Auth->logout());
		}

		public function index() {
			$this->User->recursive = 0;
			$this->set('users', $this->paginate());
		}

		public function view($id = null) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			$this->set('user', $this->User->read(null, $id));
		}

		public function register()
		{
			if ($this->request->is('post')) {
				if($this->Auth->user()) {$this->request->data['UserProfile']['last_modifier_id'] = $this->Auth->user('id');	}
				if(intval($this->request->data['isanewcompany']))
				{
					$contact_pers = ($this->request->data['UserProfile']['first_name']." ".$this->request->data['UserProfile']['last_name']);
					$contact_no = (isset($this->request->data['UserProfile']['telephone_number'])&&trim($this->request->data['UserProfile']['telephone_number'])!=''?$this->request->data['UserProfile']['telephone_number']:'');
					$newCompany = array('name'=>$this->request->data['company_name'], 'address'=>$this->request->data['company_address'], 'contact_number'=>$contact_no, 'contact_person'=>$contact_pers, 'email_add'=>$this->request->data['UserProfile']['email_add'], 'user_id'=>0);
					if($this->User->UserProfile->Customer->save($newCompany))
					{
						$company_id = $this->User->UserProfile->Customer->getLastInsertId();
						$this->request->data['UserProfile']['customer_id'] = $company_id;
					}
				}
				if ($this->User->saveAll($this->request->data))
				{
					$id = $this->User->getLastInsertId();
					if(intval($this->request->data['isanewcompany']) && isset($company_id))
					{
						$id = $this->User->id;
						$update_company = array('id'=>$company_id, 'user_id'=>$id);
						$this->User->UserProfile->Customer->save($update_company);
					}

					$this->Session->setFlash(__('Account successfully created, please login.'));
					return $this->redirect(array('controller'=>'/', 'action' => '/'));
				}
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				$data_ = $this->request->data;
				$this->set(compact("data_"));
			}
			$this->User->UserProfile->Customer->recursive = -1;
			$customers = $this->User->UserProfile->Customer->find('all', array('fields'=>array('Customer.id', 'Customer.name')));
			$this->set(compact('customers'));
		}

		public function edit($id = null) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user has been saved'));
					return $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			} else {
				$this->request->data = $this->User->read(null, $id);
				unset($this->request->data['User']['password']);
			}
		}

		public function delete($id = null) {
			$this->request->onlyAllow('post');
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			if ($this->User->delete()) {
				$this->Session->setFlash(__('User deleted'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('User was not deleted'));
			return $this->redirect(array('action' => 'index'));
		}
	}
