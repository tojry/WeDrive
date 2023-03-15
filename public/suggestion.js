function suggestionVille(texte, divName, path){
    $.ajax({
        url: path, 
        data: JSON.stringify({texte: texte}),
        method: 'POST',
        contentType: 'application/json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function (response) 
        {    
            $(".autocomplete-items").remove();
            $(('#autocomplete_'+divName)).append(response);
        },
        statusCode: {
            100: function(response) {
                console.log(response.responseText);
                $(".autocomplete-items").remove();
            },
            400: function(response) {
                    console.log(response.responseText)
                }   
        }
    });
}