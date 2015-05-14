//AJAX login

'use strict';
$(document).ready(function()
{
    $('#_submit').click(function(e){
        e.preventDefault();
        $.ajax({
            type        : 'POST',
            url         : '/login_check',
            data        : $("form").serialize(),
            dataType    : 'json',
            success     : function(data) {
                console.log(data.message);
                if (data.route !== 'undefined') {
                    window.location.href = data.route;
                }
                if (data.message !== 'undefined') {
                    $('#error_message').text(data.message);
                }
            },
            error: function(data){
                console.log(data.message);
            }
        });
    });

});



