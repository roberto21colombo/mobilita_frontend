<?php
    include 'model.php';
    
    $ana_sens = model::getAnaSens();
    $days = model::getDays();
    
?>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
        
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
        
        <script src="js/jquery.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>-->
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmp0bhnuB-Y8jHMxsKU0aVh8GokE9ef08&callback=initMap"></script>
        
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
        
        <script src="js/main.js"></script>
    </head>
    
    <body>
        
        <div id="form">

            <div id="sensori" class="element">
                <div id="map"></div>
                <?php include './maps.php' ?>

                <div id="listaSensori">
                <?php
                    while($riga = mysqli_fetch_array($ana_sens)){
                        $id = $riga['id_sistema_nativo'];
                        $coord = $riga['coordinate'];
                        $desc = $riga['descrizione'];?>
                        <input type="radio" id="radio_<?php echo $id?>" name="sensori" onclick="changeMap(<?php echo $coord?>)" value="<?php echo $id?>"> <?php echo $id?> - <?php echo $desc?></input></br>
                        <?php
                    }
                ?>
                </div>
            </div>

            <div id="calendar">
                <input type="text" id="sandbox-container" name="giorno" size="23">  
                <input type=button value="Invia Dati" id="btn" onclick="drawChart()"/>
            </div>

            
        </div>
        
        <hr>
        <div style="clear: both"></div>
        
        <div id="chart"></div>
        
    </body>
</html>

        
    
        
    
  
   