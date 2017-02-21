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
            
            $arrayDay = explode(',', $day);
            $conn = mysqli_connect('localhost', 'root', '', 'mobilita_comune_monza');
            
            foreach ($arrayDay as $day) {
                $query ='SELECT dati.conteggio_veicoli, dati.giorno_settimana, hour(dati.timestamp) as hour
                        FROM dati 
                        WHERE dati.fk_id_anagrafica = '.$idSensor.'
                        AND DATE(dati.timestamp) = "'.$day.'"';

                $risultato = mysqli_query($conn, $query);
                if($risultato === FALSE) { 
                    die(mysql_error()); // TODO: better error handling
                }
                $arrayRis[] =  $risultato;
            }

            
            mysqli_close($conn);
            return $arrayRis;
        }
        
        /*
        function getCoordById($idSensor){
            
            $conn = mysqli_connect('localhost', 'root', '', 'mobilita_comune_monza');
            
            $query ='SELECT coordinate 
                    FROM anagrafica 
                    WHERE id_sistema_nativo = '.$idSensor;

            $risultato = mysqli_query($conn, $query);
            if($risultato === FALSE) { 
                die(mysql_error());
            }
        
            mysqli_close($conn);
            return mysqli_fetch_array($risultato)['coordinate'];
        }
         
         */
    }
?>