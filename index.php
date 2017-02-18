<?php
    include 'model.php';
    
    $ana_sens = model::getAnaSens();
    $days = model::getDays();
?>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css">
        
        <script src="js/jquery.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>-->
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        
        <script src="js/main.js"></script>
    </head>
    
    <body>
        <form name="filter" action="" method="GET">
            
            <input type="text" class="datepicker" name="giorno" id="giorno">  
            
            <select name="sensori" id="sensori">
                <?php
                    while($riga = mysqli_fetch_array($ana_sens)){
                        echo '<option value="'.$riga['id_sistema_nativo'].'">'.$riga['descrizione'].'</option>';
                    }
                ?>
            </select>
            
            <input type="submit" value="Cerca"/>
        </form>
        
        <div id="canvas" style="width: 1000px; height: 400px">
            <canvas id="lineChart"></canvas>
        </div>
        
    
        
    
  
    <?php
        if(isset($_GET['sensori'])){
            
            //Setto gli input con i valori scelti dall'utente in precedenza
            echo '
                <script>
                    document.getElementById("giorno").value = "'.$_GET['giorno'].'";
                    document.getElementById("sensori").value = '.$_GET['sensori'].';
                </script>
            ';
            
            $data = model::getData($_GET['sensori'], $_GET['giorno']);
            $array="[";
            while($riga = mysqli_fetch_array($data)){
                $array = $array.'"'.$riga["conteggio_veicoli"].'", ';
            }
            $array = $array.']'; 
            
        } 
    ?>
        
     <script>
        //var dati = leggo in una variabile i valori passati dal php
        var label = document.getElementById("giorno").value + " " + document.getElementById("sensori").options[document.getElementById("sensori").selectedIndex].text;
        //console.log(label);
        var ctx = document.getElementById("lineChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data:{
                labels: ["00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],
                datasets: [
                    {
                        label: label,
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: <?php echo $array ?>,
                        spanGaps: false
                    }
                ]
                
                
            }
        });
        
    </script>
    </body>
</html>

