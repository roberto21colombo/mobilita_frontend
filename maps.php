<script>
    var map = null;
    function initMap() {
        var monza = {lat: 45.584102,  lng: 9.274613};
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: monza
        });
        <?php echo getMarker() ?>
        
      }
</script>

<?php
function getMarker(){
    $ana_sens = model::getAnaSens();
    $result = '';
    while($sens = mysqli_fetch_array($ana_sens)) {
        $coord = explode(",", $sens['coordinate']);
        $result.='
            var marker_'.$sens['id_sistema_nativo'].' = new google.maps.Marker({
                position: {lat: '.$coord[0].', lng: '.$coord[1].'},
                map: map,
                label: "'.$sens['id_sistema_nativo'].'"
                });
            marker_'.$sens['id_sistema_nativo'].'.addListener("click", function() {
                map.setZoom(18);
                map.setCenter(marker_'.$sens['id_sistema_nativo'].'.getPosition());
                document.getElementById("radio_'.$sens['id_sistema_nativo'].'").checked = true;
            });
        ';
    }
    return $result;
}
?>