function searchFacebookIdNumber(screenName){
    if (screenName !== "") {
    var strRequest = "https://graph.facebook.com/" + screenName;
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest,
        success: function(data){
            if (typeof (data.id !== 'undefined'))
                $("input[name='clientsocials[id_number_facebook]']").val(data.id);
        },
        error: function (){
            $("input[name='clientsocials[id_number_facebook]']").val("Errore nel recupero dell'id");
        }
    });
} else {
    alert("Inserire un nome nel campo di facebook grazie");
}
}

function searchInstagramIdNumber(screenName){
    if (screenName !== ""){
    var url = "https://api.instagram.com/v1/users/search?q=";
    var accessToken = "&access_token=552439730.1fb234f.077dbbdcf29347bea52260d1b642daed";
    var strRequest = url  + screenName + accessToken;
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest,
        success: function(data) {
            $("input[name='clientsocials[id_number_instagram]']").val(data.data[0].id);
        },
        error: function(richiesta, stato, errori) {
            $("input[name='clientsocials[id_number_instagram]']").val("Errore nel recupero dell'id");
        }
    });
}else{
    alert("Inserire un nome nel campo di instagram grazie");
}
}
