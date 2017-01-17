$(function()
{
			//Initial load of page
		sizeContent();

		//Every resize of window
		$(window).resize(sizeContent);

		//Dynamically assign height
		function sizeContent()
		{
		    $newHeight = $("html").height() - $(".navbar").height() - $("._head").height() - $(".actionbar").height() - 100 + "px";
		    $("#workspace").css("height", $newHeight);
		}

		// -------------- Actions ------------
		$("#js-search-events").click(function($e)
		{
				$e.preventDefault();
				var $date_start = $('#js-date-start').datebox('getValue');
				var $date_end = $('#js-date-end').datebox('getValue');
				if($date_start!='') window.location.href = $(this).data('url')+'/'+$date_start+($date_start!=$date_end?"/"+$date_end:"");
		});

		// ------------- Date Box ---------------
		$.fn.datebox.defaults.formatter = function(date){ var y = date.getFullYear(); var m = date.getMonth()+1; var d = date.getDate(); return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d); };
		$.fn.datebox.defaults.parser = function(s){ if(!s) return new Date(); var ss = (s.split('-')); var y = parseInt(ss[0],10); var m = parseInt(ss[1],10); var d = parseInt(ss[2],10); if(!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y,m-1,d); else return new Date(); };
		$("#js-date-start").datebox({required:true,width:120,prompt:'date start'});
		$("#js-date-end").datebox({required:true,width:120,prompt:'date end'});
		/* ------------- Date Box ------------ */
});
