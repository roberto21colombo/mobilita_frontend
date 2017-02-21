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
        clearBtn: true,
        orientation: 'bottom auto'
    });
});


function changeMap(latitudine, longitudine){
//    coord = coord.split(",");
    coord = {lat: latitudine,  lng: longitudine};
    map.panTo(coord);
    smoothZoom(map, 18, map.getZoom());
    
    
}

// the smooth zoom function
function smoothZoom (map, max, cnt) {
    if (cnt >= max) {
        return;
    }
    else {
        z = google.maps.event.addListener(map, 'zoom_changed', function(event){
            google.maps.event.removeListener(z);
            smoothZoom(map, max, cnt + 1);
        });
        setTimeout(function(){map.setZoom(cnt)}, 30); // 80ms is what I found to work well on my system -- it might not work well on all systems
    }
} 

function drawChart(){
    //$("#chart").load( "chart.php",{ "sensori":$("input[name=sensori]:checked"), "giorno":$('#sandbox-container').val()} );
    //$("#chart").load("alert.php",{ "sensori":$("input[name='sensori']:checked").val()});
    
    //TODO fare il passaggio dei parametri, essere in grado di leggere
    var sensSel = $('input[name="sensori"]:checked').val();
    var giorno = $('input[type="text"]').val();
    if(!sensSel)
        alert("Selezionare un sensore");    
    if(!giorno)
        alert("Inserire almeno un giorno");
    if(sensSel && giorno)$("#chart").load("chart.php?sensori="+sensSel+"&giorno="+giorno);

}


