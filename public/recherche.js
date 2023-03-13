$(document).ready(function() {
    $('#recherche button').prop('disabled', !check_champs());

    $('#recherche input').change(function() {
        $('#recherche button').prop('disabled', !check_champs());
    });

    $('#recherche input').keyup(function() {
        $('#recherche button').prop('disabled', !check_champs());
    });

    function check_champs(){
        let champsTexte = $('#recherche_lieuDepart,#recherche_lieuArrivee').filter((index, input) => input.value.length > 0).length;
        return champsTexte || Date.parse($('#recherche_dateDepart').val());
    }  
});