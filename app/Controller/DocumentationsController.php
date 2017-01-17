<?php

	class DocumentationsController extends AppController
	{
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
					$this->redirect("overview");
			}

			public function overview(){}

			public function getting_started() {}

			public function training_events()	{}
	}
?>
