<?php
	class Course extends AppModel
	{
		public $belongsTo = array('CourseCategory', 'User');
		public $hasMany = array('CourseSpecification', 'CourseLesson', 'Offering');
		public $virtualFields = array('author' => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Course.user_id LIMIT 1)");
	}