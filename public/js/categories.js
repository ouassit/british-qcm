

$('#add').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    $('[id$=-error]').text('');
    $('#add-error').hide();
});

$('#add').find('form').submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');
    
    $.post({
        url: actionUrl,
        data: form.serialize(),
        success :function(response) {
            console.log(response);
            $('#add-success').show();
            location.reload();
        },
        error: function(e) {
            console.log(e.responseJSON);
            $('#add-error').text(e.responseJSON.message);
            for(var key in e.responseJSON.errors){
                console.log($('#'+key+'-error'));
                form.find('#'+key+'-error').text(e.responseJSON.errors[key][0]);
            }
            $('#add-error').show();
        }
    });

});

$('#edit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    var action = button.data('action');
    var actionGet = button.data('action-get');
    $('[id$=-error]').text('');
    $('#edit-error').hide();
    modal.find('form').find(':not(input[type="hidden"])').val('');
    modal.find('form').attr('action', action);
    $.get(actionGet, function(data, status){
        for(var key in data){
            modal.find('form').find('#'+key).val(data[key]);
        }
    });
});

$('#edit').find('form').submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');
    
    $.ajax({
        type: 'PUT',
        url: actionUrl,
        data: form.serialize(),
        success :function(response) {
            console.log(response);
            $('#edit-success').show();
            location.reload();
        },
        error: function(e) {
            console.log(e.responseJSON);
            $('#edit-error').text(e.responseJSON.message);
            for(var key in e.responseJSON.errors){
                form.find('#'+key+'-error').text(e.responseJSON.errors[key][0]);
            }
            $('#edit-error').show();
        }
    });

});



$('#delete').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var action = button.data('action') 
    var modal = $(this)
    $('#delete-error').hide();
    $('#delete-success').hide();
    modal.find('form').attr('action', action);
});

$('#delete').find('form').submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');
    
    $.post({
        url: actionUrl,
        data: form.serialize(),
        success :function(response) {
            console.log(response);
            $('#delete-success').show();
            location.reload();
        },
        error: function(e) {
            console.log(e.responseText);
            $('#delete-error').show();
        }
    });
    
});

