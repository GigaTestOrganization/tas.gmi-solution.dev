$(function()
{
    "use strict";
    $("html").niceScroll({styler:"fb",cursorwidth:'10'});


    // Initialize Tool Tips
    $('.tool_tips').each(function()
    {
        $(this).css('cursor', 'default');
        $(this).tooltip({
            position: 'top',
            showDelay: 700,
            content: '<span style="color:#333;">'+$(this).attr('title')+'</span>',
            onShow: function(){ $(this).tooltip('tip').css({backgroundColor: '#EBFAFF', borderColor: '#2EB8E6','z-index': 999999}); }
        });
    });
    // ----------------------

    /* Open URL */
    $(".js-open-url").each(function()
    {
        $(this).click(function($e)
        {
            $e.preventDefault();
            window.location.href = $(this).data('href');
        });
    });
    // ----------------------------
});
