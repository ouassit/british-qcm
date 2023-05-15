
$(document).ready(function(){
    
});

$('#addmultiple').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    $('[id$=-error]').text('');
    $('#addmultiple-error').hide();
    modal.find('tr:gt(0)').remove();
    modal.find('form')[0].reset();
});

$('#addmultiple').find('form').submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action'); 
    var actionMethod = form.attr('method'); 

    $.ajax({
        method: actionMethod,
        url: actionUrl,
        data: form.serialize(),
        success :function(response) {
            console.log(response);
            $('#addmultiple-success').show();
            location.reload();
        },
        error: function(e) {
            console.log(e);
            if(e.responseJSON){
                $('#addmultiple-error').text(e.responseJSON.message);
                for(var key in e.responseJSON.errors){
                    console.log($('#'+key+'-error'));
                    form.find('#'+key+'-error').text(e.responseJSON.errors[key][0]);
                }
            }else{
                $('#addmultiple-error').text(e.statusText);
            }
            $('#addmultiple-error').show();
        }
    });

});

$('#add').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    $('[id$=-error]').text('');
    $('#add-error').hide();
    modal.find('tr:gt(0)').remove();
    modal.find('form')[0].reset();
});

$('#add').find('form').submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action'); 

    $.ajax({
        url: actionUrl,
        data: form.serialize(),
        success :function(response) {
            console.log(response);
            $('#add-success').show();
            location.reload();
        },
        error: function(e) {
            if(e.responseJSON){
                $('#add-error').text(e.responseJSON.message);
                for(var key in e.responseJSON.errors){
                    console.log($('#'+key+'-error'));
                    form.find('#'+key+'-error').text(e.responseJSON.errors[key][0]);
                }
            }else{
                $('#add-error').text(e.statusText);
            }
            $('#add-error').show();
        }
    });

});

$('#edit').find('form').submit(function(e) {

    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action'); 
    var actionMethod = form.attr('method'); 

    $.ajax({
        method: actionMethod,
        url: actionUrl,
        data: form.serialize(),
        success :function(response) {
            console.log(response);
            $('#edit-success').show();
            location.reload();
        },
        error: function(e) {
            if(e.responseJSON){
                $('#edit-error').text(e.responseJSON.message);
                for(var key in e.responseJSON.errors){
                    console.log($('#'+key+'-error'));
                    form.find('#'+key+'-error').text(e.responseJSON.errors[key][0]);
                }
            }else{
                $('#edit-error').text(e.statusText);
            }
            $('#edit-error').show();
        }
    });

});

$('a[name="add"]').click(function (e) {
    var button = $(this);
    $('[id$=-error]').text('');
    $('#add-error').hide();
    var modal = $('#add').modal('show'); 
    $("[data-dismiss='modal']").click(function(){
        $('#add').modal("hide"); 
    });

});

$('a[name="edit"]').click(function (e) {
    var button = $(this);
    var actionGet = button.data('action-get');
    var action = button.data('action');
    $('[id$=-error]').text('');
    $('#edit-error').hide();
    var modal = $('#edit').modal('show'); 
    $("[data-dismiss='modal']").click(function(){
        $('#edit').modal("hide"); 
    });

    modal.find('form').find('#id').val(button.data('id'));
    modal.find('form').attr('action', action);

    $.get(actionGet, function(data, status){
        console.log(data);
        for(var key in data){            
            if(modal.find('form').find('#'+key).is(':checkbox')){
                modal.find('form').find('#'+key).prop('checked', data[key]);
            } else if(modal.find('form').find('#'+key).is("input")){
                modal.find('form').find('#'+key).val(data[key]);
            } 
            else if(modal.find('form').find('#'+key).is("textarea")){
                modal.find('form').find('#'+key).val(data[key]);
            }
            else if(modal.find('form').find('#'+key).is("select"))
                modal.find('form').find('#'+key +' option[value="'+data[key]+'"]').prop('selected', true);
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

