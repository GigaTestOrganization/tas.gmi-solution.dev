	$(function()
	{
		$(".draggablelesson").draggable({cursor: "move",revert:'invalid',
																		 proxy:function(e)
																				   {
																							var div = $("<div class=\"box lesson_dragged\" style=\"width:300px;\"><div class=\"col-lg-9 lesson_name\">"+$('td:eq(0)', this).html()+
																													"</div><div class=\"col-lg-3 lesson_duration\">"+$('td:eq(1)', this).html()+"</div></div>");
																							div.appendTo('body');
																							return div;
																				   },
																		 snap:'.schedules'});


		var $options = {accept:'.draggablelesson',
					   onDrop:function(e, source)
							  {
									var $ul_schedule;

									if(!$('table.schedule', this).length)
									{
  										$(this).html('');
  										$ul_schedule = $("<table class=\"schedule table\" style=\"border:none !important;background:transparent !important;\"/>");
  										$ul_schedule.appendTo(this);
									}
									else $ul_schedule = $('table.schedule', this);

									var $timestamp = new Date().getTime();
									var $duration = $('td:eq(1)', source).html();
									var $select = $('<select data-duration="'+$duration+'" class="drop_start_time new_'+$timestamp+'" style="width:65px;"/>');
									for(var $i=8; $i<24; $i++)
									{
										var $time00 = ($i>9?$i:'0'+$i)+':00';
										$('<option/>').html($time00).appendTo($select);

										var $time15 = ($i>9?$i:'0'+$i)+':15';
										$('<option/>').html($time15).appendTo($select);

										var $time30 = ($i>9?$i:'0'+$i)+':30';
										$('<option/>').html($time30).appendTo($select);

										var $time45 = ($i>9?$i:'0'+$i)+':45';
										$('<option/>').html($time45).appendTo($select);
									}
									$.ajax({
										type: "POST",
										url: "/course_lessons/add",
										dataType: "json",
										data: {CourseLesson:{course_id: String($('#CourseId').val()),
															 lesson_id: String($(source).data('lesson_id')),
															 week: $(this).data('week'),
															 day: $(this).data('day'),
															 order: String($('tr', $ul_schedule).length),
															 time_start: '08:00',
															 time_end: calculateEndTime('08:00', $duration)}},
										success: function(data)
    												 {
        													$select.data('course_lesson_id', String(data.courseLessonID));
        													var $tr = $('<tr style="background:transparent;border-bottom:1px solid #dedede !important;"/>');
        													$tr.html('<td style="border-top:none !important;">'+$('td:eq(0)', source).html()+'</td><td style="width:165px;border-top:none !important;"><img src="/img/searchbox_button.png" id="findInstructor" data-course_lesson_id="'+String(data.courseLessonID)+'"/>&nbsp;<span id="instructorname"></span></td><td style="width:135px;vertical-align:top;border-top:none !important;">'+$duration+'</td><td style="width:140px;vertical-align:top;border-top:none !important;"></td><td style="width:35px;text-align:center;border-top:none !important;"></td>').appendTo($ul_schedule).hide().fadeIn(300);
        													$('td:eq(3)', $tr).append("&nbsp;&nbsp;");
        													$('td:eq(3)', $tr).append($select);
        													$(".new_"+$timestamp).combobox({onSelect:function(e){
        																			var $time_end = calculateEndTime($(this).combobox('getText'), $(this).data('duration'));
        																			$(this).siblings('span.t_end:first').html($time_end);
        																			updateTimeSlot($(this).data('course_lesson_id'), $(this).combobox('getText'), $time_end);
        																		}});
        													$('td:eq(3)', $tr).append(' - ');
        													$('td:eq(3)', $tr).append('<span class="t_end">'+calculateEndTime('08:00', $duration)+'</span>');
        													var $a = $('<a href="/course_lessons/delete" data-id="'+String(data.courseLessonID)+'" id="remove_from_schedule" title="remove"><span class="text-danger fa fa-times"></span></a>');
        													$('td:eq(4)', $tr).append($a);
        													$a.click(function(e)
        													{
        														e.preventDefault();
        														removeLesson(this);
        													});
        													$select.change(function(e) {
        														var $time_end = calculateEndTime($(this).find(":selected").text(), $(this).data('duration'));
        														$('span:eq(0)', $('td:eq(3)', $tr)).html($time_end);
        														updateTimeSlot($(this).data('course_lesson_id'), $(this).find(":selected").text(), $time_end);
        													});
    												 }
									});

							  }
					  };

			$('.schedules').droppable($options);
			$(".drop_start_time").combobox({onSelect:function(e){
												var $time_end = calculateEndTime($(this).combobox('getText'), $(this).data('duration'));
												$(this).siblings('span.t_end:first').html($time_end);
												updateTimeSlot($(this).data('course_lesson_id'), $(this).combobox('getText'), $time_end);
											}});

			function updateTimeSlot($id, $start, $end)
			{
				$.ajax({async:true, type: "POST", url: "/course_lessons/update_info", dataType: "json",	data: {CourseLesson:{id: $id, time_start: $start, time_end: $end}}, success: function(data){}});
			}

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

			$('.add_week').each(function()
			{
					$(this).click(function(e)
					{
							e.preventDefault();
							$(this).blur();
							var $p = $('p', $("div#course_program"));
							var $p_count = $p.length;
							var $week_no = 1;
							if($p_count)
							{
									$week_no = $($p[$p_count-1]).data('week');
									while(($week_no==undefined))
									{
										$p_count--;
										$week_no = $($p[$p_count-1]).data('week');
									}
							}
							$week_no++;

							$rand = new Date().getTime()+3600;

							$day_name = ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
							$table = $('<table id="timetable" class="table table-bordered table-hover table-striped week'+$rand+'"><thead class="thead-default"><tr><th style="width:115px;">Days</th><th>Lessons</th><th style="width:165px;">Instructor</th><th style="width:140px;">Duration</th><th style="width:125px;">Time Slot</th><th style="width:50px;text-align:center;"><button type="button" class="btn btn-xs btn-default text-warning" id="js-remove_week" data-target=".week'+$rand+'" title="Remove Entire Week"><span class="fa fa-times"></span></button></th></tr></thead></table>');
							for($day=1; $day<=7; $day++)
							{
									var $schedtr = $('<tr style="height:65px;"></tr>').appendTo($table);
									var $sched_day = $('<td class="time">'+$day_name[$day]+'</td>').appendTo($schedtr);
									var $schedtime = $('<td colspan="5" class="schedules" data-week="'+$week_no+'" data-day="'+$day+'">&nbsp;</td>').appendTo($schedtr);
									$schedtime.droppable($options);
							}

							$new_p = $('<p data-week="'+$week_no+'" class="week'+$rand+'"/>').appendTo($("div#course_program"));
							$table.appendTo($new_p).hide().fadeIn(300);
					});
			});

			$('a#remove_from_schedule').click(function(e)
			{
					e.preventDefault();
					removeLesson(this);
			});

			function removeLesson(source)
			{
					var $lesson = $(source).parents('tr:first');
					$.ajax({
						type: "POST",
						url: "/course_lessons/delete",
						dataType: "json",
						data: {CourseLesson:{id: $(source).data('id')}},
						success: function(data)
										 {
												if(!data.isError) $lesson.fadeOut(300, function(){ $lesson.remove(); });
										 }
					});
			}

			$(document).on("click", "button#js-remove_week", function($e)
			{
					$e.preventDefault();
					$(this).parents('table:eq(0)').find('a#remove_from_schedule').each(function()
					{
							removeLesson(this);
					});
					
					if($("div#course_program").find("table#timetable").length>1) $($(this).data('target')).each(function(){ $(this).remove(); });
			});

			var $target_lesson = null;
			$(document).on("click", "img#findInstructor", function(e)
			{
					e.preventDefault();
					$target_lesson = $(e.target);
					$("<div id='dd'>&nbsp;</div>").appendTo(this);
					$('#dd').dialog({title: 'Select Instructor', width: 400, height: 400, closed: true, cache: false, href: '/instructors/select', modal: true,
									 toolbar: '#dlg-toolbar', onClose: function(){$('input:checkbox',$('table#selectinstructors')).removeAttr('checked');},
									 buttons: '<div><div class="applytoall"><label><input type="checkbox" name="applytoall" id="applytoall" value="1"/> apply to all</label></div><a href="javascript:void(0)" id="okbtn">OK</a><a href="javascript:void(0)" id="cnclbtn">Cancel</a></div>'
									});
					$("#okbtn").linkbutton({onClick:btnOKFntn,iconCls:'icon-ok',width:90});
					$("#cnclbtn").linkbutton({onClick:closeWindow,iconCls:'icon-cancel',width:90});
					$('#dd').dialog('open');
					$('#okbtn').addClass('l-btn-disabled');
			});

			var btnOKFntn = function()
			{
					if(!$('#okbtn').hasClass('l-btn-disabled'))
					{
							if($("input[type='checkbox']#applytoall:checked").length)
							{
									$('img#findInstructor').map(function()
									{
											var $clid = $(this).data("course_lesson_id");
											var $ins_name = $('span#instructorname', $(this).closest('td'));
											var $selected_inst = $("input[type='checkbox'].individualselect:checked");
											var $nme_ = $($selected_inst.closest('tr')).find('td:eq(1) label').html()+' '+$($selected_inst.closest('tr')).find('td:eq(2) label').html();
											$ins_name.html('&nbsp;<img src="/img/waiting.gif" border="0"/>&nbsp;saving...');
											$.ajax({async:true, type:"POST", url:"/course_lessons/update_info", dataType:"json", data:{CourseLesson:{id:$clid, instructor_id:$selected_inst.val()}}, success:function(data){$ins_name.html($nme_);}});
									});
							}
							else
							{
									var $course_lesson_id = $target_lesson.data('course_lesson_id');
									var $instructor_name = $('span#instructorname', $target_lesson.closest('td'));
									$("input[type='checkbox'].individualselect:checked", $('#instructorslist')).map(function()
									{
											var $name_ = $($(this).closest('tr')).find('td:eq(1) label').html()+' '+$($(this).closest('tr')).find('td:eq(2) label').html();
											$instructor_name.html('<img src="/img/waiting.gif" border="0"/>&nbsp;saving...');
											$.ajax({async:true, type:"POST", url:"/course_lessons/update_info", dataType:"json", data:{CourseLesson:{id:$course_lesson_id, instructor_id:$(this).val()}}, success:function(data){$instructor_name.html($name_);}});
									});
							}
							$target_lesson = null;
							closeWindow();
					}
			}
			var closeWindow = function(){ $('#dd').dialog('close');}

	});
