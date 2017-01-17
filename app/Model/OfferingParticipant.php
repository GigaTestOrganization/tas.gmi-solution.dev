<?php
	class OfferingParticipant extends AppModel
	{		
		public $belongsTo = array('Offering', 'Person');		
		
		public function __construct($id=false, $table=NULL, $ds=NULL) 
		{
			parent::__construct($id, $table, $ds);			
			$this->virtualFields['fullname'] = $this->Person->virtualFields['fullname'];
		}
	}
?>