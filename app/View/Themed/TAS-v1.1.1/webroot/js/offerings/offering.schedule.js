$(function()
{
			// -------------- Actions ------------
			$("#back_to_list_of_events").click(function($e)
			{
	            $e.preventDefault();
							window.location.href = '/offerings';
	    });

			$("#dl_training_schedule").click(function($e)
			{
	            $e.preventDefault();
							$("#training_events").submit();
	    });

			$("#js-search-schedule").click(function($e)
			{
					$e.preventDefault();
					var $event_status = $("#js-event-status").combobox('getValue');
					var $date_start = $('#js-date-start').datebox('getValue');
					var $date_end = $('#js-date-end').datebox('getValue');
					if($date_start!='')
							window.location.href = '/offerings/schedule/'+($event_status!=''?$event_status:'all')+'/'+$date_start+($date_start!=$date_end?"/"+$date_end:"");
			});

			// ------------- Date Box ---------------
			$.fn.datebox.defaults.formatter = function(date){ var y = date.getFullYear(); var m = date.getMonth()+1; var d = date.getDate(); return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d); };
			$.fn.datebox.defaults.parser = function(s){ if(!s) return new Date(); var ss = (s.split('-')); var y = parseInt(ss[0],10); var m = parseInt(ss[1],10); var d = parseInt(ss[2],10); if(!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y,m-1,d); else return new Date(); };
			$("#js-date-start").datebox({required:true,width:120,prompt:'date start'});
			$("#js-date-end").datebox({required:true,width:120,prompt:'date end'});
			/* ------------- Date Box ------------ */
});
