$(function()
{
    $("a#js-btnValidateBeforeSubmit").click(function($e)
    {
        $e.preventDefault();
        if($($(this).data('target')).form('validate')) $($(this).data('target')).submit();
    });

    $('#LessonTag').tagsInput({width:'auto'});
    
    $(document).on("click", "a.addlink", function(e)
    {
        e.preventDefault();
        if(!$(this).attr('disabled'))
        {
            var $timestamp = new Date().getTime();
            $("div#ltm_lst").append('<div class="btn-g" id="ltm"><input name="data[link_to_material][]" id="'+$timestamp+'" type="text" class="easyui-textbox" data-options="validType:\'url\'" style="width:93%;"/> <a href="/" class="btn btn-xs btn-success addlink"><span class="glyphicon glyphicon-plus-sign"></span></a> <a href="/" class="btn btn-xs btn-warning removelink"><span class="glyphicon glyphicon-minus-sign"></span></a></div>');
            $("#"+$timestamp).textbox();
            $(this).attr('disabled', 'disabled');
        }
    });

    $(document).on("click", "a.removelink", function(e)
    {
        e.preventDefault();
        $(this).parent('div#ltm').remove();
        $ltms = $("div#ltm_lst").children('div#ltm');
        $($ltms[$ltms.length-1]).find("a.addlink:first").removeAttr('disabled');
        if(!$("div#ltm_lst").children('div#ltm').length)
        {
            var $timestamp = new Date().getTime();
            $("div#ltm_lst").append('<div class="btn-g" id="ltm"><input name="data[link_to_material][]" id="'+$timestamp+'" type="text" class="easyui-textbox" data-options="validType:\'url\'" style="width:93%;"/> <a href="/" class="btn btn-xs btn-success addlink"><span class="glyphicon glyphicon-plus-sign"></span></a> <a href="/" class="btn btn-xs btn-warning removelink"><span class="glyphicon glyphicon-minus-sign"></span></a></div>');
            $("#"+$timestamp).textbox();
        }
    });
});
