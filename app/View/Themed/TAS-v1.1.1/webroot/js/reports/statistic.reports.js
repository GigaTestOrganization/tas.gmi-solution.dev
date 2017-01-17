$(function(){
    $("#filtercumulativeparticipants").on("click", function($evt)
    {
        $evt.preventDefault();
        window.location.href = $(this).data('url')+'/'+$("#yearStart").numberspinner('getValue')+'/'+$("#yearEnd").numberspinner('getValue');
    });
});
