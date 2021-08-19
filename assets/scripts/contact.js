function sendContact()
{
    $.post('/statice/contact_send/', $("#contact-form").serialize(), function(data){                 
        var response = jQuery.parseJSON(data);
        if (response && response['errors']) {
          $('#contact-errors').fadeIn('slow').html(response['errors']);                  
        }
        else if (response && response['succes']) {
            $('#contact-form').trigger("reset");
            $('#contact-form').hide();
            $('#contact-errors').hide();
            $('#contact-success').fadeIn('slow').html(response['succes']);            
        }
    });    
}
