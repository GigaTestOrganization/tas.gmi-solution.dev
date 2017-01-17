$(function()
{
    $("#OfferingCourseID").combotree({url:'/course_categories/generatejsontreestructure/1',
                                      method:'post',
                                      prompt:'-- choose course --',
                                      onBeforeSelect: function(node)
                                                      {
                                                          if(!node.attributes.hasOwnProperty('course_category_id'))
                                                              return false;
                                                      }
                                    });

		var $cpanel = $("#OfferingCourseID").combotree('panel');
		$cpanel.resizable({onResize:function(){$cpanel.panel('panel')._outerWidth($cpanel.outerWidth()+2);},onStopResize:function(){$cpanel.panel('resize',{width:$cpanel.outerWidth(),height:$cpanel.outerHeight()});}});

		$('#filtertrainingsummary').click(function(evt)
		{
  			evt.preventDefault();
  			var course_id = $('#OfferingCourseID').combotree('getValue');
  			var year = $('#OfferYearStart').numberspinner('getValue');
  			if((course_id!=undefined&&course_id!=null&&course_id!='') || (year!=undefined&&year!=null&&year!=''))
  				  window.location.href = $(this).attr('href')+(course_id!=undefined&&course_id!=null&&course_id!=''?'/'+course_id.split('-CORS')[0]:'/year')+(year!=undefined&&year!=null&&year!=''?'/'+year:'');
  			$(this).blur();
		});
});
