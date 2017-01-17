<?php
	class Schedule extends AppModel
	{
		public $belongsTo = array('Offering', 'Lesson', 'Instructor');	
		
		public function __construct($id=false, $table=NULL, $ds=NULL) 
		{
			parent::__construct($id, $table, $ds);			
			$this->virtualFields['fullname'] = $this->Instructor->virtualFields['fullname'];
		}	
	}
?>