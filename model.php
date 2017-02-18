<?php
    class model{
        
        function getAnaSens(){
            $conn = mysqli_connect('localhost', 'root', '', 'mobilita_comune_monza');
            $query ='SELECT *
                    FROM anagrafica
                    INNER JOIN dati
                    ON anagrafica.id_sistema_nativo = dati.fk_id_anagrafica
                    GROUP BY descrizione';
            $risultato = mysqli_query($conn, $query);

            if($risultato === FALSE) { 
                die(mysql_error()); // TODO: better error handling
            }
            mysqli_close($conn);
            return $risultato;
        }
        
        function getDays(){
            $conn = mysqli_connect('localhost', 'root', '', 'mobilita_comune_monza');
            $query ='SELECT DATE(dati.timestamp) AS "day" 
                    FROM dati 
                    GROUP BY YEAR(dati.timestamp), MONTH(dati.timestamp), DAY(dati.timestamp)';
            $risultato = mysqli_query($conn, $query);

            if($risultato === FALSE) { 
                die(mysql_error()); // TODO: better error handling
            }
            mysqli_close($conn);
            return $risultato;
        }
        
        function getData($idSensor, $day){
            $conn = mysqli_connect('localhost', 'root', '', 'mobilita_comune_monza');
            $query ='SELECT dati.conteggio_veicoli
                    FROM dati 
                    WHERE dati.fk_id_anagrafica = '.$idSensor.'
                    AND DATE(dati.timestamp) = "'.$day.'"';
            
            $risultato = mysqli_query($conn, $query);

            if($risultato === FALSE) { 
                die(mysql_error()); // TODO: better error handling
            }
            mysqli_close($conn);
            return $risultato;
        }
    }
?>