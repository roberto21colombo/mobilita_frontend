
<div id="map"></div>
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
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmp0bhnuB-Y8jHMxsKU0aVh8GokE9ef08&callback=initMap">
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
        ';
    }
    return $result;
}
?>