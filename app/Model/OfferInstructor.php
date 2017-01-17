<?php
	class OfferInstructor extends AppModel
	{
		public $belongsTo = array('Offering', 'Instructor');
		
		public function __construct($id=false, $table=NULL, $ds=NULL) 
		{
			parent::__construct($id, $table, $ds);			
			$this->virtualFields['fullname'] = $this->Instructor->virtualFields['fullname'];
		}
	}
?>