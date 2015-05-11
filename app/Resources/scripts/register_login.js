$(document).ready(function()
{

    $(".tab").click(function()
    {
        var X=$(this).attr('id');

        if(X=='signup')
        {
            $("#login").removeClass('select');
            $("#signup").addClass('select');
            $("#loginbox").hide();
            $("#signupbox").show();
        }
        else
        {
            $("#signup").removeClass('select');
            $("#login").addClass('select');
            $("#signupbox").hide();
            $("#loginbox").show();
        }

    });

});