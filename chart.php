
<?php
include 'model.php';
    $resultQueryChart = model::getData($_GET['sensori'], $_GET['giorno']);
    $resultQueryTable = model::getData($_GET['sensori'], $_GET['giorno']);
?>
     
    <canvas id="lineChart"></canvas>
    
    <div id="datiTabellari">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID Sensore</th>
                <th>Data</th>
                <th>Ora</th>
                <th>Conteggio Veicoli</th>
                <th>Giorno Settimana</th>
            </tr>
        </thead>
        <tbody>
            <?php echo getTable($resultQueryTable); ?>
        </tbody>
    </table>
    </div>
    
    
    
<script>
    //var dati = leggo in una variabile i valori passati dal php

    //console.log(label);
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data:{
            labels: ["00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],
            datasets: [
                <?php echo getDatasheet($resultQueryChart);?>
            ]
        }
    });
    
    $(document).ready(function() {
        $('#example').DataTable( {
        scrollY:        '80vh',
        scrollCollapse: true,
        paging:         false
        });
    });
</script>


<?php 
    function getTable($arrayResult){
        $txtResult = "";
        $day = explode(',', $_GET['giorno']);
        
        foreach ($arrayResult as $cont => $singleData) {
            while($riga = mysqli_fetch_array($singleData)){
                $txtResult .= '
                <tr>
                    <td>
                        '.$_GET['sensori'].'
                    </td>
                    <td>
                        '.$day[$cont].'
                    </td>
                    <td>
                        '.$riga['hour'].':00
                    </td>
                    <td>
                        '.$riga['conteggio_veicoli'].'
                    </td>
                    <td>
                        '.$riga['giorno_settimana'].'
                    </td>
                </tr>';
            }
        }
        
        return $txtResult;
    }

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

