function callTwitterData(idTwitter, idPlace){
    var descFollowers = 'followers';
    var descFollowing = 'following';
    var descTweets = 'tweets';
    var descDailyTweets = 'daily tweets*';
    var descAvgRetweeted = 'avg retweeted*';
    var strUrl = "http://serviziweb.mediaitalia.it/tweet/twitterfeed.php?clientName=" + idTwitter + "&limit=25";
    var strRequest = "bridge.php?URL=" + strUrl;
    var rows = [];
    //alert("callTwitterData di " + idTwitter + " --> " + strRequest);
    $.ajax({
        type: "GET",
        crossDomain: true,
        dataType: "text",
        cache: "false",
        url: strRequest,
        success: function(data) {
            var x = jQuery.parseJSON(data);
            //alert("callTwitterData di " + idTwitter + " --> " + x.length);
            var t1 = new Date(x[x.length-1].created_at);
            var t0 = new Date(x[0].created_at);
            var nRetweet = 0;
            for (var i=0; i<x.length; i++){
                nRetweet = nRetweet + x[i].retweet_count;
            }
            rows.push(
                    {des:descFollowers, val:x[0].user.followers_count},
                    {des:descFollowing, val:x[0].user.friends_count},
                    {des:descTweets, val:x[0].user.statuses_count},
                    {des:descDailyTweets, val: (x.length/((t0-t1)/(24*3600*1000)))},
                    {des:descAvgRetweeted, val: (nRetweet/x.length)}
                    );
            drawDataTable(rows, '#' + idPlace);
        },
        error: function(richiesta, stato, errori) {
            alert("e' avvenuto un errore. Richiesta: " + richiesta + ". Stato della chiamata: " + stato + ". Errore: " + errori);
        }
    }); // end of ajax block
}
