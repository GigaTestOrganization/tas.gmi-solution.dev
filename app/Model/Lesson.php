<?php
	class Lesson extends AppModel
	{
		public $hasMany = array('CourseLesson', 'Schedule');
		public $virtualFields = array('encoder_name' => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Lesson.user_id LIMIT 1)");
	}