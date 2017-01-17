/*---LEFT BAR ACCORDION----*/
$(function() {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: false,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
        classExpand: 'dcjq-current-parent'
    });
});

var Script = function () {

//    sidebar dropdown menu auto scrolling

    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if(diff>0)
            $("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            $("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });

//    sidebar toggle

    $(function() {
        function responsiveView() {
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#container').addClass('sidebar-close');
                $('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                $('#container').removeClass('sidebar-close');
                $('#sidebar > ul').show();
            }
        }
        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });

    $('.fa-bars').click(function () {
        if ($('#sidebar > ul').is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $('#sidebar').css({
                'margin-left': '-210px'
            });
            $('#sidebar > ul').hide();
            $("#container").addClass("sidebar-closed");
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $('#sidebar > ul').show();
            $('#sidebar').css({
                'margin-left': '0'
            });
            $("#container").removeClass("sidebar-closed");
        }
    });

// widget tools

    $('#accordion1_1').on('show.bs.collapse', function() {
        $("#colfa1").addClass('fa-minus-circle').removeClass('fa-plus-circle');
    }).on('hide.bs.collapse', function() {
        $("#colfa1").addClass('fa-plus-circle').removeClass('fa-minus-circle');
    });

    $('#accordion1_2').on('show.bs.collapse', function() {
        $("#colfa2").addClass('fa-minus-circle').removeClass('fa-plus-circle');
    }).on('hide.bs.collapse', function() {
        $("#colfa2").addClass('fa-plus-circle').removeClass('fa-minus-circle');
    });

    $('#accordion1_3').on('show.bs.collapse', function() {
        $("#colfa3").addClass('fa-minus-circle').removeClass('fa-plus-circle');
    }).on('hide.bs.collapse', function() {
        $("#colfa3").addClass('fa-plus-circle').removeClass('fa-minus-circle');
    });

    $('#accordion1_4').on('show.bs.collapse', function() {
        $("#colfa4").addClass('fa-minus-circle').removeClass('fa-plus-circle');
    }).on('hide.bs.collapse', function() {
        $("#colfa4").addClass('fa-plus-circle').removeClass('fa-minus-circle');
    });

    $('#accordion1_5').on('show.bs.collapse', function() {
        $("#colfa5").addClass('fa-minus-circle').removeClass('fa-plus-circle');
    }).on('hide.bs.collapse', function() {
        $("#colfa5").addClass('fa-plus-circle').removeClass('fa-minus-circle');
    });

//    tool tips

    $('.tooltips').tooltip();

//    popovers

    $('.popovers').popover();


}();
