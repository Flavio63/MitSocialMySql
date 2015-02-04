function callYoutubeData(idClient, idPlace){
    var strRequest = 'http://gdata.youtube.com/feeds/api/users/' + idClient;
    var uploads = 0;
    var subscriberCount = 0;
    var totalUploadViews = 0;
    
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest + '?alt=json',
        success: function(data) {
            if (data.entry.gd$feedLink[4].countHint)
                uploads = data.entry.gd$feedLink[4].countHint;
            if (data.entry.yt$statistics) {
                subscriberCount = data.entry.yt$statistics.subscriberCount ? Number(data.entry.yt$statistics.subscriberCount) : 0;
                totalUploadViews = data.entry.yt$statistics.totalUploadViews ? Number(data.entry.yt$statistics.totalUploadViews) : 0;
            }
            callLastYoutubeUpLoad(uploads, totalUploadViews, subscriberCount, strRequest, idPlace);
        },
        error: function(richiesta, stato, errori) {
            alert("e' avvenuto un errore. Richiesta: " + richiesta + ". Stato della chiamata: " + stato + ". Errore: " + errori);
        }
    }); //end ajax request
    
}

function callLastYoutubeUpLoad(uploads, totalUploadViews, subscriberCount, strRequest, idPlace){
    var descUploads = 'uploads';
    var descViews = 'views';
    var descSubscribers = 'subscribers';
    var descLastViews = 'last views';
    var descAvgRating = 'avg rating*';
    var descRaters = 'n raters*';
    
    var viewCount = 0;
    var avgRaiting = 0;
    var numRaters = 0;
    var numVideoRated = 0;
    
    var rows = [];
    strRequest += "/uploads?alt=json";
    // the last 25 uploads
    $.ajax({
        type: "GET",
        dataType: "jsonp",
        cache: "false",
        url: strRequest,
        success: function(data) {
            for (var i = 0; i < data.feed.entry.length; i++) {
                if (data.feed.entry[i].gd$rating){
                    avgRaiting = avgRaiting + (data.feed.entry[i].gd$rating.average * data.feed.entry[i].gd$rating.numRaters);
                    numRaters = numRaters + data.feed.entry[i].gd$rating.numRaters;
                    numVideoRated++ ;
                }
                viewCount = viewCount + Number(data.feed.entry[i].yt$statistics.viewCount);
            }
            if (avgRaiting > 0){avgRaiting = avgRaiting / numRaters;} else {avgRaiting = 'NaN';}
            //drawChart(avgRaiting, numRaters, viewCount, numVideoRated);
            rows.push(
                    {des:descUploads, val:uploads},
                    {des:descViews, val:totalUploadViews},
                    {des:descSubscribers, val:subscriberCount},
                    {des:descLastViews, val:viewCount},
                    {des:descAvgRating, val:avgRaiting},
                    {des:descRaters, val:numRaters}
            );
            drawDataTable(rows, '#' + idPlace);
        },
        error: function(richiesta, stato, errori) {
            alert("e' avvenuto un errore. Richiesta: " + richiesta + ". Stato della chiamata: " + stato + ". Errore: " + errori);
        }
    }); //end ajax block
    

}
