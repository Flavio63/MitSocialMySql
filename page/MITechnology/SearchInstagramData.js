function callInstagramData(idInstagram, idPlace){
    var url = "https://api.instagram.com/v1/users/";
    var accessToken = "&access_token=552439730.1fb234f.077dbbdcf29347bea52260d1b642daed";
    var strRequest = url + "search?q=" + idInstagram + accessToken;
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest,
        success: function(data) {
            callInstaData(url, data.data[0].id, accessToken, idPlace);
/*            for (var i = 0; i < data.data.length; i++){
                if (data.data[i].id){
                    callInstaData(data.data[i].id);
                }
            }
*/
        },
        error: function(richiesta, stato, errori) {
            alert("e' avvenuto un errore. Richiesta: " + richiesta + ". Stato della chiamata: " + stato + ". Errore: " + errori);
        }
    }); //end ajax block
}

function callInstaData(url, id, accessToken, idPlace){
    var strRequest = url + id + "?" + accessToken;
    var rows = [];
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest,
        success: function(data) {
            rows.push(
                    {des:'uploads', val:data.data.counts.media},
                    {des:'followers', val:data.data.counts.followed_by},
                    {des:'following', val:data.data.counts.follows}
            );
            retrieveThumbnail(url, id, accessToken, rows, idPlace);
        },
        error: function(richiesta, stato, errori) {
            alert("e' avvenuto un errore. Richiesta: " + richiesta + ". Stato della chiamata: " + stato + ". Errore: " + errori);
        }
    }); //end ajax block
}

function retrieveThumbnail(url, id, accessToken, rows, idPlace){
    var strRequest = url + id + '/media/recent/?' + accessToken;
    var totalLikes = 0;
    //var thumbNails = [];
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest,
        success: function(data) {
            var i = 0;
            for (i; i < data.data.length; i++){
                totalLikes += data.data[i].likes.count;
                //20131014 inserito l'id dell'immagine prima era: thumbNails.push(data.data[i].images.thumbnail.url);
                //thumbNails.push({link:data.data[i].link, url:data.data[i].images.thumbnail.url});
            }
            rows.push(
                {des:'avg likes*', val:totalLikes/i}
            );
            //drawThumbnails(thumbNails, "#boxInstagram");
            drawDataTable(rows, '#' + idPlace);
            //$('#notaInstagram').text('*: about last ' + i + ' photos');
        },
        error: function(richiesta, stato, errori) {
            alert("e' avvenuto un errore. Richiesta: " + richiesta + ". Stato della chiamata: " + stato + ". Errore: " + errori);
        }
    }); //end ajax block    
}
