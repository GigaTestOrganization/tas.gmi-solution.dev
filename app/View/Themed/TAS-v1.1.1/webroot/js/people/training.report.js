$(function()
{
		$(document).on("click", "a#addparticipant", function(e)
		{
				e.preventDefault();
				$("<div id='dd'>&nbsp;</div>").appendTo(this);
				$('#dd').dialog({title: 'Select Participants', width: 500, height: 400, closed: true, cache: false, href: '/people/select', modal: true,
												 toolbar: '#dlg-toolbar', onClose: function(){$('input:checkbox',$('#selectpeople')).removeAttr('checked');}, onLoad: assignFilterFunction,
												 buttons: '<div><a href="javascript:void(0)" id="okbtn">OK</a><a href="javascript:void(0)" id="cnclbtn">Cancel</a></div>'
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
						$('#download_transcript').removeClass('l-btn-disabled');
						var $people_already_included = "";
						$("input[type='checkbox'].individualselect:checked").map(function()
						{
								var $this = this;
								if(!$('tr td input[type="hidden"][value="'+$($this).val()+'"]',$('#participantsList')).length)
								{
										var newparticipant = $('<tr><td><input type="checkbox" value="" id="p'+$($this).val()+'"/><input type="hidden" name="person[id][]" value="'+$($this).val()+'"/></td><td><label for="p'+$($this).val()+'">'+$($($this).closest('tr')).find('td:eq(1) label').html()+' '+$($($this).closest('tr')).find('td:eq(2) label').html()+'</label></td><td><label for="p'+$($this).val()+'">'+$($($this).closest('tr')).find('td:eq(3) label').html()+'</label></td></tr>');

										$(newparticipant).hide().appendTo('#participantsList').fadeIn('slow');
								} else $people_already_included += ($.trim($people_already_included)!=""?"<br/>":"")+"- "+$($($this).closest('tr')).find('td:eq(1) label').html()+' '+$($($this).closest('tr')).find('td:eq(2) label').html();
						});
						if($.trim($people_already_included)!="") $.messager.alert('Message','The following person(s) are already included on the list.<br/><br/><p style="padding-left: 35px;">'+$people_already_included+'</p>','warning');
						$('#dd').dialog('refresh');
						closeWindow();
				}
		}
		var closeWindow = function(){ $('#dd').dialog('close'); }

		// Filter
		var assignFilterFunction = function()
		{
				$("#searchkeyword").searchbox({prompt:'type first/last name', searcher:function($value, $name){ filter(); }});
				$("#customer_id").combobox({panelHeight:'auto',onSelect:function($record){ filter();}});
		}
		var filter = function(obj){ $.post('/people/select/', {keyword:$("#searchkeyword").searchbox('getValue'), customerid:$('#customer_id').combobox('getValue')}, function(data){$('tbody#peoplelist').html(data); $("input[type='checkbox']#selectall").removeAttr("checked"); $('#okbtn').addClass('l-btn-disabled');}, 'text'); }
		//----------------------

		$(document).on('click', "input[type='checkbox']#select_all_participants", function($e)
		{
				if($($e.target).is("input[type='checkbox']#select_all_participants"))
				{
						$('tr td input:checkbox',$('#participantsList')).prop('checked',this.checked);
						toggleRemoveButton();
				}
		});
		$(document).on('click', $('tr td input:checkbox',$('#participantsList')), function($e)
		{
				if($($e.target).is($('tr td input:checkbox',$('#participantsList'))))
				{
						if($('tr td input:checkbox',$('#participantsList')).length==$('tr td input:checkbox:checked',$('#participantsList')).length)  $("input[type='checkbox']#select_all_participants").prop("checked", "checked");
						else $("input[type='checkbox']#select_all_participants").removeAttr("checked");
						toggleRemoveButton();
				}
		});
		var toggleRemoveButton = function()
		{
				if($('tr td input:checkbox:checked',$('#participantsList')).length!=0) $('#remove_button').removeClass('disabled');
				else $('#remove_button').addClass('disabled');

				if(!$('tr td input[type="hidden"][name="person[id][]"]',$('#participantsList')).length) $('#download_transcript').addClass('l-btn-disabled');
				else $('#download_transcript').removeClass('l-btn-disabled');
		}
		$('#remove_button').click(function($e)
		{
				$e.preventDefault();
				if($('tr td input:checkbox:checked',$('#participantsList')).length)
				{
						$('<div class="overlay" id="overlay" style="display:none;"></div>').appendTo('html');
						$('#overlay').fadeIn(200);
						$('tr td input:checkbox:checked',$('#participantsList')).map(function()
						{
								var $closestTR = $(this).closest('tr');
								$($closestTR).fadeOut('fast', function()
								{
										$(this).remove();
										if(!$('tr td input:checkbox:checked',$('#participantsList')).length)
										{
												$('#overlay').fadeOut('fast', function(){$(this).remove();});
												$("input[type='checkbox']#select_all_participants").removeAttr("checked");
												toggleRemoveButton();
										}
								});
						});
				}
		});

		// Download Transcript
		$('#download_transcript').addClass('l-btn-disabled');
		$('#download_transcript').click(function($e)
		{
				$e.preventDefault();
				if(!$('#download_transcript').hasClass('l-btn-disabled')) $('#list_of_people').submit();
		});

		$(".js-clicks").each(function()
		{
				$(this).click(function($e)
				{
						$e.preventDefault();
						window.location.href = $(this).data('url');
				});
		});
});
