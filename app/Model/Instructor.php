<?php
	class Instructor extends AppModel
	{		
		public $hasMany = array("OfferInstructor", 'CourseLesson', 'Schedule');
		public $virtualFields = array('fullname'=>'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name)', 'encoder_name' => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Instructor.user_id LIMIT 1)");
	}
?>