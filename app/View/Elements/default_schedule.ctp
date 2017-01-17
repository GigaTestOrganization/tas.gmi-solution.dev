<?php
if(isset($course_lessons) && $course_lessons)
{
	if(isset($start_date) && isset($end_date))
	{
		$swd = date('w', strtotime($start_date));
		$new_start_date = ($swd==1?strtotime($start_date):strtotime("last Monday", strtotime($start_date)));

		$ewd = date('w', strtotime($end_date));
		$new_end_date = ($ewd==0?strtotime($end_date):strtotime("next Sunday", strtotime($end_date)));

		$d1 = new DateTime(date('Y-m-d', $new_start_date));
		$d2 = new DateTime(date('Y-m-d', $new_end_date));
		$interval = $d1->diff($d2);
		$nw = ceil(intval($interval->format('%a'))/7);

		$lessons = array();
		foreach($course_lessons as $weekly_sched) $lessons = array_merge($lessons, $weekly_sched['children']);

		$current_date = strtotime(date('Y-m-d', $new_start_date));
		$not_allowed_days = array(6,0);
		$daily_sched_index = 0;
		$lesson_index = 0;
		for($i=1; $i<=$nw; $i++)
		{
  			if($i>1)
			{
?>
	<div style="width: 100%; text-align: center; color: #333333; font-size: 14px;">...</div>
<?php
			}
?>
<p data-week="<?php echo $i; ?>">
	<table id="timetable" class="table table-bordered table-hover table-striped">
			<thead class="thead-default">
					<th width="115">Days</th>
					<th valign="bottom">Lessons</th>
					<th width="165">Instructor</th>
					<th width="140" align="center">Duration</th>
					<th width="145" align="center">Time Slot</th>
			</thead>
		<?php
			for($cntr=1; $cntr<=7; $cntr++):
				if(((strtotime(date('Y-m-d', $current_date))>=strtotime($start_date))&&(strtotime(date('Y-m-d', $current_date))<=strtotime($end_date))) && !in_array(date('w', $current_date), $not_allowed_days))
				{
		?>
		<tr height="50">
			<td class="time"><?php echo date('l', $current_date).'<br/><span style="font-size: 10px;">'.date('M d, Y', $current_date).'</span>'; ?></td>
			<td colspan="4" class="schedules" data-week="<?php echo $i; ?>" data-day="<?php echo (intval(date('w', $current_date))+1); ?>">
           	<?php
				if(isset($lessons[$daily_sched_index]))
				{
            		$daily_sched = @$lessons[$daily_sched_index];
			?>
          <table class="schedule table" style="border:none !important;background:transparent !important;" border="0" width="100%" cellpadding="5" cellspacing="0">
					<?php
						$order = 0;
						foreach($daily_sched['children'] as $lesson):
					?>
						<tr style="background:transparent;border-bottom:1px solid #dedede !important;" class="draggablelesson">
							<td width="165" style="border-top:none !important;"><?php echo $lesson['title']; ?><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][user_id]" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][lesson_id]" value="<?php echo $lesson['lesson_id']; ?>"/></td>
							<td width="165" style="border-top:none !important;"><span id="instructorname"><?php echo $lesson['instructor'];?><input type="hidden" name="data[Schedule][<?php echo $lesson_index; ?>][instructor_id]" value="<?php echo $lesson['instructor_id']; ?>"/></span></td>
							<td width="120" valign="top" style="border-top:none !important;"><?php echo $lesson['duration']; ?><input type="hidden" id="weeknum" name="data[Schedule][<?php echo $lesson_index; ?>][week]" value="<?php echo $i; ?>"/><input type="hidden" id="lessonday" name="data[Schedule][<?php echo $lesson_index; ?>][day]" value="<?php echo (intval(date('w', $current_date))+1); ?>"/><input type="hidden" id="lessonorder" name="data[Schedule][<?php echo $lesson_index; ?>][order]" value="<?php echo $order; ?>"/></td>
							<td width="145" valign="top" style="border-top:none !important;"><select name="data[Schedule][<?php echo $lesson_index; ?>][time_start]" data-duration="<?php echo $lesson['duration']; ?>" class="drop_start_time" style="width:65px;">
							<?php for($t=8; $t<24; $t++)
								  {
									$time00 = ($t>9?$t:'0'.$t).':00';
									echo '<option'.($time00==$lesson['time_start']?' selected="selected"':'').'>'.$time00.'</option>';

									$time15 = ($t>9?$t:'0'.$t).':15';
									echo '<option'.($time15==$lesson['time_start']?' selected="selected"':'').'>'.$time15.'</option>';

									$time30 = ($t>9?$t:'0'.$t).':30';
									echo '<option'.($time30==$lesson['time_start']?' selected="selected"':'').'>'.$time30.'</option>';

									$time45 = ($t>9?$t:'0'.$t).':45';
									echo '<option'.($time45==$lesson['time_start']?' selected="selected"':'').'>'.$time45.'</option>';
								  } ?></select> - <input type="text" class="t_end" name="data[Schedule][<?php echo $lesson_index; ?>][time_end]" readonly="readonly" style="border:none;background-color:transparent;width:55px;" value="<?php echo $lesson['time_end']; ?>"/></td>
						</tr>
					<?php
							$order++;
							$lesson_index++;
						endforeach;
					?>
				</table>
			<?php
					$daily_sched_index++;
                }
            ?>
			</td>
		</tr>
		<?php
				}
				else
				{
		?>
		<tr height="50">
			<td class="time"><?php echo date('l', $current_date).'<br/><span style="font-size: 10px;">'.date('M d, Y', $current_date).'</span>'; ?></td>
			<td colspan="4" class="schedules" data-week="<?php echo $i; ?>" data-day="<?php echo (intval(date('w', $current_date))+1); ?>">&nbsp;<br/><br/></td>
		</tr>
		<?php
				}
				$current_date = new DateTime(date('Y-m-d', $current_date));
				$current_date->add(new DateInterval('P1D'));
				$current_date = strtotime($current_date->format('Y-m-d'));
			endfor;
		?>
	</table>
</p>
<br/>
<?php
		}
	}
	else
	{
		foreach($course_lessons as $weekly_sched):
?>
<p data-week="<?php echo $weekly_sched['week']; ?>" style="margin-bottom: 10px;">
	 <table id="timetable" class="table table-bordered table-hover table-striped">
	 			<thead class="thead-default">
						<th width="115">Days</th>
						<th valign="bottom">Lessons</th>
						<th width="165">Instructor</th>
						<th width="140" align="center">Duration</th>
						<th width="145" align="center">Time Slot</th>
				</thead>
		<?php
			for($cntr=1; $cntr<=7; $cntr++):
				if(isset($weekly_sched['children'][$cntr]) && $weekly_sched['children'][$cntr])
				{
					$daily_sched = $weekly_sched['children'][$cntr];
		?>
		<tr height="50">
			<td class="time"><?php echo $daily_sched['name']; ?></td>
			<td colspan="4" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $daily_sched['day']; ?>">
				<table class="schedule table" style="border:none !important;background:transparent !important;" border="0" width="100%" cellpadding="5" cellspacing="0">
					<?php
						foreach($daily_sched['children'] as $lesson):
					?>
						<tr style="background:transparent;border-bottom:1px solid #dedede !important;" class="draggablelesson">
							<td width="165" style="border-top:none !important;"><?php echo $lesson['title']; ?></td>
							<td width="165" style="border-top:none !important;"><span id="instructorname"><?php echo $lesson['instructor'];?></span></td>
							<td width="120" valign="top" style="border-top:none !important;"><?php echo $lesson['duration']; ?></td>
							<td width="145" valign="top" style="border-top:none !important;"><select data-duration="<?php echo $lesson['duration']; ?>" data-course_lesson_id="<?php echo $lesson['id']; ?>" class="drop_start_time" style="width:65px;">
							<?php for($i=8; $i<24; $i++)
								  {
									$time00 = ($i>9?$i:'0'.$i).':00';
									echo '<option'.($time00==$lesson['time_start']?' selected="selected"':'').'>'.$time00.'</option>';

									$time15 = ($i>9?$i:'0'.$i).':15';
									echo '<option'.($time15==$lesson['time_start']?' selected="selected"':'').'>'.$time15.'</option>';

									$time30 = ($i>9?$i:'0'.$i).':30';
									echo '<option'.($time30==$lesson['time_start']?' selected="selected"':'').'>'.$time30.'</option>';

									$time45 = ($i>9?$i:'0'.$i).':45';
									echo '<option'.($time45==$lesson['time_start']?' selected="selected"':'').'>'.$time45.'</option>';
								  } ?></select> - <input type="text" class="t_end" readonly="readonly" style="border:none;background-color:transparent;width:55px;" value="<?php echo $lesson['time_end']; ?>"/></td>
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
		<tr height="50">
			<td class="time"><?php echo $week_days_name[$cntr]; ?></td>
			<td colspan="4" class="schedules" data-week="<?php echo $weekly_sched['week']; ?>" data-day="<?php echo $cntr; ?>">&nbsp;<br/><br/></td>
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
}
else
{
?>
<p data-week="1">
	 <table id="timetable" class="table table-bordered table-hover table-striped">
	 			<thead class="thead-default">
						<th width="115">Days</th>
						<th valign="bottom">Lessons</th>
						<th width="165">Instructor</th>
						<th width="140" align="center">Duration</th>
						<th width="145" align="center">Time Slot</th>
				</thead>
				<tr height="50">
					<td class="time">Monday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="1">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="time">Tuesday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="2">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="time">Wednesday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="3">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="time">Thursday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="4">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="time">Friday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="5">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="time">Saturday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="6">&nbsp;</td>
				</tr>
				<tr height="50">
					<td class="time">Sunday</td>
					<td colspan="4" class="schedules" data-week="1" data-day="7">&nbsp;</td>
				</tr>
   </table>
</p>
<?php } ?>
<script type="text/javascript">
	$(function()
	{
		//time slot
		$(".drop_start_time").combobox({onSelect:function($e){
			var $time_end = calculateEndTime($(this).combobox('getText'), $(this).data('duration'));
			$(this).siblings('input.t_end:first').val($time_end);
		}});

		function calculateEndTime($startTime, $duration)
		{
			var $duration = $duration.split(':');
			var $startTime = $startTime.split(':');
			var $endHours = parseInt($startTime[0])+parseInt($duration[0]);
			var $endMinutes = parseInt($startTime[1])+parseInt($duration[1]);
			var $test = new Date("January 01, "+new Date().getFullYear()+" "+$endHours+":"+$endMinutes+":00");
			return checkTime($test.getHours())+":"+checkTime($test.getMinutes());
		}

		function checkTime(i)
		{
			if (i<10)
			{
				i="0" + i;
			}
			return i;
		}

		$(".draggablelesson").draggable({cursor:"move",revert:'invalid',onBeforeDrag:function(e){ if(String('combo-arrow').indexOf($(e.target).prop('className'))) return false;}, snap:'.schedules'});
		var $options = {onDrop:function(e, source) {
									var $ul_schedule;
									if(!$('table.schedule', this).length)
									{
										$(this).html('');
										$ul_schedule = $("<table class=\"schedule table\" style=\"border:none !important;background:transparent !important;\" border=\"0\" width=\"100%\" cellpadding=\"5\" cellspacing=\"0\"/>");
										$ul_schedule.appendTo(this);
									}
									else $ul_schedule = $('table.schedule', this);
									$('input#lessonorder', source).val(String($('tr', $ul_schedule).length));
									$('input#lessonday', source).val($(this).data('day'));
									$('input#weeknum', source).val($(this).data('week'));
									$(source).appendTo($ul_schedule).hide().fadeIn(300);
									$(this).removeClass('hoverBackground');
							  },
						onDragEnter:function(e, source){ $(this).addClass('hoverBackground'); },
						onDragLeave:function(e, source){ $(this).removeClass('hoverBackground'); },
					  };
			$('.schedules').droppable($options);
		//-------------------
	});
</script>
