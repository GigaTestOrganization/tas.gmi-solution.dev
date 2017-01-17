<div class="courses view" id="content">	    
    <div class="course_specs" style="width: 1024px; padding: 10px;">
	    <img src="<?php echo $this->Html->url('/img/gmi/gigamare.jpg', true); ?>" border="0" height="81" width="99"/>
	    <h3 class="float_right" style="margin-top: 35px;">Course Specification</h3>
	    <br/>
	    <br/>
	    <hr/>
        <div style="width: 100%; float: left;"><span style="color: #CCC; font-size: 0.8em; float: right;">Author: <?php echo $course['Course']['author']; ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Revision: 1 &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Created: <?php echo date("M d, Y - h:ia", strtotime($course['Course']['created'])); ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Modified: <?php echo date("M d, Y - h:ia", strtotime($course['Course']['modified'])); ?></span></div>
	    <br/>
	    <br/>
	    <br/>
		<h1><?php echo $course['Course']['title']; ?></h1>
	    <br/>
	    <br/>
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
        <p><b><?php echo $cntr.'.';?> The Course Program</b></p><br/>
        <?php
			if(isset($course_lessons) && $course_lessons)
			{
	        	foreach($course_lessons as $weekly_sched):
	    ?>        
        <p>                 
           <table id="timetable" width="100%" cellpadding="2" cellspacing="0" border="0">
                <thead>
                    <th width="115">Days</th>
                    <th valign="bottom">Lessons</th>
                    <th width="165">Instructor</th>
                    <th width="135" align="center">Duration</th>
                    <th width="145" align="center">Time Slot</th>
                </thead>     
			<?php
                for($day=1; $day<=7; $day++):
                    if(isset($weekly_sched['children'][$day]) && $weekly_sched['children'][$day])
                    {								
                        $daily_sched = $weekly_sched['children'][$day];					
            ?>                                           
                <tr>
                    <td class="time"><?php echo $daily_sched['name']; ?></td>
                    <td colspan="4" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $daily_sched['day']; ?>">
                        <table class="schedule" border="0" width="100%" cellpadding="5" cellspacing="0">
                            <?php 
                                foreach($daily_sched['children'] as $lesson):
                            ?>
                                <tr style="background-color: transparent;"/>
                                    <td><?php echo $lesson['title']; ?></td>
                                    <td width="165"><?php echo $lesson['instructor'];?></span></td>
                                    <td width="125" valign="top"><?php echo $lesson['duration']; ?></td>
                                    <td width="130" valign="top"><?php echo $lesson['time_start']; ?> - <?php echo $lesson['time_end']; ?></td>
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
                <tr>
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
        <p>                 
           <table id="timetable" width="100%" cellpadding="2" cellspacing="0" border="0">
                <thead>
                    <th width="115">Days</th>
                    <th valign="bottom">Lessons</th>
                    <th width="165">Instructor</th>
                    <th width="135" align="center">Duration</th>
                    <th width="145" align="center">Time Slot</th>
                </thead>
                <tr>
                    <td class="time">Monday</td>
                    <td colspan="4" class="schedules" data-week="1" data-day="1">&nbsp;<br/><br/></td>
                </tr>
                <tr>
                    <td class="time">Tuesday</td>
                    <td colspan="4" class="schedules" data-week="1" data-day="2">&nbsp;<br/><br/></td>
                </tr>
                <tr>
                    <td class="time">Wednesday</td>
                    <td colspan="4" class="schedules" data-week="1" data-day="3">&nbsp;<br/><br/></td>
                </tr>
                <tr>
                    <td class="time">Thursday</td>
                    <td colspan="4" class="schedules" data-week="1" data-day="4">&nbsp;<br/><br/></td>
                </tr>
                <tr>
                    <td class="time">Friday</td>
                    <td colspan="4" class="schedules" data-week="1" data-day="5">&nbsp;<br/><br/></td>
                </tr>
                <tr>
                    <td class="time">Saturday</td>
                    <td colspan="4" class="schedules" data-week="1" data-day="6">&nbsp;<br/><br/></td>
                </tr>
                <tr>
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
    <br/>
</div>