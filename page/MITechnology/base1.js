/*var codPosition = function (){
    // this function is anonymous function, is executed immediatly
    // and the return value is assigned to codPosition
    var queryString = {};
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var v=0; v<vars.length; v++){
        var pair = vars[v].split("=");
        if ("undefined" === typeof queryString[ pair[0] ]){     // If first entry with this name
            queryString[ pair[0] ] = pair[1];
        } else if (typeof queryString[ pair[0] ] === "string"){ // If second entry with this name
            var arr = [ queryString[ pair[0] ], pair[1] ];
            queryString[ pair[0] ] = arr;
        } else {                                                // If third or later entry with this name
            queryString[ pair[0] ].push(pair[1]);
        }
    }
    return queryString;
}();

*/

$(document).ready(function($){
    //$(".Villa").slideUp(0);
    $.getJSON('index.php', {page:'returnJsonArray', id:2}, function (data){
        /*
        $.each(data, function (key, val){
            alert("this is key: " + key + " and this is his value: " + val);
        });*/
        $("#cliente").text("Social Stream " + data["name"]);
        var mergeTwitter = "";
        if (data["hashtag_twitter"] !== "") {
            mergeTwitter = data["screen_name_twitter"] + ", " + data["hashtag_twitter"];
        } else {
            mergeTwitter = data["screen_name_twitter"];
        }
            $('#social-stream').dcSocialStream({
                feeds: {
                    twitter: {id: mergeTwitter},
                    facebook: {id: data["id_number_facebook"], out: 'intro,text,user,share', text: 'content'},
                    google: {id: data["id_gplus"], api_key: 'AIzaSyC6gvbeLp3Tsl17Q446wm2LLDUOIfjaKBE'},
                    youtube: {id: data["screen_name_youtube"], thumb: '0'},
                    pinterest: {id: data["screen_name_pinterest"], out: 'intro,thumb,text,user,share'},
                    //instagram: {id: '!' + data["id_number_instagram"], accessToken: '552439730.1fb234f.077dbbdcf29347bea52260d1b642daed', clientId: '5eebf9ff3562406b9605676f00eeff50', comments: 3, likes: 10},
                    vimeo: {id: data["screen_name_vimeo"]},
                    tumblr: {id: data["screen_name_tumblr"], thumb: 250},
                    rss: {id: ""},
                    delicious: {id: ""},
                    stumbleupon: {id: ""},
                    flickr: {id: ""},
                    lastfm: {id: ""},
                    dribble: {id: ""},
                    deviantart: {id: ""}
                },
                rotate: {delay: 0},
                control: false,
                filter: true,
                wall: true,
                limit: 10,
                max: 'limit',
                iconPath: 'http://www.designchemical.com/blog/wp-content/themes/dc2011/dcsns/images/dcsns-dark/',
                imagePath: 'http://www.designchemical.com/blog/wp-content/themes/dc2011/dcsns/images/dcsns-dark/'
            }); // finish internal function
        
    }, function (err){
        alert("Some error occurs: " + err.toString());
    }); // finish getJson
}); // finish anonimous function

function flavio(obj){
    //alert("flavio --> " +obj[0].parentNode.className);
    var strParentNode = obj[0].parentNode.className;
    var strSocial = strParentNode.substr(strParentNode.indexOf("-")+1, strParentNode.length);
    //alert("flavio ---> " + strSocial);
            $(".Villa").slideUp(800);
            $(".Villa").find("tbody").empty();
    switch (strSocial){
        case "facebook":
            $(".Villa table").attr("id",strSocial);
            callFacebookData(arrClienti[idClient].screenNameFacebook, strSocial);
            $(".Villa").slideDown(400);
            break;
        case "twitter":
            $(".Villa table").attr("id",strSocial);
            callTwitterData(arrClienti[idClient].screenNameTwitter, strSocial);
            $(".Villa").slideDown(400);
            break;
        case "youtube":
            $(".Villa table").attr("id", strSocial);
            callYoutubeData(arrClienti[idClient].screenNameYoutube, strSocial);
            $(".Villa").slideDown(400);
            break;
        case "instagram":
            $(".Villa table").attr("id",strSocial);
            callInstagramData(arrClienti[idClient].screenNameInstagram, strSocial);
            $(".Villa").slideDown(400);
            break;
    }
}
