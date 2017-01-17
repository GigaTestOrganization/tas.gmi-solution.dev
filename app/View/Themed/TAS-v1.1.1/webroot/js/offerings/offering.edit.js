$(function()
{
		$.fn.calendar.defaults.firstDay = 1;
		$('#OfferingDateStart').datebox({required:true, formatter:function(date){ var y = date.getFullYear(); var m = date.getMonth()+1; var d = date.getDate(); return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d); }, parser:function(s){ if(!s) return new Date(); var ss = (s.split('-')); var y = parseInt(ss[0],10); var m = parseInt(ss[1],10); var d = parseInt(ss[2],10); if(!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y,m-1,d); else return new Date(); },
		onSelect: function($date){if($('#OfferingCourseID').combotree('getValue')!='') defaultSchedules($('#OfferingCourseID').combotree('getValue'));}});

		$('#OfferingDateEnd').datebox({required:true, formatter:function(date){ var y = date.getFullYear(); var m = date.getMonth()+1; var d = date.getDate(); return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d); }, parser:function(s){ if(!s) return new Date(); var ss = (s.split('-')); var y = parseInt(ss[0],10); var m = parseInt(ss[1],10); var d = parseInt(ss[2],10); if(!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y,m-1,d); else return new Date(); },
		onSelect: function(date){if($('#OfferingCourseID').combotree('getValue')!='') defaultSchedules($('#OfferingCourseID').combotree('getValue'));}});

		//-----------------
		var $page_initialized = false;
		$("#OfferingCourseID").combotree({url:'/course_categories/generatejsontreestructure/1',method:'post',
										  onBeforeSelect:function(node){if(!node.attributes.hasOwnProperty('course_category_id')) return false;},
										  onSelect:function(node){ if($page_initialized) useDefaults(node.id,'Would you like to use the default instructors for this course?',$("#usedefault")); else $page_initialized = true; },
										  onLoadSuccess:function(e){var t=$('#OfferingCourseID').combotree('tree');var node=t.tree('getSelected');t.tree('expandTo',node.target);}});
		var $cpanel = $("#OfferingCourseID").combotree('panel');
		$cpanel.resizable({onResize:function(){$cpanel.panel('panel')._outerWidth($cpanel.outerWidth()+2);},onStopResize:function(){$cpanel.panel('resize',{width:$cpanel.outerWidth(),height:$cpanel.outerHeight()});}});

		$("#usedefault").click(function(e){ e.preventDefault(); useDefaults($('#OfferingCourseID').combotree('getValue'),'This action will reset the current assigned instructors as well as the pre-selected schedules to default.<br/><br/>Would you like to proceed?',this);});
		var useDefaults = function($course_id,$message,$this)
		{
				confirmWindow('Confirm',$message,$this,
								[{text:'Ok',iconCls:'icon-ok',id:'okbtn',
								  handler:function(){
									 $('#default_inst').val(1);
									 defaultSchedules($course_id);
									 closeWindow();
								 }},{text:'Cancel',iconCls:'icon-cancel',handler:closeWindow}]);

		}
		var defaultSchedules = function($course_id)
		{
				$.ajax({async:true, type:'POST', dataType:'html', url: '/courses/get_default_schedule', data:{'course_id':$course_id,'start_date':$('#OfferingDateStart').datebox('getValue'),'end_date':$('#OfferingDateEnd').datebox('getValue')},
						success:function(data){$('#course_program').html(data);}});

				//default instructor
				$.ajax({async:true, type:'POST', dataType:'json', url: '/course_lessons/get_default_instructors', data:{'course_id':$course_id}, success:function(data)
				{
						var defaults = data.default_instrutors;
						var $activeuserid = $('input[type="hidden"]#activeuserid').val();
						$('#AddedOfferInstructors').html('');
						for(var i=0; i<defaults.length; i++)
						{
								$('#AddedOfferInstructors').append('<tr><td><label for="OfferInstructor'+defaults[i]['Instructor'].id+'">'+defaults[i]['Instructor'].fullname+'</label><input type="hidden" name="data[OfferInstructor]['+defaults[i]['Instructor'].id+'][instructor_id]" value="'+defaults[i]['Instructor'].id+'"/></td><td style="text-align:center;"><input type="radio" name="data[lead]" id="OfferInstructor'+defaults[i]['Instructor'].id+'" value="'+defaults[i]['Instructor'].id+'"/><input type="hidden" name="data[OfferInstructor]['+defaults[i]['Instructor'].id+'][user_id]" value="'+$activeuserid+'"/></td><td style="text-align:center;"><a href="#" class="removeitem"><span class="text-danger fa fa-times"></span></a></td></tr>');
						}
				}});
		}


		//time slot
		$(".drop_start_time").combobox({onSelect:function($e)
		{
				var $time_end = calculateEndTime($(this).combobox('getText'), $(this).data('duration'));
				$(this).siblings('input.t_end:first').val($time_end);
		}});

		var calculateEndTime = function($startTime, $duration)
		{
				var $duration = $duration.split(':');
				var $startTime = $startTime.split(':');
				var $endHours = parseInt($startTime[0])+parseInt($duration[0]);
				var $endMinutes = parseInt($startTime[1])+parseInt($duration[1]);
				var $test = new Date("January 01, "+new Date().getFullYear()+" "+$endHours+":"+$endMinutes+":00");
				return checkTime($test.getHours())+":"+checkTime($test.getMinutes());
		}

		var checkTime = function(i)
		{
				if (i<10)
				{
					i="0" + i;
				}
				return i;
		}

		//if($(e.target).prop('className')=='drop_start_time')
		var beforeDrag = function(e)
		{
  			if(String('combo-arrow').indexOf($(e.target).prop('className'))) return false;
				if($(e.target).attr('id')=='findInstructor') return false;
		};
		$(".draggablelesson").draggable({cursor:"move",revert:'invalid',onBeforeDrag:beforeDrag, snap:'.schedules'});
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
										onDragEnter:function(e, source){ },
										onDragLeave:function(e, source){ $(this).removeClass('hoverBackground'); },
					  		};
			$('.schedules').droppable($options);

			var $target_lesson = null;
			$(document).on("click", "img#findInstructor", function(e)
			{
					e.preventDefault();
					$target_lesson = $(e.target);
					$("<div id='dd'>&nbsp;</div>").appendTo(this);
					$('#dd').dialog({title: 'Select Instructor', width: 400, height: 400, closed: true, cache: false, href: '/instructors/select', modal: true,
									 toolbar: '#dlg-toolbar', onClose: function(){$('input:checkbox',$('table#selectinstructors')).removeAttr('checked');},
									 buttons: '<div><div class="applytoall"><label><input type="checkbox" name="applytoall" id="applytoall" value="1"/> Apply to All</label></div><a href="javascript:void(0)" id="okbtn">OK</a><a href="javascript:void(0)" id="cnclbtn">Cancel</a></div>'
									});
					$("#okbtn").linkbutton({onClick:btnOKFntn,iconCls:'icon-ok',width:90});
					$("#cnclbtn").linkbutton({onClick:closeWindow,iconCls:'icon-cancel',width:90});
					$('#dd').dialog('open');
					$('#okbtn').addClass('l-btn-disabled');
			});

			// update this function.......
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
											$ins_name.html('<img src="/img/waiting.gif" border="0"/>&nbsp;saving...');
											$.ajax({async:true, type:"POST", url:"/course_lessons/update_info/", dataType:"json", data:{CourseLesson:{id:$clid, instructor_id:$selected_inst.val()}}, success:function(data){$ins_name.html($nme_);}});
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
											$.ajax({async:true, type:"POST", url:"/course_lessons/update_info/", dataType:"json", data:{CourseLesson:{id:$course_lesson_id, instructor_id:$(this).val()}}, success:function(data){$instructor_name.html($name_);}});
									});
							}
							$target_lesson = null;
							closeWindow();
					}
			}
			var closeWindow = function(){ $('#dd').dialog('close');}
			//--------- require updating ---------//

		//-----------------
			$('#addofferinstructor').click(function(e)
			{
					e.preventDefault();
					var selectedInstructorName = $('#InstructorsList').combobox('getText');
					var selectedInstructorId = $('#InstructorsList').combobox('getValue');
					var $activeuserid = $('input[type="hidden"]#activeuserid').val();
					if($("input[name='data[OfferInstructor]["+selectedInstructorId+"][instructor_id]']").length==0)
					{
							if(selectedInstructorId!='') $('#AddedOfferInstructors').append('<tr><td><label for="OfferInstructor'+selectedInstructorId+'">'+selectedInstructorName+'</label><input type="hidden" name="data[OfferInstructor]['+selectedInstructorId+'][instructor_id]" value="'+selectedInstructorId+'"/></td><td style="text-align:center;"><input type="radio" name="data[lead]" id="OfferInstructor'+selectedInstructorId+'" value="'+selectedInstructorId+'"/><input type="hidden" name="data[OfferInstructor]['+selectedInstructorId+'][user_id]" value="'+$activeuserid+'"/></td><td style="text-align:center;"><a href="#" class="removeitem"><span class="text-danger fa fa-times"></span></a></td></tr>');
							$('#InstructorsList').combobox('setValue', '');
					} else $.messager.alert('Message','Instructor already added!','warning');
			});

			$('#addofferclassroom').click(function(e)
			{
					e.preventDefault();
					var selectedClassroomName = $('#ClassroomsList').combobox('getText');
					var selectedClassroomId = $('#ClassroomsList').combobox('getValue');
					var $activeuserid = $('input[type="hidden"]#activeuserid').val();
					if($('input[name="data[OfferClassroom]['+selectedClassroomId+'][classroom_id]"]').length==0)
					{
							if(selectedClassroomId!='') $('#AddedOfferClassrooms').append('<tr><td>'+selectedClassroomName+'<input type="hidden" name="data[OfferClassroom]['+selectedClassroomId+'][classroom_id]" value="'+selectedClassroomId+'"/><input type="hidden" name="data[OfferClassroom]['+selectedClassroomId+'][user_id]" value="'+$activeuserid+'"/></td><td style="text-align:center;"><a href="#" class="removeitem"><span class="text-danger fa fa-times"></span></a></td></tr>');
							$('#ClassroomsList').combobox('setValue', '');
					} else $.messager.alert('Message','Classroom already added!','warning');
			});


			$(document).on('click', ".removeitem", function($e)
			{
					$e.preventDefault();
					var $id = $(this).data('id');
					var $resource = $(this).attr('name');
					var $tr = $(this).closest('tr');
					var $this = this;
					confirmWindow('Confirm','Are you sure you want to remove the item on the list?',$this, [{text:'Ok',iconCls:'icon-ok',id:'okbtn',handler:function(){removeItem($id,$resource,$tr,$this);closeWindow();}},{text:'Cancel',iconCls:'icon-cancel',handler:closeWindow}]);
			});

			var removeItem = function($id,$resource,$tr,$this)
			{
				if($resource!=undefined&&$resource!='')
				{
						$.post('/offerings/deleteResources/', {id:$id,type:$resource}, function(data)
						{
								if(Boolean(data.isError)) confirmWindow('Error',String(data.message),$this,[{text:'Ok',iconCls:'icon-ok',id:'okbtn',handler:function(){closeWindow();}}]);
								else $tr.remove();
						}, 'json')
						.fail(function($xhr, $status, $error)
						{
								confirmWindow('Error',String($error),$this,[{text:'Ok',iconCls:'icon-ok',id:'okbtn',handler:function(){closeWindow();}}]);
						});
				} else $tr.remove();
			}

			var confirmWindow = function($title,$message,$e,$buttons)
			{
					$('<div id="dd"><div style="padding: 6px;">'+$message+'</div></div>').appendTo($e);
					$('#dd').dialog({title:$title,width:310,height:140,closed:true,cache:false,modal:true,toolbar:'#dlg-toolbar',buttons:$buttons});
					$('#dd').dialog('open');
			}
			var closeWindow = function(){ $('#dd').dialog('destroy'); }

			$("#SubmitEditOfferForm").click(function($e)
			{
					$e.preventDefault();
	      	if($("#EditOfferForm").form('validate')) $("#EditOfferForm").submit();
	  	});
});
