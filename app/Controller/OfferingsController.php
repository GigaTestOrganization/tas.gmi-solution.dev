<?php
	class OfferingsController extends AppController
	{
			public $scaffold;
			public $paginate;
			public $components = array('RequestHandler');

			public function beforeFilter()
			{
				//$this->Auth->allow('index', 'view', 'pdfpart');
				$this->Auth->allow('pdfpart');
			}

			public function isAuthorized($user)
			{
			    if(in_array(trim($user['role']), array('sales', 'registrar', 'instructor')))
					{
			        return true;
			    }

			    // The owner of an offer can edit and delete it
			    /*if(in_array($this->action, array('edit', 'delete')))
				{
			        $offerId = (int) $this->request->params['pass'][0];
			        if($this->Offering->isOwnedBy($offerId, $user['id']))
					{
			            return true;
			        }
			    }

				if($this->action==='download')
				{
					if(in_array($user['role'], array('sales', 'registrar'))) return true;
				}*/

			    return parent::isAuthorized($user);
			}

			public function index($type=NULL)
			{
					$this->Offering->recursive = -1;
					$statuses = array('For Confirmation', 'Confirmed', 'Delivered', 'Invoiced', 'Cancelled');

					if($type!='json'):

							$this->paginate = array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))), 'limit'=>25, 'fields'=>array('Course.title', 'Offering.*'), 'order'=>array('Offering.created'=>'DESC'));
							$offerings = $this->paginate();
							$this->set(compact('offerings', 'statuses'));

					else:

							$this->layout = NULL;
							$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("instructor_names" => "(SELECT GROUP_CONCAT(CONCAT(SUBSTRING(Instructor.first_name, 1,1), '. ', Instructor.last_name) SEPARATOR ' / ') FROM offer_instructors AS OfferInstructor LEFT JOIN instructors AS Instructor ON Instructor.id = OfferInstructor.instructor_id WHERE OfferInstructor.offering_id = Offering.id GROUP BY OfferInstructor.offering_id)", "classrooms"=>"(SELECT GROUP_CONCAT(Classroom.name SEPARATOR ' / ') FROM offer_classrooms AS OfferClassroom LEFT JOIN classrooms AS Classroom ON Classroom.id = OfferClassroom.classroom_id WHERE OfferClassroom.offering_id = Offering.id GROUP BY OfferClassroom.offering_id)"));

							$_conditions = array("OR"=>array("(Offering.date_start BETWEEN '".$this->request->query('start')."' AND '".$this->request->query('end')."')", "(Offering.date_end BETWEEN '".$this->request->query('start')."' AND '".$this->request->query('end')."')"));

							$offerings =	$this->Offering->find('all', array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
																												 			 'fields'=>array('Course.title', 'Offering.id', 'Offering.code', 'Offering.date_start', 'Offering.date_end', 'Offering.instructor_names', 'Offering.classrooms', 'Offering.status'),
																												 		 	 'conditions'=>$_conditions,
																															 'order'=>array('Offering.date_start'=>'DESC')
																											   )
																					 );
							$data =	array();
							$colors = array('#c8d55d','#5dd5ad','#ee8383','#718bc4','#bfbb55','#717cc4','#8ed55d','#cb83e0','#547ee2','#95d55d','#9ab5fc','#3dd0d6','#6fe3b7','#48ae40','#ffaf6d','#d6a4ff','#5dbcd5','#b48be8','#fbb818');
							$cntr = 0;
							foreach($offerings as $key => $offering):
									if($cntr == count($colors)) $cntr = 0;
									$pickedColor = $colors[$cntr];
									$data[$key] = array("title"=>$offering['Course']['title'], 'start'=>date('Y-m-d 08:00:00', strtotime($offering['Offering']['date_start'])), 'end'=>date('Y-m-d 17:00:00', strtotime($offering['Offering']['date_end'])), 'id'=>$offering['Offering']['id'], 'url'=>'#', 'color'=>$pickedColor, 'borderColor'=>$pickedColor, 'textColor'=>'#000',  'instructors'=>$offering['Offering']['instructor_names'], 'classrooms'=>$offering['Offering']['classrooms'], 'status'=>$statuses[$offering['Offering']['status']]);
									$cntr++;
							endforeach;

							$this->set(compact('data'));
							$this->render('/Elements/json');
					endif;
			}

			public function add()
			{
				$this->Offering->recursive = -1;
				if($this->request->is('post') || $this->request->is('put'))
				{
					list($course_id, $salt) = split('-', $this->request->data['Offering']['course_id']);
					$this->request->data['Offering']['course_id'] = $course_id;

					if((isset($this->request->data['Offering']['status'])&&trim($this->request->data['Offering']['status'])=='') || !isset($this->request->data['Offering']['status'])) $this->request->data['Offering']['status'] = 0;
					if(isset($this->request->data['lead'])&&trim($this->request->data['lead'])!='') $this->request->data['OfferInstructor'][$this->request->data['lead']]['lead'] = 1;
					if($this->Offering->saveAll($this->request->data, array('validate'=>'first')))
					{
							$unique_id = $this->Offering->id;
							$offering_data['Offering']['code'] = 'TE'.date('Y',intval(strtotime($this->request->data['Offering']['date_start']))).date('W',intval(strtotime($this->request->data['Offering']['date_start']))).$unique_id;
							if($this->Offering->save($offering_data))
									$this->Session->setFlash(__('New training event has been successfully created.'), 'flash/success');
							else
									$this->Session->setFlash(__('New training event has been successfully created, though a unique code for the event failed to be generated. Please contact the administrator.'), 'flash/warning');

							$this->redirect(array('action'=>'edit', $unique_id));
					}
					else
					{
							$this->Session->setFlash(__('Unable to create new Offer.'), 'flash/error');
					}
				}
				$this->Offering->OfferInstructor->Instructor->recursive = -1;
				$instructors = $this->Offering->OfferInstructor->Instructor->find('all', array('fields'=>array('Instructor.id', 'Instructor.fullname')));
				$this->set(compact('instructors'));

				$this->Offering->OfferClassroom->Classroom->recursive = -1;
				$classrooms = $this->Offering->OfferClassroom->Classroom->find('all', array('fields'=>array('Classroom.id', 'Classroom.name'), 'order'=>array('Classroom.name'=>'ASC')));
				$this->set(compact('classrooms'));
			}

			public function edit($id)
			{
					if(!$id) throw new NotFoundException(__('Training event not found.'));

					$this->Offering->recursive = -1;
					$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("course_title"=>"(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id)"));
					$offering = $this->Offering->find('first', array('fields'=>array('Offering.*'),'conditions'=>array('Offering.id'=>$id)));
					$this->set(compact('offering'));
					if(!$offering) throw new NotFoundException(__('Training event not found.'));

					$this->Offering->OfferInstructor->recursive = -1;
					$this->Offering->Schedule->recursive = -1;
					if($this->request->is('post') || $this->request->is('put'))
					{
						list($course_id, $salt) = split('-', $this->request->data['Offering']['course_id']);
						$this->request->data['Offering']['course_id'] = $course_id;

						//Remove current Instructors and Schedules
						if(isset($this->request->data['default_inst'])&&intval($this->request->data['default_inst'])==1)
						{
								$this->Offering->OfferInstructor->deleteAll(array('OfferInstructor.offering_id'=>$id), false);
								$this->Offering->Schedule->deleteAll(array('Schedule.offering_id'=>$id), false);
						}

						if(isset($this->request->data['lead'])&&trim($this->request->data['lead'])!='')
						{
								$this->Offering->OfferInstructor->updateAll(array('OfferInstructor.lead'=>0), array('OfferInstructor.offering_id'=>$id));
								$this->request->data['OfferInstructor'][$this->request->data['lead']]['lead'] = 1;
						}

						if($this->Offering->saveAll($this->request->data, array('validate'=>'first')))
						{
								$offering = $this->Offering->find('first', array('table'=>'offerings', 'alias'=>'Offering', 'fields'=>array('Offering.*'), 'conditions'=>array('Offering.id'=>$id)));
								$this->set(compact('offering'));
								$this->Session->setFlash(__('Training event has been successfully updated.'), 'flash/success');
						}
						else
						{
								$this->Session->setFlash(__('Failed to update training event.'), 'flash/error');
						}
					}

					//Created Schedules
					$course_lessons = $this->_restructure($this->Offering->Schedule->find('all', array('joins'=>array(array('table'=>'lessons', 'alias'=>'Lesson', 'type'=>'LEFT', 'conditions'=>array('Lesson.id = Schedule.lesson_id')),
																														array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = Schedule.instructor_id'))),
																					 'fields'=>array('Lesson.id', 'Lesson.title', 'Lesson.duration', 'Schedule.id', 'Schedule.lesson_id', 'Schedule.week', 'Schedule.day', 'Schedule.order',
																									 'Schedule.time_start', 'Schedule.time_end', 'Instructor.id', 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'),
																					 'conditions'=>array('Schedule.offering_id'=>$id),
																					 'order'=>array('Schedule.week'=>'ASC', 'Schedule.day'=>'ASC', 'Schedule.order'=>'ASC', 'Schedule.created'=>'ASC'))), 'Schedule');
					$this->set(compact('course_lessons'));
					//-----------------

					//Selected Instructors
					$offerInstructors = $this->Offering->OfferInstructor->find('all', array('joins'=>array(array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = OfferInstructor.instructor_id'))),
																							'fields'=>array('OfferInstructor.id', 'OfferInstructor.instructor_id', 'OfferInstructor.fullname', 'OfferInstructor.lead'),
																							'conditions'=>array('OfferInstructor.offering_id'=>$id), 'order'=>array('OfferInstructor.created'=>'ASC')));
					$this->set(compact('offerInstructors'));
					//-----------------

					//Selected Classrooms
					$this->Offering->OfferClassroom->recursive = -1;
					$offerClassrooms = $this->Offering->OfferClassroom->find('all', array('joins'=>array(array('table'=>'classrooms', 'alias'=>'Classroom', 'type'=>'LEFT', 'conditions'=>array('Classroom.id = OfferClassroom.classroom_id'))),
																						  'fields'=>array('OfferClassroom.id', 'OfferClassroom.classroom_id', 'Classroom.name'), 'conditions'=>array('OfferClassroom.offering_id'=>$id),
																						  'order'=>array('OfferClassroom.created'=>'ASC')));
					$this->set(compact('offerClassrooms'));
					//-----------------


					$this->Offering->OfferInstructor->Instructor->recursive = -1;
					$instructors = $this->Offering->OfferInstructor->Instructor->find('all', array('fields'=>array('Instructor.id', 'Instructor.fullname')));
					$this->set(compact('instructors'));

					$this->Offering->OfferClassroom->Classroom->recursive = -1;
					$classrooms = $this->Offering->OfferClassroom->Classroom->find('all', array('fields'=>array('Classroom.id', 'Classroom.name')));
					$this->set(compact('classrooms'));
			}

			public function view($id)
			{
					if(!$id) throw new NotFoundException(__('Training event not found.'));

					$this->Offering->recursive = -1;
					$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("course_title"=>"(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id)"));
					$offering = $this->Offering->find('first', array('fields'=>array('Offering.*'), 'conditions'=>array('Offering.id'=>$id)));
					$this->set(compact('offering'));
					if(!$offering) throw new NotFoundException(__('Training event not found.'));

					//Schedules----
					$this->Offering->Schedule->recursive = -1;
					$course_lessons = $this->_restructure($this->Offering->Schedule->find('all', array('joins'=>array(array('table'=>'lessons', 'alias'=>'Lesson', 'type'=>'LEFT', 'conditions'=>array('Lesson.id = Schedule.lesson_id')),
																													  array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = Schedule.instructor_id'))),
																					 'fields'=>array('Lesson.id', 'Lesson.title', 'Lesson.duration', 'Schedule.id', 'Schedule.lesson_id', 'Schedule.week', 'Schedule.day', 'Schedule.order',
																									 'Schedule.time_start', 'Schedule.time_end', 'Instructor.id', 'CONCAT_WS(" ", Instructor.first_name, Instructor.last_name) AS Instructor__fullname'),
																					 'conditions'=>array('Schedule.offering_id'=>$id),
																					 'order'=>array('Schedule.week'=>'ASC', 'Schedule.day'=>'ASC', 'Schedule.order'=>'ASC', 'Schedule.created'=>'ASC'))), 'Schedule');
					$this->set(compact('course_lessons'));
					//-----------------

					$this->Offering->OfferInstructor->recursive = -1;
					$offerInstructors = $this->Offering->OfferInstructor->find('all', array('joins'=>array(array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = OfferInstructor.instructor_id'))),
																							'fields'=>array('OfferInstructor.fullname', 'OfferInstructor.lead'), 'conditions'=>array('OfferInstructor.offering_id'=>$id),
																							'order'=>array('OfferInstructor.created'=>'ASC')));
					$this->set(compact('offerInstructors'));

					$this->Offering->OfferClassroom->recursive = -1;
					$offerClassrooms = $this->Offering->OfferClassroom->find('all', array('joins'=>array(array('table'=>'classrooms', 'alias'=>'Classroom', 'type'=>'LEFT', 'conditions'=>array('Classroom.id = OfferClassroom.classroom_id'))),
																						  'fields'=>array('Classroom.name'), 'conditions'=>array('OfferClassroom.offering_id'=>$id), 'order'=>array('OfferClassroom.created'=>'ASC')));
					$this->set(compact('offerClassrooms'));

					$this->Offering->OfferingParticipant->recursive = -1;
					$offerParticipants = $this->Offering->OfferingParticipant->find('all', array('joins'=>array(array('table'=>'people', 'alias'=>'Person', 'type'=>'LEFT', 'conditions'=>array('Person.id = OfferingParticipant.person_id')), array('table'=>'customers', 'alias'=>'Customer', 'type'=>'LEFT', 'conditions'=>array('Customer.id = Person.customer_id'))), 'fields'=>array('OfferingParticipant.id', 'OfferingParticipant.fullname', 'OfferingParticipant.person_id', 'Customer.id', 'Customer.name', 'OfferingParticipant.grade', 'OfferingParticipant.status', 'OfferingParticipant.created'), 'conditions'=>array('OfferingParticipant.offering_id'=>$id), 'order'=>array('OfferingParticipant.created'=>'ASC')));
					$this->set(compact('offerParticipants'));

					$statuses = array('For Confirmation', 'Confirmed', 'Delivered', 'Invoiced', 'Cancelled');
					$this->set(compact('statuses'));
			}

			public function deleteResources()
			{
					$this->layout = NULL;
					$data = array("isError"=>true, "message"=>"Method not allowed!");
					if($this->request->is('post') || $this->request->is('put'))
					{
						extract($this->request->data);
						if(isset($id)&&isset($type))
						{
							switch($type)
							{
								case "instructor":
						  			$this->Offering->OfferInstructor->recursive = -1;
						  			$offerInstructor = $this->Offering->OfferInstructor->find('first', array('fields'=>array('id'), 'conditions'=>array('OfferInstructor.id'=>$id)));
						  			if(!$offerInstructor) $data['message'] = "Invalid resource id!";
						  			else
										{
							  				if($this->Offering->OfferInstructor->delete($id)) $data = array("isError"=>false, "message"=>"Instructor successfully removed!");
							  				else $data["message"] = "Failed to remove instructor!";
						  			}
								break;
								case "classroom":
										$this->Offering->OfferClassroom->recursive = -1;
						  			$offerClassroom = $this->Offering->OfferClassroom->find('first', array('fields'=>array('id'), 'conditions'=>array('OfferClassroom.id'=>$id)));
						  			if(!$offerClassroom) $data['message'] = "Invalid resource id!";
						  			else
										{
							  				if($this->Offering->OfferClassroom->delete($id)) $data = array("isError"=>false, "message"=>"Classroom successfully removed!");
							  				else $data["message"] = "Failed to remove classroom!";
						  			}
								break;
								default;
							}
						} else $data['message'] = "Invalid resource id!";
					}
					$this->set(compact('data'));
					$this->render('/Elements/json');
			}

			public function download($dynamic, $what, $id, $filename)
			{
					$this->helpers[] = "DateRangeFormat";
					$this->set(compact("what"));
					if($what!='schedule') $filename .= '_'.date('Y-d-m_His').'.pdf';
					switch($what)
					{
							case "participantsid":
							case "tablenametags":
							case "insurance":
									$this->Offering->OfferingParticipant->recursive = -1;
									$offerParticipants = $this->Offering->OfferingParticipant->find('all', array('joins'=>array(array('table'=>'people', 'alias'=>'Person', 'type'=>'LEFT', 'conditions'=>array('Person.id = OfferingParticipant.person_id')),
																																array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'LEFT', 'conditions'=>array('Offering.id = OfferingParticipant.offering_id')),
																																array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
																												 'fields'=>array('OfferingParticipant.fullname', 'Course.title', 'Offering.date_start', 'Offering.date_end'),
																												 'conditions'=>array('OfferingParticipant.offering_id'=>$id), 'order'=>array('OfferingParticipant.created'=>'ASC')));
									$this->set(compact('offerParticipants'));
									if($what=='insurance')
									{
											$this->layout = NULL;
											$base_URI = Router::url('/', true);
											$footer_URI = $base_URI.'offerings/pdfpart/all/footer'.'/'.$id;
											$this->pdfConfig = array('options'=>array('footer-html'=>$footer_URI, 'dpi'=>96), 'margin'=>array('bottom'=>30,'left'=>10,'right'=>10,'top'=>10), 'orientation'=>'portrait', 'filename'=>$filename);
									}
									else if($what=="participantsid")
									{
											$this->pdfConfig = array('options'=>array('dpi'=>96), 'margin'=>array('bottom'=>20,'left'=>10,'right'=>15,'top'=>20), 'orientation'=>($what=='participantsid'?'landscape':'portrait'), 'filename'=>$filename);
									}
									else $this->pdfConfig = array('options'=>array('dpi'=>96), 'margin'=>array('bottom'=>5,'left'=>5,'right'=>5,'top'=>5), 'orientation'=>($what=='participantsid'?'landscape':'portrait'), 'filename'=>$filename);
							break;

							case "registrationform":
									$this->Offering->recursive = -1;
									$offering = $this->Offering->find('all', array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
																	  'fields'=>array('Course.title', 'Offering.date_start', 'Offering.date_end'),
																	  'conditions'=>array('Offering.id'=>$id)));
									$this->set(compact('offering'));
									//--------
									$this->Offering->OfferInstructor->recursive = -1;
									$offerInstructors = $this->Offering->OfferInstructor->find('all', array('joins'=>array(array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = OfferInstructor.instructor_id'))),
																											'fields'=>array('OfferInstructor.fullname'),
																											'conditions'=>array('OfferInstructor.offering_id'=>$id),
																											'order'=>array('OfferInstructor.created'=>'ASC')));
									$this->set(compact('offerInstructors'));
									$this->pdfConfig = array('options'=>array('dpi'=>96), 'orientation' => 'portrait', 'filename' => $filename);
							break;

							case "attendancesheet":
							  	$this->layout = NULL;
									$this->Offering->OfferingParticipant->recursive = -1;
									$offerParticipants = $this->Offering->OfferingParticipant->find('all', array('joins'=>array(array('table'=>'people', 'alias'=>'Person', 'type'=>'LEFT', 'conditions'=>array('Person.id = OfferingParticipant.person_id'))),
																												 'fields'=>array('OfferingParticipant.fullname'),
																												 'conditions'=>array('OfferingParticipant.offering_id'=>$id), 'order'=>array('OfferingParticipant.fullname'=>'ASC')));
									$this->set(compact('offerParticipants'));
									//----
									$base_URI = Router::url('/', true);
									$header_URI = $base_URI.'offerings/pdfpart/attendancesheet/header'.'/'.$id;
									$footer_URI = $base_URI.'offerings/pdfpart/attendancesheet/footer'.'/'.$id;
									$this->pdfConfig = array('options'=>array('header-html'=>$header_URI, 'footer-html'=>$footer_URI, 'header-spacing'=>0, 'footer-spacing'=>2, 'dpi'=>96), 'margin'=>array('bottom'=>35,'left'=>8,'right'=>8,'top'=>55), 'orientation'=>'landscape', 'filename'=>$filename);
							break;

							case "schedule":
									if(!$this->request->is('post')):
											throw new NotFoundException(__('Training event(s) not found.'));
									endif;

									if(isset($this->request->data['date_start']) && isset($this->request->data['date_end'])):
											$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("instructor_names" => "(SELECT GROUP_CONCAT(CONCAT(SUBSTRING(Instructor.first_name, 1,1), '. ', Instructor.last_name) SEPARATOR ' / ') FROM offer_instructors AS OfferInstructor LEFT JOIN instructors AS Instructor ON Instructor.id = OfferInstructor.instructor_id WHERE OfferInstructor.offering_id = Offering.id GROUP BY OfferInstructor.offering_id)", "classroom_names" => "(SELECT GROUP_CONCAT(DISTINCT Classroom.name SEPARATOR ' / ') FROM offer_classrooms AS OfferClassroom LEFT JOIN classrooms AS Classroom ON Classroom.id = OfferClassroom.classroom_id WHERE OfferClassroom.offering_id = Offering.id GROUP BY OfferClassroom.offering_id)"));

											$_conditions = array("OR"=>array("(Offering.date_start BETWEEN '".$this->request->data['date_start']."' AND '".$this->request->data['date_end']."')",
																			 "(Offering.date_end BETWEEN '".$this->request->data['date_start']."' AND '".$this->request->data['date_end']."')"));
											if(isset($this->request->data['status']) && strtolower(trim($this->request->data['status']))!='all'):
												$_conditions = array_merge($_conditions, array("Offering.status"=>$this->request->data['status']));
											endif;

											$this->Offering->recursive = -1;
											$events = $this->Offering->find('all', array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
																						 'fields'=>array('Course.title', 'Offering.id', 'Offering.course_id', 'Offering.date_start', 'Offering.date_end', 'Offering.instructor_names', 'Offering.classroom_names'),
																						 'conditions'=>$_conditions,
																						 'order'=>array('Offering.date_start'=>'ASC')
																						)
																			);
									endif;

									if(!$events) throw new NotFoundException(__('Training event(s) not found.'));
									else
									{
											// Load the DateRangeFomatter Helper
											$view = new View($this);
											$dateFormatter = $view->loadHelper('DateRangeFormat');
											//----------------------------------

											$objPhpExcel = $this->Components->load('PhpExcel.PhpExcel');
											$objPhpExcel->createWorksheet()->setDefaultFont('Calibri', 11);

											$_all_border = array('allborders'=>array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')));
											$_bottom_border = array('bottom'=>array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')));
											$_outline_border = array('outline'=>array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')));
											$_horizontal_align_center = array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
											$_horizontal_align_right = array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
											$_horizontal_align_left = array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
											$_table_header_fill = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'DDEBF7'));
											$_column_header_fill = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '9BC2E6'));

											$_general_style = array('alignment' => array('vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP), 'borders' => $_all_border);
											$_header_style = array('font' => array('bold' => true), 'borders' => $_all_border, 'fill' => $_column_header_fill);

											$objPhpExcel->getProperties()->setCreator('Norbert Carpio')
																		 ->setLastModifiedBy('Norbert Carpio')
																		 ->setTitle("GMI - Training Administration System")
																		 ->setSubject("Event Schedules")
																		 ->setDescription("Event Schedules")
																		 ->setKeywords("Events")
																		 ->setCategory("Events");

											$objPhpExcel->setActiveSheetIndex(0)->setShowGridlines(false);
											$objPhpExcel->getActiveSheet()->setTitle('Event Schedule for Week 40');

											$iconDrawing = new PHPExcel_Worksheet_Drawing();
											$iconDrawing->setName('GigaMare Inc.');
											$iconDrawing->setDescription('GMI - Training Administration System');
											$iconDrawing->setPath('img/gmi/gigamare_mid_sm.jpg');
											$iconDrawing->setWidthAndHeight(123,98);
											$iconDrawing->setCoordinates('B2');
											$iconDrawing->setWorksheet($objPhpExcel->getActiveSheet());

											$objPhpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1.50);
											$objPhpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
											$objPhpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
											$objPhpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
											$objPhpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(26);
											$objPhpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(26);
											$objPhpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(23);
											$objPhpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(23);
											$objPhpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(19);
											$objPhpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(19);
											$objPhpExcel->getActiveSheet()->getColumnDimension('K')->setWidth(19);
											$objPhpExcel->getActiveSheet()->getColumnDimension('L')->setWidth(26);
											$objPhpExcel->getActiveSheet()->getColumnDimension('M')->setWidth(17);

											$objPhpExcel->getActiveSheet()->setCellValue('L2', 'List of Participants')
																	->mergeCells('L2:M2')
																	->getStyle('L2:M2')->applyFromArray(array('font'=>array('color'=>array('rgb'=>'A6A6A6'),'size'=>18, 'bold'=>true), 'alignment'=>$_horizontal_align_left));

											// ====================== Calculate Week Number ==========================
											$standard = "ISO-8601";
											$weekYear = "1 / ".date("Y");
											switch($standard)
											{
													case "ISO-8601":
                            $timestamp = $this->request->data['date_start'];
														$date = new DateTime($timestamp);
														$weekYear = $date->format("W / Y");
													break;

													default:
                            $timestamp = strtotime($this->request->data['date_start']);
														$sYear = date("Y", $timestamp);
														$add = date('N', strtotime($sYear."-01-01 00:00:00"));
														$week = ceil(((date('z', $timestamp)+$add)/7));
														$weekYear = ($week>9?"":"0").$week." / ".$sYear;
													break;
											}
											// ========================================================================

											$objPhpExcel->getActiveSheet()->setCellValue('E3', "Week ".$weekYear)
																		  ->mergeCells('E3:K3')
																		  ->getStyle('E3:K3')->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'size'=>16, 'bold'=>true), 'alignment'=>$_horizontal_align_center));

											$objPhpExcel->getActiveSheet()->setCellValue('L3', 'GigaMare Inc.')
																		  ->mergeCells('L3:M3')
																		  ->getStyle('L3:M3')->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'size'=>16, 'bold'=>true),
																													'alignment'=>$_horizontal_align_left, 'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'00B0F0'))));
											$_row_cntr = 7;
											$_starting_week = date("WY", strtotime($this->request->data['date_start']));
											foreach($events as $event)
											{
													$_starting_row_cntr = $_row_cntr;

													if($_starting_week!=date("WY", strtotime($event['Offering']['date_start'])))
													{
															$_row_cntr += 2;
															$_starting_row_cntr = $_row_cntr;
															$_starting_week = date("WY", strtotime($event['Offering']['date_start']));
															$objPhpExcel->getActiveSheet()->setCellValue('E'.(intval($_row_cntr)-3), date("\W\e\e\k W / Y", strtotime($event['Offering']['date_start'])))
																						  ->mergeCells('E'.(intval($_row_cntr)-3).':K'.(intval($_row_cntr)-3))
																						  ->getStyle('E'.(intval($_row_cntr)-3).':K'.(intval($_row_cntr)-3))->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'size'=>16,
																						  																										 'bold'=>true),
																						  																										 'alignment'=>$_horizontal_align_center));
													}

													$objPhpExcel->getActiveSheet()->setCellValue('B'.$_row_cntr, 'Course: ')
																				  ->mergeCells('B'.$_row_cntr.':C'.$_row_cntr)
																				  ->getStyle('B'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'alignment'=>$_horizontal_align_right));
													$objPhpExcel->getActiveSheet()->setCellValue('D'.$_row_cntr, $event['Course']['title'])
																				  ->mergeCells('D'.$_row_cntr.':F'.$_row_cntr)
																				  ->getStyle('D'.$_row_cntr.':F'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'borders'=>$_bottom_border));

													$objPhpExcel->getActiveSheet()->setCellValue('G'.$_row_cntr, 'Instructors: ')
																				  ->getStyle('G'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'alignment'=>$_horizontal_align_right));
													$objPhpExcel->getActiveSheet()->setCellValue('H'.$_row_cntr, $event['Offering']['instructor_names'])
																				  ->mergeCells('H'.$_row_cntr.':J'.$_row_cntr)
																				  ->getStyle('H'.$_row_cntr.':J'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'borders'=>$_bottom_border));

													$_row_cntr++;
													$objPhpExcel->getActiveSheet()->setCellValue('B'.$_row_cntr, 'Date: ')
																				  ->mergeCells('B'.$_row_cntr.':C'.$_row_cntr)
																				  ->getStyle('B'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'alignment'=>$_horizontal_align_right));
													$objPhpExcel->getActiveSheet()->setCellValue('D'.$_row_cntr, $dateFormatter->FormatDateRange(strtotime($event['Offering']['date_start']), strtotime($event['Offering']['date_end']), NULL, '-'))
																				  ->mergeCells('D'.$_row_cntr.':F'.$_row_cntr)
																				  ->getStyle('D'.$_row_cntr.':F'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'borders'=>$_bottom_border));

													$objPhpExcel->getActiveSheet()->setCellValue('G'.$_row_cntr, 'Classroom: ')
																				  ->getStyle('G'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true), 'alignment'=>$_horizontal_align_right));
													$objPhpExcel->getActiveSheet()->setCellValueExplicit('H'.$_row_cntr, $event['Offering']['classroom_names'])
																				  ->mergeCells('H'.$_row_cntr.':J'.$_row_cntr)
																				  ->getStyle('H'.$_row_cntr.':J'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'), 'bold'=>true), 'alignment'=>$_horizontal_align_left, 'borders'=>$_bottom_border));

													$_row_cntr++;
													$objPhpExcel->getActiveSheet()->getRowDimension($_row_cntr)->setRowHeight(11);

													$_row_cntr++;
													$objPhpExcel->getActiveSheet()->getStyle('B'.$_starting_row_cntr.':M'.$_row_cntr)->applyFromArray(array('fill' => $_table_header_fill));

													$objPhpExcel->getActiveSheet()->setCellValue('G'.$_row_cntr, 'Transportation Arrangement')
																				  ->mergeCells('G'.$_row_cntr.':H'.$_row_cntr)
																				  ->getStyle('G'.$_row_cntr.':H'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'), 'bold'=>true),
																																				   'alignment'=>$_horizontal_align_center, 'borders' => $_all_border, 'fill' => $_column_header_fill));

													$objPhpExcel->getActiveSheet()->setCellValue('I'.$_row_cntr, 'Hotel Arrangement')
																				  ->mergeCells('I'.$_row_cntr.':K'.$_row_cntr)
																				  ->getStyle('I'.$_row_cntr.':K'.$_row_cntr)->applyFromArray(array('font'=>array('color'=>array('rgb'=>'000000'),'bold'=>true),
																																				   'alignment'=>$_horizontal_align_center, 'borders' => $_all_border, 'fill' => $_column_header_fill));

													$_row_cntr++;
													$objPhpExcel->getActiveSheet()->setCellValue('B'.$_row_cntr, '#')
																				  ->setCellValue('C'.$_row_cntr, 'Participants Name')
																				  ->setCellValue('E'.$_row_cntr, 'Rank (pre-requisite check)')
																				  ->setCellValue('F'.$_row_cntr, 'Company Name')
																				  ->setCellValue('G'.$_row_cntr, 'Provider')
																				  ->setCellValue('H'.$_row_cntr, 'Arrangement')
																				  ->setCellValue('I'.$_row_cntr, 'Hotel Name')
																				  ->setCellValue('J'.$_row_cntr, 'Room Type')
																				  ->setCellValue('K'.$_row_cntr, 'Period of Stay')
																				  ->setCellValue('L'.$_row_cntr, 'Meal Arrangement')
																				  ->setCellValue('M'.$_row_cntr, 'SO / Analytic')
																				  ->mergeCells('C'.$_row_cntr.':D'.$_row_cntr);

													$objPhpExcel->getActiveSheet()->getStyle('B'.$_row_cntr.':M'.$_row_cntr)->applyFromArray($_header_style);

													$this->Offering->OfferingParticipant->recursive = -1;
													$eventParticipants = $this->Offering->OfferingParticipant->find('all', array('joins'=>array(array('table'=>'people', 'alias'=>'Person', 'type'=>'LEFT', 'conditions'=>array('Person.id = OfferingParticipant.person_id')),
																																				array('table'=>'customers', 'alias'=>'Customer', 'type'=>'LEFT', 'conditions'=>array('Customer.id = Person.customer_id')),
																																				array('table'=>'ranks', 'alias'=>'Rank', 'type'=>'LEFT', 'conditions'=>array('Rank.id = Person.rank_id'))),
																																 'fields'=>array('OfferingParticipant.fullname', 'Rank.name', 'Customer.name', 'OfferingParticipant.transport_provider',
																																 				 'OfferingParticipant.transport_arrangement', 'OfferingParticipant.hotel_name', 'OfferingParticipant.hotel_room_type',
																																				 'OfferingParticipant.hotel_period_of_stay', 'OfferingParticipant.meal_arrangement', 'OfferingParticipant.sales_order_no'),
																																 'conditions'=>array('OfferingParticipant.offering_id'=>$event['Offering']['id']),
																																 'order'=>array('OfferingParticipant.fullname'=>'ASC')));

													$_last_row_cnt = $_row_cntr;
													$_participant_cntr = 0;
													foreach($eventParticipants as $participant):
														$_row_cntr++;
														$_participant_cntr++;
														$objPhpExcel->getActiveSheet()->setCellValue('B'.$_row_cntr, $_participant_cntr)
																					  ->setCellValue('C'.$_row_cntr, $participant['OfferingParticipant']['fullname'])
																					  ->setCellValue('E'.$_row_cntr, $participant['Rank']['name'])
																					  ->setCellValue('F'.$_row_cntr, $participant['Customer']['name'])
																					  ->setCellValue('G'.$_row_cntr, $participant['OfferingParticipant']['transport_provider'])
																					  ->setCellValue('H'.$_row_cntr, $participant['OfferingParticipant']['transport_arrangement'])
																					  ->setCellValue('I'.$_row_cntr, $participant['OfferingParticipant']['hotel_name'])
																					  ->setCellValue('J'.$_row_cntr, $participant['OfferingParticipant']['hotel_room_type'])
																					  ->setCellValue('K'.$_row_cntr, $participant['OfferingParticipant']['hotel_period_of_stay'])
																					  ->setCellValue('L'.$_row_cntr, $participant['OfferingParticipant']['meal_arrangement'])
																					  ->setCellValue('M'.$_row_cntr, $participant['OfferingParticipant']['sales_order_no'])
																					  ->mergeCells('C'.$_row_cntr.':D'.$_row_cntr);
													endforeach;
													$objPhpExcel->getActiveSheet()->getStyle('B'.$_last_row_cnt.':B'.$_row_cntr)->applyFromArray(array('alignment'=>$_horizontal_align_center));
													$objPhpExcel->getActiveSheet()->getStyle('M'.$_last_row_cnt.':M'.$_row_cntr)->applyFromArray(array('alignment'=>$_horizontal_align_center));
													$objPhpExcel->getActiveSheet()->getStyle('B'.$_last_row_cnt.':M'.$_row_cntr)->applyFromArray(array('borders' => $_all_border));
													$objPhpExcel->getActiveSheet()->getStyle('B'.$_starting_row_cntr.':M'.$_row_cntr)->applyFromArray(array('borders' => $_outline_border));

													$_row_cntr += 4;
											}

											$objPhpExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
											$objPhpExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
											$objPhpExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
											$objPhpExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
											$objPhpExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

											$objPhpExcel->output($filename);
									}
							break;

							default:
									throw new NotFoundException(__('Invalid URL'));
							break;
					}
			}

			public function pdfpart($for, $what, $id)
			{
					$this->layout = NULL;

					switch($for)
					{
						case "all":
						break;

						default:
							$this->Offering->recursive = -1;
							$offering = $this->Offering->find('all', array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
															  'fields'=>array('Course.title', 'Offering.date_start', 'Offering.date_end'),
															  'conditions'=>array('Offering.id'=>$id)));
							$this->set(compact('offering'));
							//--------
							$this->Offering->OfferInstructor->recursive = -1;
							$offerInstructors = $this->Offering->OfferInstructor->find('all', array('joins'=>array(array('table'=>'instructors', 'alias'=>'Instructor', 'type'=>'LEFT', 'conditions'=>array('Instructor.id = OfferInstructor.instructor_id'))),
																									'fields'=>array('OfferInstructor.fullname'),
																									'conditions'=>array('OfferInstructor.offering_id'=>$id),
																									'order'=>array('OfferInstructor.created'=>'ASC')));
							$this->set(compact('offerInstructors'));
							//--------
						break;
					}

					$this->set(compact("for"));
					$this->set(compact("what"));
			}

			public function schedule($event_status='all', $date_start=NULL, $date_end=NULL)
			{
					if(!empty($date_start) && $this->validateDate($date_start)):

							$date_end = (!empty($date_end)?$date_end:$date_start);

							if($this->validateDate($date_end)):
								if(strtotime($date_start) <= strtotime($date_end)):
										$_conditions = array("OR"=>array("(Offering.date_start BETWEEN '".$date_start."' AND '".$date_end."')", "(Offering.date_end BETWEEN '".$date_start."' AND '".$date_end."')"));
										if(isset($event_status) && strtolower(trim($event_status))!='all'):
												$_conditions = array_merge($_conditions, array("Offering.status"=>$event_status));
										endif;

										$this->Offering->recursive = -1;
										$events = $this->Offering->find('all', array('joins'=>array(array('table'=>'courses', 'alias'=>'Course', 'type'=>'LEFT', 'conditions'=>array('Course.id = Offering.course_id'))),
																					 'fields'=>array('Course.title', 'Offering.id', 'Offering.course_id', 'Offering.status', 'Offering.date_start', 'Offering.date_end', 'Offering.number_of_participants'),
																					 'conditions'=>$_conditions,
																					 'order'=>array('Offering.date_start'=>'ASC')
																					)
																		);
										$this->set(compact("events"));
								else:
										$this->Session->setFlash('URL not found: End date is invalid.');
								endif;

							else:
									$this->Session->setFlash('URL not found: Please make sure the end date is properly formatted.');
							endif;

					endif;
					$statuses = array('For Confirmation', 'Confirmed', 'Delivered', 'Invoiced', 'Cancelled');
					$this->set(compact(array("event_status", "date_start", "date_end", "statuses")));
			}

			private function validateDate($date, $format = 'Y-m-d')
			{
					$d = DateTime::createFromFormat($format, $date);
					return $d && $d->format($format) == $date;
			}
	}
