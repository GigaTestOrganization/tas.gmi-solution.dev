<?php
	class OfferingParticipantsController extends AppController
	{
		public function beforeFilter() {}

		public function isAuthorized($user)
		{
		    // if(in_array($this->action, array('add', 'edit', 'remove')))
				// {
		    //     return true;
		    // }

				if(in_array(trim($user['role']), array('admin', 'sales', 'registrar', 'instructor')))
				{
		        return true;
		    }

		    return parent::isAuthorized($user);
		}

		public function index(){ $this->layout = NULL; }

		public function add()
		{
			$this->layout = NULL;
			$data = array("isError"=>false, "message"=>"Method not allowed!");
			$this->OfferingParticipant->recursive = -1;
			$current_date = date("Y-m-d H:i:s", time());
			$this->request->data['created'] = $current_date;
			if($this->OfferingParticipant->save($this->request->data))
			{
				$data['id'] = $this->OfferingParticipant->getInsertID();
				$data['created'] = date('M d, Y - h:ia', strtotime($current_date));
			} else $data['isError'] = true;

			$this->set(compact('data'));
			$this->render('/Elements/json');
		}

		public function remove()
		{
			$this->layout = NULL;
			$data = array("isError"=>true, "message"=>"Method not allowed!");
			if($this->request->is('post') || $this->request->is('put'))
			{
				extract($this->request->data);
				if(isset($id))
				{
					$this->OfferingParticipant->recursive = -1;
					$offeringParticipant = $this->OfferingParticipant->find('first', array('fields'=>array('id'), 'conditions'=>array('OfferingParticipant.id'=>$id)));
					if(!$offeringParticipant) $data['message'] = "Invalid ID!";
					else
					{
						if($this->OfferingParticipant->delete($id)) $data = array("isError"=>false, "message"=>"Participant successfully unenrolled!");
						else $data["message"] = "Failed to remove participant!";
					}
				} else $data["message"] = "ID doesn't exist!";
			}
			$this->set(compact('data'));
			$this->render('/Elements/json');
		}

		public function edit()
		{
			$this->layout = NULL;
			$data = array("isError"=>true, "message"=>"Method not allowed!");
			if($this->request->is('post') || $this->request->is('put')):
					if(isset($this->request->data['ApplyToAll'])):
							try
							{
								unset($this->request->data['OfferingParticipant']['id']);
								$this->OfferingParticipant->recursive = -1;
								if($this->OfferingParticipant->updateAll($this->request->data['OfferingParticipant'], array("OfferingParticipant.offering_id"=>$this->request->data['OfferingID']))):
										$data = array("isError"=>false, "message"=>"Update successfully saved!");
								else:
										$data["message"] = "Failed to save updates!";
								endif;
							}
							catch (Exception $e)
							{
								 $data["message"] = $e->queryString;
							}

					else:
							if($this->OfferingParticipant->save($this->request->data)):
									$data = array("isError"=>false, "message"=>"Update successfully saved!");
							else:
									$data["message"] = "Failed to save updates!";
							endif;
					endif;

			endif;
			$this->set(compact('data'));
			$this->render('/Elements/json');
		}

		private function _var_dump_ret($mixed = null)
		{
		  ob_start();
		  var_dump($mixed);
		  $content = ob_get_contents();
		  ob_end_clean();
		  return $content;
		}

		public function additionalDetails($id)
		{
			if(!$id):
				throw new NotFoundException(__('Participant\' additional information not found.'));
			else:
				$this->layout = NULL;

				$this->OfferingParticipant->recursive = -1;
				$additionalDetails = $this->OfferingParticipant->find('all', array('joins'=>array(array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'LEFT', 'conditions'=>array('Offering.id = OfferingParticipant.offering_id'))), 'fields'=>array('OfferingParticipant.offering_id', 'OfferingParticipant.id', 'OfferingParticipant.transport_provider', 'OfferingParticipant.transport_arrangement', 'OfferingParticipant.hotel_name', 'OfferingParticipant.hotel_room_type', 'OfferingParticipant.hotel_period_of_stay', 'OfferingParticipant.meal_arrangement', 'OfferingParticipant.sales_order_no', 'Offering.sales_order_no'), 'conditions'=>array('OfferingParticipant.id'=>$id)));

				$this->set(compact(array('additionalDetails', 'id')));
			endif;
		}
	}
?>
