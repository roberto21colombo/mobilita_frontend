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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.css">
        
        <script src="js/jquery.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>-->
        <script src="js/bootstrap-datepicker.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        
        <script src="js/main.js"></script>
    </head>
    
    <body>
        <form name="filter" action="" method="GET">
            <div id="form">
                
                <div id="sensori" class="element">
                    <?php include './maps.php' ?>

                    <div id="listaSensori">
                    <?php
                        while($riga = mysqli_fetch_array($ana_sens)){
                            echo '<input type="radio" name="sensori" onclick="changeMap('.model::getCoordById($riga['id_sistema_nativo']).')" value="'.$riga['id_sistema_nativo'].'"> '.$riga['id_sistema_nativo']." - ".$riga['descrizione'].'</input>';
                            echo '</br>';
                        }
                    ?>
                    </div>
                </div>
                
                <div id="datepicker" class="element">
                    <input type="text" id="sandbox-container" name="giorno" id="giorno" size="31">  
                </div>

                <input type="submit" value="Cerca" id="btn"/>
            </div>
        </form>
        
        <div id="chart">
            <canvas id="lineChart"></canvas>
        </div>
        
    
        
    
  
    <?php
        if(isset($_GET['sensori'])){
            
            //Setto gli input con i valori scelti dall'utente in precedenza
            echo '
                <script>
                    document.getElementById("giorno").value = "'.$_GET['giorno'].'";
                    document.getElementById("sensori").value = '.$_GET['sensori'].';
                    $radios.filter("[value='.$_GET['sensori'].']").prop("checked", true);
                </script>
            ';
            
            $resultQuery = model::getData($_GET['sensori'], $_GET['giorno']);
            
            
        } 
    ?>
        
     <script>
        //var dati = leggo in una variabile i valori passati dal php
        
        //console.log(label);
        var ctx = document.getElementById("lineChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data:{
                labels: ["00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],
                datasets: [
                    <?php echo getDatasheet($resultQuery);?>
                ]
            }
        });
    </script>
    </body>
</html>

<?php 
//dato in ingresso l'array diviso per giorni selezionati, 
//contente ognuno il conteggio veicoli, 
//restituisce un testo che definisice il dataset di ogni linea
    function getDatasheet($arrayResult){
        $txtResult = "";
        //var label = document.getElementById("giorno").value + " " + document.getElementById("sensori").options[document.getElementById("sensori").selectedIndex].text;
        $day = explode(',', $_GET['giorno']);
        foreach ($arrayResult as $cont => $singleData) {
            $color = randomRGBgenerator();
            $txtResult .= '
            {
                label: "'.$_GET['sensori'].": ".$day[$cont].' ",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba('.$color[0].','.$color[1].','.$color[2].',0.4)",
                borderColor: "rgba('.$color[0].','.$color[1].','.$color[2].',1)",
                borderCapStyle: "butt",
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: "miter",
                pointBorderColor: "rgba('.$color[0].','.$color[1].','.$color[2].',1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba('.$color[0].','.$color[1].','.$color[2].',1)",
                pointHoverBorderColor: "rgba('.$color[0].','.$color[1].','.$color[2].',1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: '. getJSArrayfromData($singleData).'
                spanGaps: false
            },';
        }
        return $txtResult;
    }
    
    //dato in ingresso il risultato della query per un determinato giorno,
    //ritorna i valori del conteggio veicoli scritto sotto forma di array per JS
    function getJSArrayfromData($data){
        $array="[";
            while($riga = mysqli_fetch_array($data)){
                $array = $array.'"'.$riga["conteggio_veicoli"].'", ';
            }
            $array = $array.'],'; 
        
            return $array;
    }
    
    function randomRGBgenerator() {
        return array(
            rand(0 , 255), // r
            rand(0, 255), // g
            rand(0, 255)); //b
    }
    

   
    

?>

