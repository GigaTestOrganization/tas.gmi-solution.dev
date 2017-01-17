$(function()
{
		$(document).on("click", "a#addparticipant", function(e)
		{
				e.preventDefault();
				if(!$edit_grades)
				{
						$("<div id='dd'>&nbsp;</div>").appendTo(this);
						$('#dd').dialog({title: 'Select Participants', width: 500, height: 400, closed: true, cache: false, href: '/people/select', modal: true,
										 toolbar: '#dlg-toolbar', onClose: function(){$('input:checkbox',$('#selectpeople')).removeAttr('checked');}, onLoad: assignFilterFunction,
										 buttons: '<div><a href="javascript:void(0)" id="addnewperson" style="float:left;">Add New Person</a><a href="javascript:void(0)" id="okbtn">OK</a><a href="javascript:void(0)" id="cnclbtn">Cancel</a></div>'
										});
						$("#addnewperson").linkbutton({onClick:function(){ window.location.href = '/people/add'},iconCls:'icon-add',width:150});
						$("#okbtn").linkbutton({onClick:btnOKFntn,iconCls:'icon-ok',width:90});
						$("#cnclbtn").linkbutton({onClick:function(){closeWindow($("#dd"));},iconCls:'icon-cancel',width:90});
						$('#dd').dialog('open');
						$('#okbtn').addClass('l-btn-disabled');
				}
		});
		var btnOKFntn = function()
		{
				if(!$('#okbtn').hasClass('l-btn-disabled'))
				{
						var offer_id = $('input[type="hidden"]#offer_id').val();
						var $people_already_enrolled = "";
						$("input[type='checkbox'].individualselect:checked").map(function(){
							var $this = this;
							if(!$('tr td input[type="hidden"][value="'+$($this).val()+'"]',$('#offerParticipantList')).length)
							{
									var newparticipant = $('<tr height="39"><td><input type="checkbox" value=""/><input type="hidden" value="'+$($this).val()+'"/></td><td><a href="/people/view/'+$($this).val()+'" target="_blank">'+$($($this).closest('tr')).find('td:eq(1) label').html()+' '+$($($this).closest('tr')).find('td:eq(2) label').html()+'</a></td><td><a href="/customers/view/'+$($($this).closest('tr')).find('td:eq(3) label').data('customer_id')+'" target="_blank">'+$($($this).closest('tr')).find('td:eq(3) label').html()+'</a></td><td><span class="grade_n">&nbsp;</span></td><td><span class="stat_name">-</span><input type="hidden" name="stat_id" class="stat_id" value=""/></td><td>&nbsp;</td><td><img src="/img/waiting.gif" border="0"/>&nbsp;saving...</td></tr>');

									$(newparticipant).hide().appendTo('#offerParticipantList').fadeIn('slow');

									$.ajax({async:true, type:'POST', dataType:'json', url: '/offering_participants/add', data:{'person_id':$($this).val(), 'offering_id':offer_id}, success:function(data)
									{
											$(newparticipant).find("td:eq(0) input[type='checkbox']").val(data.id.toString());
											$(newparticipant).find('td:eq(5)').html(data.created.toString());
											$(newparticipant).find('td:eq(6)').html('&nbsp;');
											$("#js-participants-count").empty();
											$("#js-participants-count").html($('#offerParticipantList').find('tr').length);
									}});
							} else $people_already_enrolled += ($.trim($people_already_enrolled)!=""?"<br/>":"")+"- "+$($($this).closest('tr')).find('td:eq(1) label').html()+' '+$($($this).closest('tr')).find('td:eq(2) label').html();
						});
						if($.trim($people_already_enrolled)!="") $.messager.alert('Message','The following person(s) are already enrolled.<br/><br/><p style="padding-left: 35px;">'+$people_already_enrolled+'</p>','warning');
						$('#dd').dialog('refresh');
						closeWindow($('#dd'));
				}
		}
		var closeWindow = function($window, $method){ $method = $method || 'close'; $window.dialog($method); }

		// Filter ---------------
		var assignFilterFunction = function()
		{
				$("#searchkeyword").searchbox({prompt:'type first/last name', searcher:function($value, $name){ filter(); }});
				$("#customer_id").combobox({panelHeight:'150px',onSelect:function($record){ filter();}});
		}
		var filter = function(obj){ $.post('/people/select/', {keyword:$("#searchkeyword").searchbox('getValue'), customerid:$('#customer_id').combobox('getValue')}, function(data){$('tbody#peoplelist').html(data); $("input[type='checkbox']#selectall").removeAttr("checked"); $('#okbtn').addClass('l-btn-disabled');}, 'text'); }
		//------------------------------

		$(document).on('click', "input[type='checkbox']#select_all_participants", function($e)
		{
				if($($e.target).is("input[type='checkbox']#select_all_participants"))
				{
						$('tr td input:checkbox',$('#offerParticipantList')).prop('checked',this.checked);
						toggleRemoveButton();
				}
		});

		$(document).on('click', $('tr td input:checkbox',$('#offerParticipantList')), function($e)
		{
				if($($e.target).is($('tr td input:checkbox',$('#offerParticipantList'))))
				{
						if($('tr td input:checkbox',$('#offerParticipantList')).length==$('tr td input:checkbox:checked',$('#offerParticipantList')).length)  $("input[type='checkbox']#select_all_participants").prop("checked", "checked");
						else $("input[type='checkbox']#select_all_participants").removeAttr("checked");
						toggleRemoveButton();
				}
		});
		var toggleRemoveButton = function()
		{
				if($('tr td input:checkbox:checked',$('#offerParticipantList')).length!=0) $('#remove_button').removeClass('disabled');
				else $('#remove_button').addClass('disabled');
		}
		$('#remove_button').click(function($e)
		{
				$e.preventDefault();
				if($('tr td input:checkbox:checked',$('#offerParticipantList')).length)
				{
						$('<div class="overlay" id="overlay" style="display:none;"></div>').appendTo('html');
						$('#overlay').fadeIn(200);
						$('tr td input:checkbox:checked',$('#offerParticipantList')).map(function()
						{
								var $closestTR = $(this).closest('tr');
								$($closestTR).find('td:eq(6)').html('<img src="/img/waiting.gif" border="0"/>&nbsp;deleting...');
								$.ajax({async:true, type:'POST', dataType:'json', url: '/offering_participants/remove', data:{'id':$(this).val()}, success:function(data){
										if(!Boolean(data.isError))
										{
												$($closestTR).fadeOut('fast', function()
												{
														$(this).remove();
														if(!$('tr td input:checkbox:checked',$('#offerParticipantList')).length)
														{
																$('#overlay').fadeOut('fast', function(){$(this).remove();});
																$("input[type='checkbox']#select_all_participants").removeAttr("checked");
																toggleRemoveButton();
																$("#js-participants-count").empty();
																$("#js-participants-count").html($('#offerParticipantList').find('tr').length);
														}
												});
										}
								}, error: function(xhr, status, error) { $('#overlay').fadeOut('fast'); $.messager.alert('Messager', 'Action not allowed.'); }
								});
						});
				}
		});

		//-------add grades
		var $edit_grades = false;
		$("#edit_grades_and_stats").click(function($e)
		{
				$e.preventDefault();
				$edit_grades = !$edit_grades;
				$this = $(this);
				if($edit_grades)
				{
						$('#select_all_participants').attr('disabled', 'disabled');
						$('#offerParticipantList input[type="checkbox"]').map(function()
						{
								$(this).attr('disabled', 'disabled');
						});
						$('#addparticipant').addClass('disabled');
						$this.html('save').hide().fadeIn('slow');
						$('<span><small>&nbsp;|&nbsp;</small><a href="#" id="cancel_">discard</a></span>').appendTo($this.parent('th:first')).hide().fadeIn('slow');
						$("#cancel_").click(function($e)
						{
								$e.preventDefault();
								$('#select_all_participants').removeAttr('disabled', 'disabled');
								$('#offerParticipantList input[type="checkbox"]').map(function()
								{
										$(this).removeAttr('disabled', 'disabled');
								});
								$('#addparticipant').removeClass('disabled');
								$edit_grades = false;
								$this.html('edit').hide().fadeIn('slow');
								$('span:first', $this.parent('th:first')).remove();
								$("tr", $("#offerParticipantList")).map(function()
								{
										var $grde_0 = $(this).find("td:eq(3) span.grade_n:first");
										$(this).find("td:eq(3) input[type='text']:first").remove();
										$grde_0.css('display', 'inline-block');
										var $stat_0 = $($(this).find("td:eq(4) select.stat"));
										$stat_0.combobox('setValue', $(this).find("td:eq(4) input.stat_id").val());
										$(this).find("td:eq(4) span.stat_name").html($.trim($stat_0.combobox('getText')));
								});
						});
				}
				else
				{
						$('#select_all_participants').removeAttr('disabled', 'disabled');
						$('#offerParticipantList input[type="checkbox"]').map(function()
						{
								$(this).removeAttr('disabled', 'disabled');
						});
						$('#addparticipant').removeClass('disabled');
						$this.html('edit').hide().fadeIn('slow');
						$('span:first', $this.parent('th:first')).remove();
				}

				$("tr", $("#offerParticipantList")).map(function()
				{
						var $grde_ = $(this).find("td:eq(3) span.grade_n:first");
						if($edit_grades)
						{
								$(this).find("td:eq(3)").append('<input type="text" value="'+$.trim($grde_.html().replace(/[&nbsp;]/g, ''))+'" maxlength="5" style="width: 50px; height: 20px; border: 1px #95B8E7 solid; text-align: center;"/>');
								$grde_.css('display', 'none');
								var $select_stat = $('<select name="status" class="stat"><option value="" selected="selected" disabled="disabled">-</option><option value="0">Failed</option><option value="1">Passed</option><option value="3">Attended</option><option value="2">Cancelled</option></select>');
								$select_stat.val($.trim($(this).find("td:eq(4) input.stat_id").val()));
								$(this).find("td:eq(4) span.stat_name").html($select_stat);
								$($select_stat).combobox({'panelHeight':'auto'});
						}
						else
						{
								var $grade = $(this).find("td:eq(3) input[type='text']:first");
								var $grade_val = $.trim($grade.val());
								$grde_.html($grade_val);
								$grde_.css('display', 'inline-block');
								$grade.remove();
								var $stat = $($(this).find("td:eq(4) select.stat"));
								var $stat_val = $.trim($stat.combobox('getValue'));
								$(this).find("td:eq(4) input.stat_id").val($stat_val);
								$(this).find("td:eq(4) span.stat_name").html($.trim($stat.combobox('getText')));

								var $closestTR = $(this);
								$closestTR.find('td:eq(6)').html('');
								var $save_indicator = $('<span><img src="/img/waiting.gif" border="0"/>&nbsp;saving...</span>');
								$save_indicator.appendTo($closestTR.find('td:eq(6)')).hide().fadeIn('slow');
								var $participant_record_id = $(this).find("td:eq(0) input[type='checkbox']").val();
								$.ajax({async:true, type:'POST', dataType:'json', url: '/offering_participants/edit', data:{'id':$participant_record_id, 'grade':$grade_val, 'status':$stat_val}, success:function(data)
								{
										if(!Boolean(data.isError))
										{
												$save_indicator.fadeOut('fast', function()
												{
														$(this).remove();
														$closestTR.find('td:eq(6)').html('&nbsp;');
												});
										}
										else $closestTR.find('td:eq(6)').html(data.message);
								}, error: function(xhr, status, error) { $.messager.alert('Message', xhr.responseText); }});
						}
					});
			});
			// ------------------------------------

			/* Downloads */
			$(".js-download").each(function()
			{
					$(this).click(function($e)
					{
							$e.preventDefault();
							window.location.href = '/offerings/download/'+$(this).data('file');
					});
			});
			// ----------------------------

			// --------------row actions-------------
			$("#offerParticipantList").on('mouseover', 'tr', function($e)
			{
					if(!$edit_grades && $(this).find("td:last span").length<=0)
					{
							var $this = this;
							var $participant_record_id = $($this).find("td:eq(0) input[type='checkbox']").val();
							var $menu_container = $("<div class=\"participants-row-menu\"></div>");

							var $menu_additional_details = $("<a href=\"#\" title=\"Additional details.\"/>").linkbutton({plain:true,iconCls:'icon-menu'});
							$menu_container.append($menu_additional_details);
							$($menu_additional_details).tooltip({position:'top',showDelay:1000,content:'<span style="color:#333;">'+$($menu_additional_details).attr('title')+'</span>',onShow:function(){$(this).tooltip('tip').css({backgroundColor:'#EBFAFF',borderColor:'#2EB8E6','z-index':999999});}});
							$menu_additional_details.on("click", function()
							{
									openAdditionalInformationWindow($this);
							});

							var $menu_edit_participant = $("<a href=\"#\" title=\"Modify grade and status.\"/>").linkbutton({plain:true,iconCls:'icon-edit'});
							$menu_container.append($menu_edit_participant);
							$($menu_edit_participant).tooltip({position:'top',showDelay:1000,content:'<span style="color:#333;">'+$($menu_edit_participant).attr('title')+'</span>',onShow:function(){$(this).tooltip('tip').css({backgroundColor:'#EBFAFF',borderColor:'#2EB8E6','z-index':999999});}});

							var $menu_delete_participant = $("<a href=\"#\" title=\"Remove participant.\"/>").linkbutton({plain:true,iconCls:'icon-cancel'});
							$menu_container.append($menu_delete_participant);
							$($menu_delete_participant).tooltip({position:'top',showDelay:1000,content:'<span style="color:#333;">'+$($menu_delete_participant).attr('title')+'</span>',onShow:function(){$(this).tooltip('tip').css({backgroundColor:'#EBFAFF',borderColor:'#2EB8E6','z-index':999999});}});
							$menu_delete_participant.on("click", function()
							{
									$($menu_delete_participant).tooltip('hide');
									removeParticipant($this, $participant_record_id);
							});

							$(this).find("td:last").html('');
							$(this).find("td:last").html($menu_container);
					}
			});

			$("#offerParticipantList").on('mouseleave', "tr", function($e)
			{
					if(!$edit_grades)
					{
							$(this).find("td:last div").remove();
							if($(this).find("td:last img#deleting").length<=0) $(this).find("td:last").html('&nbsp;');
					}
			});

			var openAdditionalInformationWindow = function($this)
			{
					$("<div id='js-additional-details-window'>&nbsp;</div>").appendTo($this);
					$('#js-additional-details-window').dialog({title: 'Additional Details - '+$($this).find('td:eq(1)').html(), width: 450, height: 450, closed: true, cache: false, href: '/offering_participants/additionalDetails/'+$($this).find("td:eq(0) input[type='checkbox']").val(), modal: true,
									 toolbar: '#dlg-toolbar', onClose: function(){closeWindow($("#js-additional-details-window"), 'destroy');}, onLoad: function(){},
									 buttons: '<div><label class="pull-left"><input name="applyToAll" id="js-ApplyToAll" type="checkbox" value="1"/> Apply to all</label> <a href="javascript:void(0)" id="js-save-additional-details">Save</a><a href="javascript:void(0)" id="js-cancel-button">Cancel</a></div>'
									});
					$("#js-save-additional-details").linkbutton({onClick:function()
					{
							var $save_button = this;
							$($save_button).linkbutton({text:'Saving...'});
							$($save_button).parent().prepend('<span id="savingadditionaldetails" style="color:#333;position:relative;"><img style="position:absolute;" src="/img/waiting.gif" border="0"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>');
							$data = $("#js-frm-saveadditionaldetails").serialize();
							if($(this).is(":checked")) $data.push({"ApplyToAll":"1"});
							$.ajax({type: "POST", url: $("#js-frm-saveadditionaldetails").attr('action'), data: $data, success: function($jsonD)
							{
									$($save_button).linkbutton({text:'Save'});
									$($save_button).parent().find("span#savingadditionaldetails:first").remove();
									// $.messager.alert('Messager', 'Additional details saved!');
									var $obj = $.parseJSON($jsonD);
									$.messager.alert('Messager', $obj.message);
							}});
					},iconCls:'icon-save',width:90});
					$("#js-cancel-button").linkbutton({onClick:function(){closeWindow($("#js-additional-details-window"), 'destroy');},iconCls:'icon-cancel',width:90});
					$('#js-additional-details-window').dialog('open');
			}

			var removeParticipant = function($closestTR, $id)
			{
					$($closestTR).find('td:last').append('<img id="deleting" src="/img/waiting.gif" border="0"/>&nbsp;deleting...');
					$.ajax({async:true, type:'POST', dataType:'json', url: '/offering_participants/remove', data:{'id':$id},
							success:function(data)
							{
								if(!Boolean(data.isError))
								{
										$($closestTR).fadeOut('fast', function()
										{
												$(this).remove();
												$("#js-participants-count").empty();
												$("#js-participants-count").html($('#offerParticipantList').find('tr').length);
										});
								}
							}, error: function(xhr, status, error) { $('#overlay').fadeOut('fast'); $.messager.alert('Messager', 'Action not allowed.'); }
					});
			}
			// ------------------------------------------------
});
