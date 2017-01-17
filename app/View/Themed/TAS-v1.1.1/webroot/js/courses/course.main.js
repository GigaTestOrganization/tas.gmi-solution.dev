$(function()
{
    $(".ckEditors").each(function()
    {
        CKEDITOR.disableAutoInline = true;
        CKEDITOR.inline($(this).attr('name'));
        // CKEDITOR.replace($(this).attr('name'));
    });

    $("#CourseCategoryID").combotree({required: true,
                                      url: $("#CourseCategoryID").data('source-url'),
                                      method: 'post',
                                      onLoadSuccess: function(e)
                                                     {
                                                        var t = $('#CourseCategoryID').combotree('tree');
                                                        var node = t.tree('getSelected');
                                                        if(node!=null) t.tree('expandTo',node.target);
                                                     }
                                    });

		var $cpanel = $("#CourseCategoryID").combotree('panel');
    $cpanel.resizable({onResize:function(){$cpanel.panel('panel')._outerWidth($cpanel.outerWidth()+2);},onStopResize:function(){$cpanel.panel('resize',{width:$cpanel.outerWidth(),height:$cpanel.outerHeight()});}});

    $("a#js-btnValidateBeforeSubmit").click(function($e)
    {
        $e.preventDefault();
        if($($(this).data('target')).form('validate')) $($(this).data('target')).submit();
    });
});
