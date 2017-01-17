<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

  	public function beforeFilter()
	{
		parent::beforeFilter();
		if(!$this->Auth->user()) $this->redirect(array('controller'=>'users', 'action'=>'login'));
		else $this->Auth->allow('display');
	}
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display()
	{
		//load offering Module
		$this->loadModel('Offering');
		//-----------------------------------------

		//on-going courses....
		$thisWeeksEvents = $this->Offering->find("all", array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
															  'fields'=>array('Course.title', 'Offering.id', 'Offering.code', 'Offering.date_start', 'Offering.date_end', 'Offering.number_of_participants'),
															  'conditions'=>array('WEEK(Offering.date_start, 3) = WEEK(NOW(), 3)', 'YEAR(Offering.date_start) = YEAR(NOW())'),
															  'order'=>array('Offering.date_start'=>'DESC'),
															  'recursive'=>-1));
		$this->set(compact('thisWeeksEvents'));
		//-----------------------------------------

		//next three weeks courses....
		$nextThreeWeeksEvents = $this->Offering->find("all", array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
															  	   'fields'=>array('Course.title', 'Offering.id', 'Offering.code', 'Offering.date_start', 'Offering.date_end', 'Offering.number_of_participants'),
															  	   'conditions'=>array('WEEK(Offering.date_start,3) BETWEEN (WEEK(NOW(),3)+1) AND (WEEK(NOW(),3)+2)', 'WEEK(NOW(),3) <= WEEK(Offering.date_end,3)', 'YEAR(Offering.date_start) = YEAR(NOW())'),
															       'order'=>array('Offering.date_start'=>'DESC'),
															       'recursive'=>-1));
		$this->set(compact('nextThreeWeeksEvents'));
		//-----------------------------------------

		$path = func_get_args();
		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
