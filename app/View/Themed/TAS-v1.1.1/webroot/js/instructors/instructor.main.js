$(function()
{
    $("a#js-btnValidateBeforeSubmit").click(function($e)
    {
        $e.preventDefault();
        if($($(this).data('target')).form('validate')) $($(this).data('target')).submit();
    });

    $('#InstructorQualification').tagsInput({width:'auto'});
});
