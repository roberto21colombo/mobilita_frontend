var today = new Date();
var endDate = today.getFullYear()+"."+(today.getMonth()+1)+"/"+(today.getDate()-1);
$(function(){
    $('#sandbox-container').datepicker({
        startDate: "2013-01-01",
        endDate: endDate,
        format: "yyyy-mm-dd",
        language: "it",
        weekStart: 1,
        multidate: true,
        clearBtn: true
    });
});

function changeMap(latitudine, longitudine){
//    coord = coord.split(",");
    coord = {lat: latitudine,  lng: longitudine};
    map.panTo(coord);
    map.setZoom(18);
}


