'use strict';
$(document).ready(function(){$('.alert').addClass('in').fadeOut(4500);

/* swap open/close side menu icons */
$('[data-toggle=collapse]').click(function(){
  	// toggle icon
  	$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-down');
});
});

$(document).ready(function(){
    $('#order_button').attr('disabled', false);
    $('#reserve_button').attr('disabled', false);
    $('#return_button').attr('disabled', false);
    $('#order_update_button').attr('disabled', false);
});

//AJAX for Order/Reservation buttons
$(document).ready(function() {
    var id = $('#entity_id').text();

    $('#order_button').click(function (ev) {
        $.ajax({
            type: 'POST',
            url: '/order/'+ id,
            data: {'id': id}
        })
            .success(function (data) {
                $('#query_result').text(data.quantity);
                $('#ajax_message').text(data.message);
                $('#order_button').attr('disabled', true).hide();
                $('.return_button').show().one('click', function(){
                    $(this).attr('disabled', true);
                });
            })
            .fail(function (errorThrown) {
                console.log(errorThrown);
                $('#ajax_message').text('Something goes wrong, try again later');
            });
        ev.preventDefault();
        });


    $('#return_button').click(function (ev) {
        $.ajax({
            type: 'POST',
            url: '/order/return/' + id,
            data: {'id': id}
        })
            .success(function (data) {
                $('#query_result').text(data.quantity);
                $('#ajax_message').text(data.message);
                $('#return_button').attr('disabled', true);
            })
            .fail(function (errorThrown) {
                console.log(errorThrown);
                $('#ajax_message').text('Something goes wrong, try again later');
            });
        ev.preventDefault();
    });

    $('#order_update_button').click(function (ev) {
        $.ajax({
            type: 'PUT',
            url: '/order/update/' + id,
            data: {'id': id}
        })
            .success(function (data) {
                $('#ajax_message').text(data.message);
                $('#query_result').text(data.quantity);
                $('#order_update_button').attr('disabled', true);
            })
            .fail(function (errorThrown) {
                console.log(errorThrown);
                $('#ajax_message').text('Something goes wrong, try again later');
            });
        ev.preventDefault();
    });

    $('#reserve_button').click(function (ev) {
        $.ajax({
            type: 'POST',
            url: '/order/reserve/' + id,
            data: {'id': id}
        })
            .success(function (data) {
                $('#query_result').text(data.quantity);
                $('#ajax_message').text(data.message);
                $('#reserve_button').attr('disabled', true);

            })
            .fail(function (errorThrown) {
                console.log(errorThrown);
                $('#ajax_message').text('Something goes wrong, try again later');
            });
        ev.preventDefault();
    });
});
$(document).ready(function() {

    $('.ajax_cat').click(function (ev) {
        $.ajax({
            type: 'POST',
            url: '/category/' + ($(this).text()),
            data: {'categoryName': ($(this).text())}
        })
            .success(function (jsondata) {
                $('#main_list').html(jsondata.books);
            })
            .fail(function (errorThrown) {
                console.log(errorThrown);
            });
        ev.preventDefault();
    });
});


