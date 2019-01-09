$('[name="newsletter"]').click(function() {
    var email = $('[name="newsletter_email"]').val();
    
    if(email) {
        $('[name="newsletter"]').html('<i class="fa fa-spinner fa-spin"></i> Inscription en cours');
        $('[name="newsletter"]').prop('disabled', true);
        
        var csrf = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            type: "POST",
            url: "/api/newsletter",
            data: {
                email: $('[name="newsletter_email"]').val()
            },
            dataType: 'json',
            success: function(json) {
                if(json.status == 'success') {
                    $('[name="newsletter"]').html('Inscription effectué');
                    $('[name="newsletter"]').prop('disabled', true);
                    $('#__message-alert').remove();
                } else {
                    console.log($('[name="newsletter_email"]').val())
                    $('[name="newsletter"]').html('S\'inscrire');
                    $('[name="newsletter"]').prop('disabled', false);
                    $('#__message-alert').html('<div class="alert alert-danger">'+json.response+'</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('[name="newsletter"]').html('S\'inscrire');
                $('[name="newsletter"]').prop('disabled', false);
                console.error(textStatus + " " + errorThrown);
            }
        });
        
    } else {
        $('#__message-alert').html('<div class="alert alert-danger">Veuillez entrer une adresse e-mail</div>');
    }
});