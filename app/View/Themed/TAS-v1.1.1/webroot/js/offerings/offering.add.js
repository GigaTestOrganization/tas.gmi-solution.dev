$(function()
{
		// Extends Combotree to make it searchable
		$.fn.combotree.defaults.editable = true;
		$.extend($.fn.combotree.defaults.keyHandler,{
			up:function(){},
			down:function(){},
			enter:function(){},
			query:function(q)
			{
					var t = $(this).combotree('tree');
					var nodes = t.tree('getChildren');
					for(var i=0; i<nodes.length; i++){
						var node = nodes[i];
						if (node.text.indexOf(q) >= 0){
							$(node.target).show();
						} else {
							$(node.target).hide();
						}
					}
					var opts = $(this).combotree('options');
					if (!opts.hasSetEvents){
						opts.hasSetEvents = true;
						var onShowPanel = opts.onShowPanel;
						opts.onShowPanel = function(){
							var nodes = t.tree('getChildren');
							for(var i=0; i<nodes.length; i++){
								$(nodes[i].target).show();
							}
							onShowPanel.call(this);
						}
						$(this).combo('options').onShowPanel = opts.onShowPanel;
					}
			 }
		});

		var oldQuery = $.fn.combobox.defaults.keyHandler.query;
		$.fn.combobox.defaults.keyHandler.query = function(q){
			oldQuery.call(this, q);
			var opts = $(this).combobox('options');
			if (opts.mode == 'local'){
				var data = $(this).combobox('getData');
				for(var i=0; i<data.length; i++){
					if (data[i][opts.textField].toLowerCase() == q.toLowerCase()){
						$(this).combobox('setValue', data[i][opts.valueField]);
						return;
					}
				}
			}
		};
		// -------------------------------------------

		$.fn.calendar.defaults.firstDay = 1;
		$('#OfferingDateStart').datebox({required:true, formatter:function(date){ var y = date.getFullYear(); var m = date.getMonth()+1; var d = date.getDate(); return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d); }, parser:function(s){ if(!s) return new Date(); var ss = (s.split('-')); var y = parseInt(ss[0],10); var m = parseInt(ss[1],10); var d = parseInt(ss[2],10); if(!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y,m-1,d); else return new Date(); }, onSelect: function($date){ if($('#OfferingCourseID').combotree('getValue')!='') useDefaults($('#OfferingCourseID').combotree('getValue')); }});

		$('#OfferingDateEnd').datebox({required:true, formatter:function(date){ var y = date.getFullYear(); var m = date.getMonth()+1; var d = date.getDate(); return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d); }, parser:function(s){ if(!s) return new Date(); var ss = (s.split('-')); var y = parseInt(ss[0],10); var m = parseInt(ss[1],10); var d = parseInt(ss[2],10); if(!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y,m-1,d); else return new Date(); }, onSelect: function(date){ if($('#OfferingCourseID').combotree('getValue')!='') useDefaults($('#OfferingCourseID').combotree('getValue')); }});

		//------------------------
		$("#OfferingCourseID").combotree({required:true,url:'/course_categories/generatejsontreestructure/1',method:'post', onBeforeSelect:function(node){if(!node.attributes.hasOwnProperty('course_category_id')) return false;}, onSelect:function(node){ useDefaults(node.id); }});
		var $cpanel = $("#OfferingCourseID").combotree('panel');
		$cpanel.resizable({onResize:function(){$cpanel.panel('panel')._outerWidth($cpanel.outerWidth()+2);},onStopResize:function(){$cpanel.panel('resize',{width:$cpanel.outerWidth(),height:$cpanel.outerHeight()});}});

		$("#usedefault").click(function(e){ e.preventDefault(); if($('#OfferingCourseID').combotree('getValue')!='') useDefaults($('#OfferingCourseID').combotree('getValue')); });
		var useDefaults = function($course_id)
		{
				defaultInstructors($course_id);
				defaultSchedules($course_id);
		}
		var defaultInstructors = function($course_id)
		{
				$.ajax({async:true, type:'POST', dataType:'json', url: '/course_lessons/get_default_instructors', data:{'course_id':$course_id}, success:function(data)
				{
						var defaults = data.default_instrutors;
						var $activeuserid = $('input[type="hidden"]#activeuserid').val();
						$('#AddedOfferInstructors').html('');
						for(var i=0; i<defaults.length; i++)
						{
								$('#AddedOfferInstructors').append('<tr><td><label for="OfferInstructor'+defaults[i]['Instructor'].id+'">'+defaults[i]['Instructor'].fullname+'</label><input type="hidden" name="data[OfferInstructor]['+defaults[i]['Instructor'].id+'][instructor_id]" value="'+defaults[i]['Instructor'].id+'"/></td><td style="text-align:center;"><input type="radio" name="data[lead]" id="OfferInstructor'+defaults[i]['Instructor'].id+'" value="'+defaults[i]['Instructor'].id+'"/><input type="hidden" name="data[OfferInstructor]['+defaults[i]['Instructor'].id+'][user_id]" value="'+$activeuserid+'"/></td><td><a href="#" id="removeitem" class="close">&times;</a></td></tr>');
						}
				}});
		}
		var defaultSchedules = function($course_id)
		{
				$.ajax({async:true, type:'POST', dataType:'html', url: '/courses/get_default_schedule', data:{'course_id':$course_id,'start_date':$('#OfferingDateStart').datebox('getValue'),'end_date':$('#OfferingDateEnd').datebox('getValue')}, success:function(data){
							$('#course_program').html(data);
						}
				});
		}
		//----------------

		$('#addofferinstructor').click(function(e)
		{
				e.preventDefault();
				var selectedInstructorName = $('#InstructorsList').combobox('getText');
				var selectedInstructorId = $('#InstructorsList').combobox('getValue');
				var $activeuserid = $('input[type="hidden"]#activeuserid').val();
				if($("input[name='data[OfferInstructor]["+selectedInstructorId+"][instructor_id]']").length==0)
				{
						if(selectedInstructorId!='') $('#AddedOfferInstructors').append('<tr><td><label for="OfferInstructor'+selectedInstructorId+'">'+selectedInstructorName+'</label><input type="hidden" name="data[OfferInstructor]['+selectedInstructorId+'][instructor_id]" value="'+selectedInstructorId+'"/></td><td style="text-align:center;"><input type="radio" name="data[lead]" id="OfferInstructor'+selectedInstructorId+'" value="'+selectedInstructorId+'"/><input type="hidden" name="data[OfferInstructor]['+selectedInstructorId+'][user_id]" value="'+$activeuserid+'"/></td><td><a href="#" id="removeitem" class="close">&times;</a></td></tr>');
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
					if(selectedClassroomId!='') $('#AddedOfferClassrooms').append('<tr><td>'+selectedClassroomName+'<input type="hidden" name="data[OfferClassroom]['+selectedClassroomId+'][classroom_id]" value="'+selectedClassroomId+'"/><input type="hidden" name="data[OfferClassroom]['+selectedClassroomId+'][user_id]" value="'+$activeuserid+'"/></td><td><a href="#" id="removeitem" class="close">&times;</a></td></tr>');
					$('#ClassroomsList').combobox('setValue', '');
				} else $.messager.alert('Message','Classroom already added!','warning');
		});

		$(document).on('click', "a#removeitem", function(event){ event.preventDefault(); $(this).closest('tr').remove(); });

		$("#SubmitCreateNewOfferForm").click(function($e)
		{
			$e.preventDefault();
        	if($("#CreateNewOfferForm").form('validate')) $("#CreateNewOfferForm").submit();
    });
});
