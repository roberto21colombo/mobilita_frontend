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
        
        <script>
            var today = new Date();
            var endDate = today.getFullYear()+"."+(today.getMonth()+1)+"/"+(today.getDate()-1);
            $(function(){
                $('.datepicker').datepicker({
                    startDate: "2013-01-01",
                    endDate: endDate,
                    format: "yyyy-mm-dd",
                    language: "it",
                    weekStart: 1
                });
            });
        </script>
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
        
    

    <?php
        if(isset($_GET['sensori'])){
            $data = model::getData($_GET['sensori'], $_GET['giorno']);
            while($riga = mysqli_fetch_array($data)){
                echo $riga['timestamp'].' --> ' .$riga['conteggio_veicoli'].'</br>';
            }

            //Setto gli input con i valori scelti dall'utente in precedenza
            echo '
                <script>
                    document.getElementById("giorno").value = "'.$_GET['giorno'].'";
                    document.getElementById("sensori").value = '.$_GET['sensori'].';
                </script>
            ';
            
        } 
    ?>
    </body>
</html>
