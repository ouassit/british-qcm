$body = $("body");

$(document).ready(function(){
    /*$('select').each(function(){
        if($(this).parents('.modal').length){
            $(this).select2({
                dropdownParent: $(this).closest('.modal')
            });
        }else{
            //if(!$(this).parents('.order-item').length)
                //$(this).select2({});
        }
    });*/
});


$(document).on({
    ajaxStart: function() { 
        $body.addClass("loading");
        $('[type="submit"]').attr('disabled','disabled');
    },
    ajaxStop: function() { 
        $body.removeClass("loading");
        $('[type="submit"]').removeAttr('disabled');
    }    
});
