function drawDataTable(data, idElement){
    var rows = "";

    var colDescription = "";
    var colValue = "";
    for (var r = 0; r < data.length; r++) {
        colDescription += '<td><div id="des_' + String(data[r]["des"]+idElement).replace(/\#|\*/g,"").replace(/\s/g,'_') + '">' + data[r]["des"] + '</div></td>';
        colValue += '<td><div id="val_' + String(data[r]["des"]+idElement).replace(/\#|\*/g,"").replace(/\s/g,'_') + '">'+ fixDecimal(data[r]["val"])+'</div></td>'
    }
    rows += '<tr class="desc">' + colDescription + '</tr><tr class="value">' + colValue + '</tr>';
    $(idElement).find("tbody").empty();
    $(idElement).find("tbody").append(rows);
}
function drawDataTable_2(data, idElement){
    var rows = "";

    for (var r = 0; r < data.length; r++) {
        var row;
        var col;
        if (r + 1 === data.length) {
            col = '<td class="desc">' + data[r]["des"] + '</td>';
            row = '<tr>' + col + '</tr>';
            col = '<td class="value">' + fixDecimal(data[r]["val"]) + '</td>';
        } else {
            col = '<td class="desc">' + data[r]["des"] + '</td> <td class="desc">' + data[r + 1]["des"] + '</td>';
            row = '<tr>' + col + '</tr>';
            col = '<td class="value">' + fixDecimal(data[r]["val"]) + '</td> <td class="value">' + fixDecimal(data[r + 1]["val"]) + '</td>';
        }
        row = row + '<tr>' + col + '</tr>';
        rows = rows + row;
        r++;
    }
    $(idElement).find("tbody").empty();
    $(idElement).find("tbody").append(rows);
}

function drawDataTable_(data, idElement){
    var rows = "";
    
    for (var r=0; r<data.length; r++){
        var row;
        var col;
        row = '<tr id="' + String(data[r]["des"]).replace(/\s/g,"_") + '">';
        col = '<td class="desc">' + data[r]["des"] + '</td> <td class="value">' + fixDecimal(data[r]["val"]) + '</td>';
        rows = rows + row + col + '</tr>';
    }
        $(idElement).find("tbody").empty();
        $(idElement).find("tbody").append(rows);
}
function drawThumbnails(thumbnails, idElement){
    var strDiv = '<div class="gallery">';
    for(var t = 0; t < 6; t++) {
        //inserire http://instagram.com/p/ id foto esempio --->> http://instagram.com/p/eF9vKEwlcB/
        strDiv = strDiv + 
                '<span id="img' + t + '"><a href="' + thumbnails[t].link + 
                '" target="_blank"><img src="' + thumbnails[t].url + 
                '"/></a></span>';
    }
    $(idElement).append(strDiv + '</div>');
}

function drawPinterestBoard(thumbnailsBoard, idElement){
    var strDiv = '<div class="gallery">';
    for(var t = 0; t < 9; t++) {
        strDiv = strDiv + 
                '<span id="img' + t + '"><a href="' + thumbnailsBoard[t].link + 
                '" target="_blank"><img src="' + thumbnailsBoard[t].url + 
                '"/></a></span>';
    }
    $(idElement).append(strDiv + '</div>');
}


function fixDecimal(val){
    var re = /([0-9]{3})$/g;
    var reDec = /(,[0-9]+)/g;
    var decPart = "";
    var s = "";
    if (typeof val === "number"){
        //20131219 richiesta di Filippo lasciare il decimale solo alla media di youtube
        if (val <= 10){
            val= (Math.round(100*val)/100).toFixed(2);
            s = String(val).replace(/\./,",");
            decPart = s.match ( reDec );
            s = s.replace(reDec, "");
        }else{
            val = (Math.round(val)).toFixed(0);
            s = String(val);
        }
        var threeDigit = [];
        if (s.length > 3) {
            for (var i = 0; i < s.length; i++) {
                threeDigit[i] = s.match(re);
                s = s.replace(re, "");
                if (s.length < 3 && s.length > 0) {
                    i++;
                    threeDigit[i] = s;
                }
            }
        } else {
            threeDigit[0] = s;
        }
        var result = "";
        for (var i = threeDigit.length - 1; i >= 0; i--) {
            if (i > 0) {
                result += threeDigit[i] + ".";
            } else {
                if (decPart === ""){
                    result += threeDigit[i];
                }else{
                    result += threeDigit[i] + decPart;
                }
            }
        }
        return result;
    }
}
