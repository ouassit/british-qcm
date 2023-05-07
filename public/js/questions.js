
$(document).ready(function(){
    
});

function addItem(values){
    var tr = $('#choice-item tr').clone();
    console.log(tr);
    if(values!=null){
        for(var key in values){
            if(tr.find('[name="'+key+'[]"]').is(':radio'))
                tr.find('[name="'+key+'[]"]').prop('checked', values[key]);
            else
                tr.find('[name="'+key+'[]"]').val(values[key]);
        }
    }
    $('#add').find('#choices tbody').append(tr);
    tr.find('[name="correct[]"]').attr('value', $.now());
    tr.find('select').uniqueId();
}

$(document).on('click','a[name="delete-row"]',  function(e){
    e.preventDefault();
    $(this).closest('tr').remove();
});

$('#add').find('#add-choice').click(function(e){
    e.preventDefault();
    addItem(null);
    return false;
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
    var actionMethod = form.attr('method'); 

    var formData = form.serializeArray();
    var newdata = [];
    $.each(formData, function (index, value) {
        var data_name = formData[index].name;
        var data_value = formData[index].value;
        if (data_name !== "correct[]") {
            newdata.push({'name':data_name, 'value': data_value});
        }
    });
    $(this).find("[name='correct[]']").each(function(){
        newdata.push({'name':'correct[]', 'value': $(this).is(':checked') ? 1 : 0});
    });
    

    var data = '';
    for (let index = 0; index < newdata.length; index++) {
        const element = newdata[index];
        data += element.name+'='+element.value+'&';
    }

    $.ajax({
        method: actionMethod,
        url: actionUrl,
        data: data,
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

$('a[name="edit"], a[name="add"]').click(function (e) {
    var button = $(this);
    var action = button.data('action');
    var actionGet = button.data('action-get');
    $('[id$=-error]').text('');
    $('#add-error').hide();
    var modal = $('#add').modal('show'); 
    $("[data-dismiss='modal']").click(function(){
        $('#add').modal("hide"); 
    });
    modal.find('form').attr('action', action);

    if(button.attr('name')=='add'){
        modal.find('form').attr('method', 'POST');
    } else {
        modal.find('form').attr('method', 'PUT');
        modal.find('form').find('#id').val(button.data('id'));
        $.get(actionGet, function(data, status){
            console.log(data);
            for(var key in data){            
                if(modal.find('form').find('#'+key).is("input")){
                    modal.find('form').find('#'+key).val(data[key]);
                } 
                else if(modal.find('form').find('#'+key).is("textarea")){
                    modal.find('form').find('#'+key).val(data[key]);
                }
                else if(modal.find('form').find('#'+key).is("select"))
                    modal.find('form').find('#'+key +' option[value="'+data[key]+'"]').prop('selected', true);
            }
            // For choices
            for(var i =0 ; i< data['choices'].length; i++){
                addItem(data['choices'][i]);
            }
        });
    }

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

