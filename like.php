<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $nomeDB = 'progettoinfo';
    
    $conn = mysqli_connect($servername, $username, $password, $nomeDB);
    
    if (!$conn) {
        die("Errore nella connessione a MySQL: " . mysqli_connect_error());
    }

    if (isset($_GET['codice'])) {
        $project_code=$_GET["codice"];
    }
    if (isset($_SESSION['username'])) {
        $account=$_SESSION['username'];
    }
    else{
        echo "no account";
    }

    $query="    SELECT *
                FROM salvato
                WHERE username_account='$account' AND codice_progetto=$project_code";
                
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);

    if($num_rows){
            $query="    DELETE FROM salvato
                        WHERE username_account='$account' AND codice_progetto=$project_code";
            if (mysqli_query($conn, $query)) {
                echo "Records deleted: " . $project_code;
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
            }
        $query = "  UPDATE progetto 
                    SET num_like = num_like - 1 
                    WHERE codice = $project_code";

        if (mysqli_query($conn, $query)) {
            echo "Records updated: " . $project_code;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

    }
    else{
        $query="    INSERT INTO salvato (username_account, codice_progetto)
                    VALUES ('$account', $project_code)";
        if (mysqli_query($conn, $query)) {
            echo "Records inserted: " . $project_code;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        $query = "  UPDATE progetto 
                    SET num_like = num_like + 1 
                    WHERE codice = $project_code";

        if (mysqli_query($conn, $query)) {
            echo "Records updated: " . $project_code;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }

    
    header("location: progetto.php?codice=$project_code");
    exit();
    mysqli_close($conn);

?>