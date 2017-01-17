<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $theme = "TAS-v1.1.1";

	//'authorize' => array('Actions' => array('actionPath' => 'controllers'))
	public $components = array('Acl', 'Session', 'Auth' => array('authenticate' => array('Form' => array('passwordHasher' => 'Blowfish')), 'authorize' => array('Controller')),);
	/*public $components = array('Acl', 'Session',
							   'Auth' => array('loginRedirect' => array('controller' => 'users', 'action' => 'login'),
							   				   'logoutRedirect' => array('controller' => '/', 'action' => '/'),
											   'authenticate' => array('Form' => array('passwordHasher' => 'Blowfish')),
											   'authorize' => array('Controller'),
											   )
							  );*/

	public $helpers = array('Html', 'Form','Session');

	public function beforeFilter()
	{
			$this->Auth->allow('index', 'view');

      //Configure AuthComponent
      $this->Auth->loginAction = array('plugin' => false, 'controller' => 'users', 'action' => 'login');
      $this->Auth->logoutRedirect = array('plugin' => false, 'controller' => 'users', 'action' => 'login');
      $this->Auth->loginRedirect = '/';

      $this->Auth->authError = __('You are not authorized to access that location.');

        // If YALP not loaded then use Form Auth
        if(CakePlugin::loaded('YALP'))	$this->Auth->authenticate = array('YALP.LDAP' => NULL);

        parent::beforeFilter();
    }

	/*public function beforeFilter()
	{
		$this->Auth->allow('index', 'view');
	}*/

	public function beforeRender()
	{
		if($this->Auth->user())
		{
			$current_user =  AuthComponent::user();
			$this->set(compact('current_user'));
		}
	}

	public function isAuthorized($user)
	{
	    // Admin can access every action
	    if(isset($user['role']) && $user['role'] === 'admin')
		{
	        return true;
	    }

	    // Default deny
	    return false;
	}


	//---------------------------------
	public $day = array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

	public function _numberToDay($int=0)
	{
		return $this->day[$int];
	}

	public function _restructure($array, $key='CourseLesson')
	{
		$result = "";
		if(count($array))
		{
			$currentWeekNumber = NULL;
			$currentDay = NULL;
			$_week = "";
			$_day = "";
			$lessons_for_a_week = "";
			$lesson_for_the_day = "";
			$cntr = count($array);
			foreach($array as $vals):
				$cntr--;
				if($currentWeekNumber!=$vals[$key]['week'])
				{
					if($lesson_for_the_day)
					{
						$_day['children'] = $lesson_for_the_day;
						$lessons_for_a_week[$currentDay] = $_day;
					}
					if($lessons_for_a_week) $_week['children'] = $lessons_for_a_week;
					if($_week) $result[] = $_week;
					$currentDay = NULL;
					$_week = "";
					$_day = "";
					$lessons_for_a_week = "";
					$lesson_for_the_day = "";
				}

				if($currentDay!=$vals[$key]['day'])
				{
					if($lesson_for_the_day)
					{
						$_day['children'] = $lesson_for_the_day;
						$lessons_for_a_week[$currentDay] = $_day;
					}
					$lesson_for_the_day = "";
				}

				$lesson_for_the_day[] = array('id'=>$vals[$key]['id'],
											  'order'=>$vals[$key]['order'],
											  'lesson_id'=>$vals['Lesson']['id'],
											  'title'=>$vals['Lesson']['title'],
											  'instructor_id'=>$vals['Instructor']['id'],
											  'instructor'=>$vals['Instructor']['fullname'],
											  'duration'=>$vals['Lesson']['duration'],
											  'time_start'=>$vals[$key]['time_start'],
											  'time_end'=>$vals[$key]['time_end']);

				if($currentDay!=$vals[$key]['day'])
				{
					$currentDay = $vals[$key]['day'];
					$_day = array('day'=>$vals[$key]['day'], 'name'=>$this->_numberToDay($vals[$key]['day']));
				}

				if($currentWeekNumber!=$vals[$key]['week'])
				{
					$currentWeekNumber = $vals[$key]['week'];
					$_week = array('week'=>$vals[$key]['week']);
				}

				if($cntr==0)
				{
					if($lesson_for_the_day)
					{
						$_day['children'] = $lesson_for_the_day;
						$lessons_for_a_week[$currentDay] = $_day;
					}
					if($lessons_for_a_week) $_week['children'] = $lessons_for_a_week;
					if($_week) $result[] = $_week;
				}
			endforeach;
		}
		return $result;
	}
}
