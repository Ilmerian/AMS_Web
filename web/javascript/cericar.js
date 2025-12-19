
$(function() {
    $('#form-recherche').on('submit', function(event) {
        
        event.preventDefault(); // Empêcher la fenêtre de se raffraichir
        
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize(); 
        
        $('#tableau_resultats').css('opacity', '0.5');

        $.post(url, data)
            .done(function(response) {
                $('#tableau_resultats').html(response.html); //on met dans la div du tableau la réponse
                $('#tableau_resultats').css('opacity', '1');
                
                var notif = $('#notification');
                notif.text(response.notification);

                notif.removeClass('alert-success alert-warning alert-danger');
                if (response.type === 'warning') {
                    notif.addClass('alert-warning'); 
                } else {
                    notif.addClass('alert-success');
                }
                
                notif.fadeIn().delay(3000).fadeOut();
            })
            .fail(function() {
                alert("Erreur lors de la recherche Ajax");
                $('#tableau_resultats').css('opacity', '1');
            });
            
        return false;
    });

    $(document).on('click', '.btn-reserve', function() {
        
        var bouton = $(this);
        var voyageId = bouton.data('voyage-id'); // récup l'id du voyage
        var nbPlaces = bouton.data('nb-places'); // récup le nombre de places demandées
        
        bouton.prop('disabled', true).text('En cours...');

        // Ajax vers réserver du controller 
        $.post('index.php?r=voyage/reserver', {
            voyage_id: voyageId,
            nb_places: nbPlaces
        })
        .done(function(response) {
            var notif = $('#notification');
            
            if (response.success) {
                notif.text(response.message)
                     .removeClass('alert-warning alert-danger')
                     .addClass('alert-success')
                     .fadeIn().delay(3000).fadeOut();
                
                bouton.removeClass('btn-outline-primary')
                      .addClass('btn-success')
                      .text('Réservé !');
            } else {
                notif.text(response.message)
                     .removeClass('alert-success')
                     .addClass('alert-danger')
                     .fadeIn().delay(4000).fadeOut();
                
                bouton.prop('disabled', false).text('Réserver');
            }
        })
        .fail(function() {
            alert("Erreur technique lors de la réservation.");
            bouton.prop('disabled', false).text('Réserver');
        });
    });
});