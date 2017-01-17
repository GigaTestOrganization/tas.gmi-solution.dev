<?php
	class ReportsController extends AppController
	{
			var $uses = false;
			public $components = array('RequestHandler');

			public function beforeFilter()
			{
					$this->Auth->allow(array('download', 'pdfpart'));
			}

			public function isAuthorized($user)
			{
			    if(in_array(trim($user['role']), array('sales', 'registrar', 'instructor')))
					{
						return true;
					}

			    return parent::isAuthorized($user);
			}

			public function index()
			{
					$this->redirect(array("action" => "training_summary"));
			}

			public function training_summary($course_id=NULL, $year=NULL)
			{
					if($course_id!=NULL || $year!=NULL)
					{
							$this->helpers[] = "DateRangeFormat";
							$this->loadModel('Offering');

							if($course_id!=NULL && is_numeric($course_id) && !$this->Offering->exists($course_id)) throw new NotFoundException(__('Invalid Course! No report could be generated.'));

							$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("instructor_names" => "(SELECT GROUP_CONCAT(CONCAT(SUBSTRING(Instructor.first_name, 1,1), '. ', Instructor.last_name) SEPARATOR ' / ') FROM offer_instructors AS OfferInstructor LEFT JOIN instructors AS Instructor ON Instructor.id = OfferInstructor.instructor_id WHERE OfferInstructor.offering_id = Offering.id GROUP BY OfferInstructor.offering_id)", "number_of_days" => "(DATEDIFF(Offering.date_end, Offering.date_start)+1)", "company_names" => "(SELECT GROUP_CONCAT(DISTINCT Customer.name SEPARATOR ' / ') FROM offering_participants AS OfferingParticipant LEFT JOIN people AS Person ON OfferingParticipant.person_id = Person.id LEFT JOIN customers AS Customer ON Customer.id = Person.customer_id WHERE OfferingParticipant.offering_id = Offering.id GROUP BY OfferingParticipant.offering_id)", "course_name" => "(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)", "course_code" => "(SELECT Course.code FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)"));

							$this->Offering->virtualFields["course_man_days"] = "(".$this->Offering->virtualFields["number_of_participants"]."*".$this->Offering->virtualFields["number_of_days"].")";

							//Conditions
							$conditions = array('Offering.status' => array('2','3'), 'Offering.number_of_participants > ' => 0);
							if($course_id!=NULL && trim($course_id)!='year')
							{
								$conditions = array_merge($conditions, array("Offering.course_id" => $course_id));
								$this->set(compact('course_id'));
							}
							if($year!=NULL)
							{
								$conditions = array_merge($conditions, array("YEAR(Offering.date_start)" => $year));
								$this->set(compact('year'));
							}

							$trainings = $this->Offering->find('all', array('fields' => array('Offering.id', 'Offering.course_id', 'Offering.course_code', 'Offering.course_name', 'Offering.code AS offer_code', 'Offering.date_start', 'Offering.date_end', 'Offering.number_of_days', 'Offering.instructor_names', 'Offering.number_of_participants', 'Offering.company_names', 'Offering.course_man_days'), 'conditions' => $conditions, 'recursive' => -1));
							$this->set(compact('trainings'));
					}
			}

			public function course_man_days($month_range=NULL, $year=NULL, $method="")
			{
					if($month_range!=NULL || $year!=NULL)
					{
							// Load Model Offering
							$this->loadModel('Offering');

							// =========== Construct virtual fields ===========
							$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("number_of_days" => "(DATEDIFF(Offering.date_end, Offering.date_start)+1)", "course_code" => "(SELECT Course.code FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)", "course_name"=>"(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)"));

							$this->Offering->virtualFields["course_man_days"] = "SUM(".$this->Offering->virtualFields["number_of_participants"]."*".$this->Offering->virtualFields["number_of_days"].")";
							// ================================================

							// ============ Construct the query conditions ============
							$conditions = array('Offering.status'=>array('2','3'), 'Offering.number_of_participants > '=>0);

							$mstart = 1;
							$mend = 12;
							if($month_range!=NULL && trim($month_range)!='year' && strpos($month_range, "-")!==false)
							{
									$m_r = explode("-", $month_range);
									$from_month = trim($m_r[0]);
									$to_month = trim($m_r[1]);
									if(intval($from_month)<=intval($to_month) && intval($to_month)<=12)
									{
											$conditions = array_merge($conditions, array("MONTH(Offering.date_start) BETWEEN ? and ?"=>array($from_month, $to_month)));
											$this->request->data['FromMonth'] = $mstart = $from_month;
											$this->request->data['ToMonth'] = $mend = $to_month;
									}
									$this->set(compact('month_range'));
							}

							if($year!=NULL)
							{
									$conditions = array_merge($conditions, array("YEAR(Offering.date_start)"=>$year));
									$this->request->data['year'] = $year;
									$this->set(compact('year'));
							}
							// ============================== //

							// Collect Traing Summary
							$trainings = $this->Offering->find('all', array('fields'=>array('Offering.course_code', 'Offering.course_name', 'Offering.date_start', 'Offering.course_man_days'),
																															'conditions'=>$conditions,
																															'group'=>array('YEAR(Offering.date_start)', 'MONTH(Offering.date_start)', 'Offering.course_id'),
																															'order'=>'YEAR(Offering.date_start) DESC',
																															'recursive' => -1
																														 )
																								);

							// ================= Reformat Query Result ====================
							if(strpos($method, "json-")!==false)
							{
									$type = explode("-", $method);
									$data = "";
									$new_df = "";
									if($type[1]==="permonth")
									{
											foreach($trainings as $training):

													if(!isset($data[date('M', strtotime($training['Offering']['date_start']))])) $data[date('M', strtotime($training['Offering']['date_start']))] = 0;
													$data[date('M', strtotime($training['Offering']['date_start']))] += intval($training['Offering']['course_man_days']);

											endforeach;

											foreach($data as $month => $value): $new_df[] = array("month"=>$month, "value"=>$value); endforeach;
									}

									if($type[1]==="percourse")
									{
											foreach($trainings as $training):

												if(!isset($data[$training['Offering']['course_code']])) $data[$training['Offering']['course_code']]["course_man_days"] = 0;
												$data[$training['Offering']['course_code']]["course_man_days"] += intval($training['Offering']['course_man_days']);
												$data[$training['Offering']['course_code']]["course_name"] = $training['Offering']['course_name'];

											endforeach;

											foreach($data as $course => $value): $new_df[] = array("course"=>$course, "value"=>$value['course_man_days'], "course_name"=>$value['course_name']); endforeach;
									}

									$data = $new_df;
									$this->layout = NULL;
									$this->set(compact('data'));
									$this->render('/Elements/json');
							}
							else
							{
									$course_summary = array();

									foreach($trainings as $training):

											$course_summary[date('Y', strtotime($training['Offering']['date_start']))]['annual'][$training['Offering']['course_code']]['course_name'] = $training['Offering']['course_name'];

											if(!isset($course_summary[date('Y', strtotime($training['Offering']['date_start']))]['annual'][$training['Offering']['course_code']]['annual_course_man_days']))
													$course_summary[date('Y', strtotime($training['Offering']['date_start']))]['annual'][$training['Offering']['course_code']]['annual_course_man_days'] = 0;
											$course_summary[date('Y', strtotime($training['Offering']['date_start']))]['annual'][$training['Offering']['course_code']]['annual_course_man_days'] += intval($training['Offering']['course_man_days']);

											if(!isset($course_summary[date('Y', strtotime($training['Offering']['date_start']))]['monthly'][date('n', strtotime($training['Offering']['date_start']))]['all_course_monthly_man_days']))
													$course_summary[date('Y', strtotime($training['Offering']['date_start']))]['monthly'][date('n', strtotime($training['Offering']['date_start']))]['all_course_monthly_man_days'] = 0;
											$course_summary[date('Y', strtotime($training['Offering']['date_start']))]['monthly'][date('n', strtotime($training['Offering']['date_start']))]['all_course_monthly_man_days'] += intval($training['Offering']['course_man_days']);

											$course_summary[date('Y', strtotime($training['Offering']['date_start']))]['annual'][$training['Offering']['course_code']][date('n', strtotime($training['Offering']['date_start']))] = $training['Offering'];

									endforeach;

									$this->set(compact('course_summary'));
							}
							// ============================================================

							$this->set(compact('mstart', 'mend'));
					}

					$months = array(1=>"Jan", 2=>"Feb", 3=>"Mar", 4=>"Apr", 5=>"May", 6=>"Jun", 7=>"Jul", 8=>"Aug", 9=>"Sep", 10=>"Oct", 11=>"Nov", 12=>"Dec");
					$this->set(compact('months', 'mstart', 'mend'));
			}

			public function course_summary($course_id=NULL, $year=NULL, $method="")
			{
					if($course_id!=NULL || $year!=NULL)
					{
							// ======= Load model Offering =============
							$this->loadModel('Offering');

							// ========= Construct virtual fields =====
							$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("number_of_days" => "(DATEDIFF(Offering.date_end, Offering.date_start)+1)", "course_name" => "(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)", "course_code" => "(SELECT Course.code FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)"));

							$this->Offering->virtualFields["course_man_days"] = "(".$this->Offering->virtualFields["number_of_participants"]."*".$this->Offering->virtualFields["number_of_days"].")";
							// ========================================

							// ====== Construct query conditions ======
							$conditions = array('Offering.status' => array('2','3'), 'Offering.number_of_participants > ' => 0);

							if($course_id!=NULL && !in_array(trim($course_id), array('course', 'year')))
							{
									$conditions = array_merge($conditions, array("Offering.course_id" => $course_id));
									$this->set(compact('course_id'));
							}

							if($year!=NULL && trim($year)!='year')
							{
									$conditions = array_merge($conditions, array("YEAR(Offering.date_start)" => $year));
									$this->set(compact('year'));
							}
							// =========================================

							// ======== Collect course summary =========
							$trainings = $this->Offering->find('all', array('fields'=>array('Offering.course_id', 'Offering.course_code', 'Offering.course_name', 'Offering.number_of_days', 'Offering.number_of_participants', 'Offering.course_man_days'),
																															'conditions'=>$conditions,
																															'recursive'=>-1));
							// =========================================

							// ======== Reformat query result ==========
							$courses_summary = array();
							foreach($trainings as $training):
									if(!isset($courses_summary[$training['Offering']['course_id']]['course_name']))
											$courses_summary[$training['Offering']['course_id']]['course_name'] = $training['Offering']['course_name'];

									if(!isset($courses_summary[$training['Offering']['course_id']]['course_code']))
											$courses_summary[$training['Offering']['course_id']]['course_code'] = $training['Offering']['course_code'];

									if(!isset($courses_summary[$training['Offering']['course_id']]['number_of_participants']))
											$courses_summary[$training['Offering']['course_id']]['number_of_participants'] = 0;
									$courses_summary[$training['Offering']['course_id']]['number_of_participants'] += intval($training['Offering']['number_of_participants']);

									if(!isset($courses_summary[$training['Offering']['course_id']]['number_of_days']))
											$courses_summary[$training['Offering']['course_id']]['number_of_days'] = 0;
									$courses_summary[$training['Offering']['course_id']]['number_of_days'] += intval($training['Offering']['number_of_days']);

									if(!isset($courses_summary[$training['Offering']['course_id']]['course_man_days']))
											$courses_summary[$training['Offering']['course_id']]['course_man_days'] = 0;
									$courses_summary[$training['Offering']['course_id']]['course_man_days'] += intval($training['Offering']['course_man_days']);
							endforeach;

							if($method=='json'):
									foreach($courses_summary as $summary): $new_df[] = $summary; endforeach;
									$data = $new_df;
									$this->layout = NULL;
									$this->set(compact('data'));
									$this->render('/Elements/json');
							else:
									$this->set(compact('courses_summary'));
							endif;
							// ========================================
					}
			}

			public function company_participants($year=NULL, $customer_id=NULL, $method="")
			{
					// ===== Load Model Customer =====
					$this->loadModel('Customer');

					if($year!=NULL || $customer_id!=NULL)
					{
							// ===== Construct virtual fields =====
							$this->Customer->virtualFields = array("nop"=>"COUNT(OfferingParticipant.person_id)");

							// ======= Construct query conditions ======
							$conditions = array("Offering.status"=>array('2', '3'));

							if($year!=NULL && is_numeric($year))
							{
									$conditions = array_merge($conditions, array("YEAR(Offering.date_start)" => $year));
									$this->set(compact('year'));
							}

							if($customer_id!=NULL && is_numeric($customer_id))
							{
									$conditions = array_merge($conditions, array("Customer.id" => $customer_id));
									$this->set(compact('customer_id'));
							}
							// =========================================

							// ============= Collect company participants ================
							$nopPerCustomer = $this->Customer->find("all", array("joins"=>array(array('table'=>'people', 'alias'=>'Person', 'type'=>'LEFT', 'conditions'=>array('Person.customer_id = Customer.id')),
																																									array('table'=>'offering_participants', 'alias'=>'OfferingParticipant', 'type'=>'LEFT', 'conditions'=>array('OfferingParticipant.person_id = Person.id')),
																																									array('table'=>'offerings', 'alias'=>'Offering', 'type'=>'LEFT', 'conditions'=>array('Offering.id = OfferingParticipant.offering_id'))),
																																	 "fields"=>array("Customer.name", "Customer.nop"),
																																	 "conditions"=>$conditions,
																																	 "group"=>array("Customer.id"),
																																	 "order"=>array("Customer.nop"=>"DESC"),
																																	 "recursive"=>-1)
																											);
							// ===========================================================

							// ================ Reformat query result ====================
							if($method=='json')
							{
									foreach($nopPerCustomer as $customer)
									{
											if(intval($customer['Customer']['nop'])>0)
											{
													$data[] = array("name"=>$customer['Customer']['name'],"nop"=>$customer['Customer']['nop']);
											}
									}
									$this->layout = NULL;
									$this->set(compact('data'));
									$this->render('/Elements/json');
							}
							else
							{
									$this->set(compact("nopPerCustomer"));
							}
							// ==========================================================
					}

					// ==================== Collect customer list ===================
					$customers = $this->Customer->find('list', array("fields"=>array("Customer.id", "Customer.name"), "recursive"=>-1));
					$this->set(compact('customers'));
					// ==============================================================
			}

			public function statistics_report($type="participants", $from_year=NULL, $to_year=NULL, $method="")
			{
					// ============== Report Type ================
					$_report_type = array("participants"=>"CUMULATIVE PARTICIPANTS", "course_man_days"=>"CUMULATIVE COURSE MAN DAYS", "monthly_participants"=>"MONTHLY PARTICIPANTS");

					if(!array_key_exists($type, $_report_type)) throw new NotFoundException(__('Page could not be found!'));

					$from_year = ($from_year==NULL?date('Y'):$from_year);
					$to_year = ($to_year==NULL?date('Y'):$to_year);

					// ========= Load the requested report =========
					switch($type):
						default:
						case "participants":
							$data = $this->cumulativeParticipants($from_year, $to_year);
						break;

						case "course_man_days":
							$data = $this->cumulativeCourseManDays($from_year, $to_year);
						break;

						case "monthly_participants":
							$data = $this->participantsOverMonths($from_year, $to_year);
						break;
					endswitch;
					// ==============================================

					// ========= Parse data into JSON format ========
					if($method=='json'):
						$this->layout = NULL;
						$this->set(compact('data'));
						$this->render('/Elements/json');
					else:
						$this->set(compact(array("_report_type", "type", 'from_year', 'to_year', 'data')));
					endif;
					// ==============================================
			}

			private function cumulativeParticipants($from_year, $to_year)
			{
					// ============ Load Model Offering ============
					$this->loadModel('Offering');

					// ========== Construct virtual fields =========
					$this->Offering->virtualFields["cumulative_participants"] = "SUM(".$this->Offering->virtualFields["number_of_participants"].")";
					$this->Offering->virtualFields["year_month"] = "DATE_FORMAT(Offering.date_start, '%Y-%m')";

					// ========== Construct query conditions =======
					$conditions = array('Offering.status' => array('2','3'), 'Offering.number_of_participants > ' => 0, 'YEAR(Offering.date_start) BETWEEN ? AND ?'=>array($from_year, $to_year));

					// ======= Collect cumulative participats ===================
					$statistics_report = $this->Offering->find('all', array('fields'=>array('Offering.year_month', 'YEAR(Offering.date_start) AS year', 'Offering.cumulative_participants'),
																																	'conditions'=>$conditions,
																																	'group'=>array('YEAR(Offering.date_start)', 'MONTH(Offering.date_start)'),
																																	'order'=>array("YEAR(Offering.date_start)"=>"ASC", "MONTH(Offering.date_start)"=>"ASC"),
																																	'recursive' => -1));
					// ==========================================================

					// ================== Reformat query result =================
					$data = NULL;
					if($statistics_report):
						foreach($statistics_report as $statistic):
							if(!isset($cumulative[$statistic[0]['year']])) $cumulative[$statistic[0]['year']] = 0;
							if(!isset($cumulative['runningaverage'])) $cumulative['runningaverage'] = 0;
							if(!isset($cumulative['runningmonths'])) $cumulative['runningmonths'] = 0;
							$cumulative[$statistic[0]['year']] += $statistic['Offering']['cumulative_participants'];
							$cumulative['runningaverage'] += $statistic['Offering']['cumulative_participants'];
							$cumulative['runningmonths'] += 1;
							$nop = $statistic['Offering']['cumulative_participants'];
							$mma = ceil($cumulative['runningaverage']/$cumulative['runningmonths']);
							$cpy = $cumulative[$statistic[0]['year']];
							$data[] = array("dates"=>$statistic['Offering']['year_month'], "nop"=>$nop, "mma"=>$mma, "cpy"=>$cpy);
						endforeach;
					endif;
					// ===========================================================

					return $data;
			}

			private function cumulativeCourseManDays($from_year, $to_year)
			{
					// ============ Load Model Offering ============
					$this->loadModel('Offering');

					// ========== Construct virtual fields =========
					$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("number_of_days" => "(DATEDIFF(Offering.date_end, Offering.date_start)+1)"));
					$this->Offering->virtualFields["course_man_days"] = "SUM(".$this->Offering->virtualFields["number_of_participants"]."*".$this->Offering->virtualFields["number_of_days"].")";
					$this->Offering->virtualFields["year_month"] = "DATE_FORMAT(Offering.date_start, '%Y-%m')";

					// ========== Construct query conditions =======
					$conditions = array('Offering.status' => array('2','3'), 'YEAR(Offering.date_start) BETWEEN ? AND ?'=>array($from_year, $to_year));

					// ======= Collect cumulative participats ===================
					$statistics_report = $this->Offering->find('all', array('fields'=>array('Offering.year_month', 'YEAR(Offering.date_start) AS year', 'MONTH(Offering.date_start) AS month', 'Offering.course_man_days'),
																																	'conditions'=>$conditions,
																																	'group'=>array('YEAR(Offering.date_start)', 'MONTH(Offering.date_start)'),
																																	'order'=>array("YEAR(Offering.date_start)"=>"ASC",
																																	"MONTH(Offering.date_start)"=>"ASC"),
																																	'recursive' => -1));
					// ==========================================================

					// ================== Reformat query result =================
					$data = NULL;
					if($statistics_report):
						foreach($statistics_report as $statistic):
							if(!isset($cumulative[$statistic[0]['year']])) $cumulative[$statistic[0]['year']] = 0;
							if(!isset($cumulative['runningaverage'])) $cumulative['runningaverage'] = 0;
							if(!isset($cumulative['runningmonths'])) $cumulative['runningmonths'] = 0;
							$cumulative[$statistic[0]['year']] += $statistic['Offering']['course_man_days'];
							$cumulative['runningaverage'] += $statistic['Offering']['course_man_days'];
							$cumulative['runningmonths'] += 1;

							$cmd = $statistic['Offering']['course_man_days'];
							$mma = ceil($cumulative['runningaverage']/$cumulative['runningmonths']);
							$ccmdpy = $cumulative[$statistic[0]['year']];
							$data[] = array("dates"=>$statistic['Offering']['year_month'], "cmd"=>$cmd, "mma"=>$mma, "ccmdpy"=>$ccmdpy);
						endforeach;
					endif;
					// ===========================================================

					return $data;
			}

			private function participantsOverMonths($from_year, $to_year)
			{
					// ============ Load Model Offering ============
					$this->loadModel('Offering');

					// ========== Construct virtual fields =========
					$this->Offering->virtualFields["total_participants"] = "SUM(".$this->Offering->virtualFields["number_of_participants"].")";
					$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("year"=>"YEAR(Offering.date_start)", "month"=>"DATE_FORMAT(Offering.date_start, '%m')", "year_month"=>"DATE_FORMAT(Offering.date_start, '%Y-%m')"));

					// ========== Construct query conditions =======
					$conditions = array('Offering.status' => array('2','3'), 'Offering.number_of_participants > ' => 0, 'YEAR(Offering.date_start) BETWEEN ? AND ?'=>array($from_year, $to_year));

					// ======= Collect cumulative participats ===================
					$statistics_report = $this->Offering->find('all', array('fields'=>array('Offering.year', 'Offering.month', 'Offering.year_month', 'Offering.total_participants'),
																																	'conditions'=>$conditions,
																																	'group'=>array('YEAR(Offering.date_start)', 'MONTH(Offering.date_start)'),
																																	'order'=>array("YEAR(Offering.date_start)"=>"ASC", "MONTH(Offering.date_start)"=>"ASC"),
																																	'recursive' => -1));
					// ==========================================================

					// ================== Reformat query result =================
					$data = NULL;
					if($statistics_report):
						$temp = "";
						foreach($statistics_report as $statistic):
							$temp[$statistic['Offering']['month']][$statistic['Offering']['year']] = $statistic['Offering']['total_participants'];
						endforeach;

						foreach($temp as $key => $tmp):
							$yr = "";
							$yr["months"] = $key;
							foreach($tmp as $year => $tp):
								$yr[$year] = $tp;
							endforeach;
							$data[] = $yr;
						endforeach;
					endif;
					// ===========================================================

					return $data;
			}

			public function training_report($start_date=NULL, $end_date=NULL)
			{
				$this->loadModel('Offering');
				$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("number_of_days" => "(DATEDIFF(Offering.date_end, Offering.date_start)+1)", "course_name" => "(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)", "course_code" => "(SELECT Course.code FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)"));
				$this->Offering->virtualFields["course_man_days"] = "(".$this->Offering->virtualFields["number_of_participants"]."*".$this->Offering->virtualFields["number_of_days"].")";

				if($start_date!=NULL):

					if($end_date==NULL || trim($end_date)=='') $end_date = $start_date;

					$conditions = array("Offering.date_start >= STR_TO_DATE('".$start_date." 00:00:00', '%Y-%m-%d %H:%i:%s')", "Offering.date_end <= STR_TO_DATE('".$end_date." 00:00:00', '%Y-%m-%d %H:%i:%s')");

					$trainings = $this->Offering->find('all', array('fields' => array('Offering.id', 'Offering.course_id', 'Offering.course_code', 'Offering.course_name', 'Offering.date_start', 'Offering.date_end', 'Offering.number_of_days', 'Offering.number_of_participants', 'Offering.course_man_days', 'Offering.status'), 'conditions' => $conditions, 'recursive' => -1));
					$this->set(compact('start_date', 'end_date', 'trainings'));

				endif;

				$this->set('statuses', array('For Confirmation', 'Confirmed', 'Delivered', 'Invoiced', 'Cancelled'));
			}

			public function download($what, $start_date=NULL, $end_date=NULL)
			{
					switch($what):
							case "training_report":
									$this->layout = NULL;
									$this->loadModel('Offering');
									$this->Offering->virtualFields = array_merge($this->Offering->virtualFields, array("number_of_days"=>"(DATEDIFF(Offering.date_end, Offering.date_start)+1)",
																																																		 "course_name"=>"(SELECT Course.title FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)",
																																																		 "course_code"=>"(SELECT Course.code FROM courses AS Course WHERE Course.id = Offering.course_id LIMIT 1)"));
									$this->Offering->virtualFields["course_man_days"] = "(".$this->Offering->virtualFields["number_of_participants"]."*".$this->Offering->virtualFields["number_of_days"].")";

									$statuses = array('For Confirmation', 'Confirmed', 'Delivered', 'Invoiced', 'Cancelled');

									if($start_date!=NULL):
											if($end_date==NULL || trim($end_date)=='') $end_date = $start_date;

											$conditions = array("Offering.date_start >= STR_TO_DATE('".$start_date." 00:00:00', '%Y-%m-%d %H:%i:%s')", "Offering.date_end <= STR_TO_DATE('".$end_date." 00:00:00', '%Y-%m-%d %H:%i:%s')");

											$trainings = $this->Offering->find('all', array('fields'=>array('Offering.id', 'Offering.course_code', 'Offering.course_name', 'Offering.date_start', 'Offering.date_end',
																																											'Offering.number_of_days', 'Offering.number_of_participants', 'Offering.course_man_days', 'Offering.status'),
																																			'conditions'=>$conditions,
																																			'recursive' => -1));

											$this->set(compact('start_date', 'end_date', 'trainings', 'statuses'));


											$filename = 'Training_Monthly_Report_'.$start_date.'_'.$end_date.'.pdf';
											$base_URI = Router::url('/', true);
											$footer_URI = $base_URI.'reports/pdfpart/'.$what.'/footer';
											$this->pdfConfig = array('options'=>array('footer-html'=>$footer_URI, 'dpi'=>720), 'margin'=>array('bottom'=>30,'left'=>10,'right'=>10,'top'=>10), 'orientation'=>'portrait', 'filename'=>$filename);
									else:
											throw new NotFoundException(__('Report not found.'));
									endif;

							break;

							default:
									throw new NotFoundException(__('Invalid URL'));
							break;

					endswitch;
			}

			public function pdfpart($for, $what)
			{
					$this->layout = NULL;
					$this->set(compact("for"));
					$this->set(compact("what"));
			}
	}
?>
