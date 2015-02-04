function searchIdNumber(idClient, screenName){
    $.get("https://graph.facebook.com/" + screenName)
            .then(function(data) {
                if (typeof (data.id !== 'indefined'))
                    arrClienti[idClient].idNumberFacebook = data.id;
                
                startSocialStream(idClient);                
            });
}

function callFacebookData(idFacebook, idPlace, containerHeight, containerWidth) {
    var descFan = 'fan';
    var descPta = 'pta';
    var descDailyPost = 'daily posts*';
    var descAvgShares = 'avg shares*';
    var descAvgLikes = 'avg likes*';
    var strUrl = "https://graph.facebook.com/";
    var strAccessToken = "CAACYl6Cug18BALs5veQLOmDZBwdClbvwnCt1sZBOckPLTK22XlRd2hVpdoZBAicLwVHEknf6NZBYjZCZBzsYOfEpBKQhigGGHITTfx9dCN0AmIuxlOjHYhvvhPiz6UsNu2pPjsOQOhrTJ8YjQUY6yKLv67V8ewoDqRhmA1XFiOJxtRtvseA1n351S28n38taEZD";
    var strRequestType = "/posts?access_token=";
    var rows = [];
    var totalShares = 0;
    var totalLikes = 0;
    if (typeof (containerWidth) === "undefined") containerWidth = 850;
    if (typeof (containerHeight) === "undefined") containerHeight = 314;

    //this is the first call and it works
    $.get(strUrl + idFacebook)
            .then(function(data) {
                rows.push(
                        {des: descFan, val: data.likes},
                {des: descPta, val: data.talking_about_count}
                );
            });
    //this is the asyncronous request 1.THE FIRST ACTION
    $.get(strUrl + idFacebook + strRequestType + strAccessToken)
            //this is the first promise 2.THE SECOND ACTION
            .then(function(returned) {
                var innerUrls = [];
        var nPost = returned.data.length;
        var t1 = new Date(returned.data[nPost-1].created_time);
        var t2 = new Date(returned.data[0].created_time);
                for (var i = 0; i < returned.data.length; i++) {    //questi sono i 25 post iniziali
                    returned.data[i].shares ? totalShares += returned.data[i].shares.count : totalShares += 0;  //sono gli share del post i
                    returned.data[i].likes ? totalLikes += returned.data[i].likes.data.length : totalLikes += 0;   //20140214 modificata
                    returned.data[i].likes ? innerUrls.push(returned.data[i].likes.paging.next) : "";  //20140214 modificata
                }
                rows.push(
                        {des: descDailyPost, val: (nPost/((t2-t1)/(24*3600*1000)))},
                {des: descAvgShares, val: totalShares/nPost},
                {des: descAvgLikes, val: totalLikes});
                drawDataTable(rows, '#'+idPlace);
                for (var iN = 0; iN < innerUrls.length; iN++) {
                    //this is the second asyncronous request - 1.do call and create a promise
                    $.get(innerUrls[iN])
                            //this is the first promise of the second async.
                            .then(function(innerData) {
                                //innerData.paging.next ? innerUrls.push(innerData.paging.next) : "";
                                innerData.paging ? innerUrls.push(innerData.paging.next) : "";
                                innerData.data ? totalLikes += innerData.data.length : totalLikes +=0;

                                //$('#val_likesfbTable').text(fixDecimal(totalLikes/nPost));
                                $('#val'+descAvgLikes.replace(/\#|\*/g,"").replace(/\s/g,'_')+idPlace).text(fixDecimal(totalLikes/nPost));

                            }, function(error) {
                                alert("Error! : " + error.toString());
                            });
                }
            });
}
