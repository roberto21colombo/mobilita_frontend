<?php
    include 'model.php';
    
    $ana_sens = model::getAnaSens();
    $days = model::getDays();
?>

<form name="filter" action="#" method="GET">
    <select name="sensori">
        <?php
            while($riga = mysqli_fetch_array($ana_sens)){
                echo '<option value="'.$riga['id_sistema_nativo'].'">'.$riga['descrizione'].'</option>';
            }
        ?>
    </select>

    <select name="giorno">
        <?php
            while($riga = mysqli_fetch_array($days)){
                echo '<option value="'.$riga['day'].'">'.$riga['day'].'</option>';
            }
        ?>
    </select>
    <input type="submit" value="Cerca" name="btnSubmit" />
</form>

<?php
    if(isset($_GET['sensori'])){
        $data = model::getData($_GET['sensori'], $_GET['giorno']);
        while($riga = mysqli_fetch_array($data)){
            echo $riga['timestamp'].' --> ' .$riga['conteggio_veicoli'].'</br>';
        }
    } 
?>