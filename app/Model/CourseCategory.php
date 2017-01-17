<?php
	class CourseCategory extends AppModel
	{
		public $actsAs = array('Tree');
		public $hasMany = array('Course');
	}