<div class="page-header">
    <h3 class="text-default">
      <small>[ <?php echo $course['Course']['code']; ?> ]</small> <?php echo $course['Course']['title']; ?>
      <small class="pull-right">
          <a class="btn btn-sm btn-success" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'download', 'specification', $course['Course']['id'], iconv('utf-8', 'us-ascii//TRANSLIT', $course['Course']['title']).'.pdf')); ?>"><i class="glyphicon glyphicon-download-alt"></i> Download</a>
          <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'edit', $course['Course']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
          <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'/')); ?>"><i class="fa fa-times"></i> Close</a>
      </small>
    </h3>
</div>
<div class="box">
    <div class="row">
				<div class="col-lg-offset-1 col-lg-10">
				  	<div class="col-lg-6">
				  	  	<img src="/img/gmi/gigamare.jpg" border="0" height="90" width="108"/>
				  	</div>
				  	<div class="col-lg-6">
								<h1 class="pull-right text-info" style="margin-top:50px;">Course Specification</h1>
						</div>

            <div class="clearfix"></div>

						<div class="page-header">
								<h4 class="text-default">
										<small class="pull-right" style="font-size:10px !important;margin-top:23px;">Author: <?php echo $course['Course']['author']; ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Revision: 1 &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Created: <?php echo date("M d, Y - h:ia", strtotime($course['Course']['created'])); ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Modified: <?php echo date("M d, Y - h:ia", strtotime($course['Course']['modified'])); ?></small>
								</h4>
						</div>
            <br/>
						<h2 class="text-default"><?php echo $course['Course']['title']; ?></h2>
            <br/>
            <div class="container-fluid">
                <?php
                    $cntr = 0;
                    if(isset($course['CourseSpecification']['description']) && trim($course['CourseSpecification']['description'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Course Description</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['description']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['target_audience']) && trim($course['CourseSpecification']['target_audience'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Target Group</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['target_audience']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['prerequisites']) && trim($course['CourseSpecification']['prerequisites'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Prerequisites</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['prerequisites']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['price']) && trim($course['CourseSpecification']['price'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Price of the Course</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['price']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['objective']) && trim($course['CourseSpecification']['objective'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Objective of the Course</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['objective']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['summary']) && trim($course['CourseSpecification']['summary'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Course Summary</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['summary']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['duration']) && trim($course['CourseSpecification']['duration'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Duration of the Course</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['duration']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['location']) && trim($course['CourseSpecification']['location'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Location of the Course</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['location']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['training_materials']) && trim($course['CourseSpecification']['training_materials'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Training Materials</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['training_materials']; ?>
                </p>
                <br/>
                <?php
                    }
                    $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> The Course Program</b></p>
                <?php
                    if(isset($course_lessons) && $course_lessons)
                    {
                        foreach($course_lessons as $weekly_sched):
                ?>
                <p>
                   <table id="timetable" class="table table-bordered table-hover table-striped">
    									 <thead class="thead-default">
    										 		<tr>
    													<th style="width:115px;">Days</th>
    													<th style="vertical-align:bottom;">Lessons</th>
    													<th style="width:165px;">Instructor</th>
    													<th style="width:135px;">Duration</th>
    													<th style="width:145px;">Time Slot</th>
    										 		</tr>
                        </thead>
                    <?php
                        for($day=1; $day<=7; $day++):
                            if(isset($weekly_sched['children'][$day]) && $weekly_sched['children'][$day])
                            {
                                $daily_sched = $weekly_sched['children'][$day];
                    ?>
                        <tr style="height:65px;">
                            <td class="time"><?php echo $daily_sched['name']; ?></td>
                            <td colspan="4" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $daily_sched['day']; ?>">
                                <table class="schedule table" style="border:none !important;background:transparent !important;">
                                    <?php
                                        foreach($daily_sched['children'] as $lesson):
                                    ?>
                                        <tr style="background:transparent;border-bottom:1px solid #dedede !important;">
                                            <td style="border-top:none !important;"><?php echo $this->Html->link($lesson['title'], array('controller' => 'lessons', 'action' => 'view', $lesson['lesson_id'])); ?></td>
                                            <td style="width:165px;border-top:none !important;"><?php echo $lesson['instructor'];?></span></td>
                                            <td style="width:135px;vertical-align:top;border-top:none !important;"><?php echo $lesson['duration']; ?></td>
                                            <td style="width:135px;vertical-align:top;border-top:none !important;"><?php echo $lesson['time_start']; ?> - <?php echo $lesson['time_end']; ?></td>
                                        </tr>
                                    <?php
                                        endforeach;
                                    ?>
                                </table>
                            </td>
                        </tr>
                    <?php
                            }
                            else
                            {
                    ?>
                        <tr style="height:65px;">
                            <td class="time"><?php echo $week_days_name[$day]; ?></td>
                            <td colspan="4" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $day; ?>">&nbsp;<br/><br/></td>
                        </tr>
                    <?php
                            }
                        endfor;
                    ?>
                    </table>
                </p>
                <br/>
                <?php
                        endforeach;
                    }
                    else
                    {
                ?>
                <p data-week="1">
                   <table id="timetable" class="table table-bordered table-hover table-striped">
                        <thead class="thead-default">
                            <th style="width:115px;">Days</th>
                            <th style="vertical-align:bottom;">Lessons</th>
                            <th style="width:165px;">Instructor</th>
                            <th style="width:135px;">Duration</th>
                            <th style="width:145px;">Time Slot</th>
                        </thead>
                        <tr style="height:65px;">
                            <td class="time">Monday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="1">&nbsp;<br/><br/></td>
                        </tr>
                        <tr style="height:65px;">
                            <td class="time">Tuesday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="2">&nbsp;<br/><br/></td>
                        </tr>
                        <tr style="height:65px;">
                            <td class="time">Wednesday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="3">&nbsp;<br/><br/></td>
                        </tr>
                        <tr style="height:65px;">
                            <td class="time">Thursday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="4">&nbsp;<br/><br/></td>
                        </tr>
                        <tr style="height:65px;">
                            <td class="time">Friday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="5">&nbsp;<br/><br/></td>
                        </tr>
                        <tr style="height:65px;">
                            <td class="time">Saturday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="6">&nbsp;<br/><br/></td>
                        </tr>
                        <tr style="height:65px;">
                            <td class="time">Sunday</td>
                            <td colspan="4" class="schedules" data-week="1" data-day="7">&nbsp;<br/><br/></td>
                        </tr>
                   </table>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['intake_limitation']) && trim($course['CourseSpecification']['intake_limitation'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Intake Limitation</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['intake_limitation']; ?>
                </p>
                <br/>
                <?php
                    }

                    if(isset($course['CourseSpecification']['certificate_issuance']) && trim($course['CourseSpecification']['certificate_issuance'])!='')
                    {
                        $cntr++;
                ?>
                <p><b><?php echo $cntr.'.';?> Certificate issuance and verification</b></p>
                <p style="padding-left: 20px;">
                   <?php echo $course['CourseSpecification']['certificate_issuance']; ?>
                </p>
                <br/>
                <?php
                    }
                ?>
            </div>
				</div>

        <div class="clearfix"></div>
        <div class="col-lg-offset-1 col-lg-10">
            <br/>
            <hr/>
            <span class="pull-right">
                <a class="btn btn-sm btn-success" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'download', 'specification', $course['Course']['id'], iconv('utf-8', 'us-ascii//TRANSLIT', $course['Course']['title']).'.pdf')); ?>"><i class="glyphicon glyphicon-download-alt"></i> Download</a>
                <a class="btn btn-sm btn-primary" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'edit', $course['Course']['id'])); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                <a class="btn btn-sm btn-default" href="<?php echo $this->Html->url(array('controller'=>'courses', 'action'=>'/')); ?>"><i class="fa fa-times"></i> Close</a>
            </span>
        </div>

    </div>
</div>
<br/><br/>
