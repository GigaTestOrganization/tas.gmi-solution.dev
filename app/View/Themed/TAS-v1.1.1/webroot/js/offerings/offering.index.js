$(function()
{
    $calendarViewInitialized = false;
    $(".js-viewmode").each(function()
    {
        $(this).on("click", function($evt)
        {
            $triggerBtn = $(this);
            $triggerBtn.blur();
            if(!$(this).is(":disabled"))
            {
                $(".js-viewmode").each(function(){ $(this).prop("disabled", $(this).is($triggerBtn)); });
                $(".view-pane").each(function(){ $(this).addClass("inactive"); });
                $($(this).data("target")).toggleClass("inactive");
            }

            if($(this).data("target")=='#calendar-events' && !$calendarViewInitialized)
            {
                $calendarViewInitialized = true;
                $('#calendar-events').fullCalendar({
              			header: {
              				left: 'month,basicWeek,agendaDay',
              				center: 'title',
              				right: 'today prev,next'
              			},
              			defaultDate: new Date(),
              			editable: false,
              			eventLimit: true,
                    weekNumbers: true,
                    firstDay: 1,
                    fixedWeekCount: false,
                    weekNumberCalculation: "ISO",
                    events: {url: '/offerings/index/json', error: function() { alert('Failed to load events.')	}	},
              			loading: function(bool) { $('#loading-events').toggle(bool); },
                    eventClick: function(event, jsEvent, view) { jsEvent.preventDefault(); window.open('/offerings/view/'+event.id, '_blank' ); },
                    eventRender: function(event, element)
                    {
                        var content = "<p><br/><b>Instructor(s): </b>"+event.instructors+"<br/><br/><b>Start: </b>"+eventTimeToDateFormat(event.start)+"<br/><b>End: </b>"+eventTimeToDateFormat(event.end, 1)+"<br/><br/><b>Classroom(s): </b>"+event.classrooms+"<br/><br/><b>Status: </b>"+event.status+"</p>";
                        element.qtip({content: {title: {text: "<span style=\"text-transform:uppercase;\">"+event.title+"</span>", button: false}, text: content},
                                      position: {my:'bottom left', at:'top center',	target: 'mouse'},
                                      style: 'qtip-blue qtip-rounded'});
                    }
            		});
            }
        });
    });

    var eventTimeToDateFormat = function($unixTimestamp, $offset)
    {
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var dt = new Date($unixTimestamp);
        if($offset!=null && $offset!=undefined) dt.setDate(dt .getDate()-$offset);
        var year = dt.getFullYear();
        var month = monthNames[dt.getMonth()];
        var day = dt.getDate();
        if (day < 10)  day = '0' + day;
        return month+" "+day+", "+year;
    }
});
