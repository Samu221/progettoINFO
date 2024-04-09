<?php
    session_start();

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $nomeDB = 'progettoinfo';

    $conn = mysqli_connect($servername, $username, $password, $nomeDB);

    if (!$conn) {
        die("Errore nella connessione a MySQL: " . mysqli_connect_error());
    }

    $nome_progetto = $_POST['titolo'];
    $ambito_progetto = $_POST['ambito'];
	$descrizione_progetto = $_POST['descrizione']; 
	$procedimento_progetto = $_POST['procedimento']; 

    $account= $_SESSION["username"];

    $query_insert = "INSERT INTO progetto (titolo, ambito, descrizione, procedimento, num_like, username_creatore) VALUES ('$nome_progetto', '$ambito_progetto', '$descrizione_progetto', '$procedimento_progetto', 0, '$account')";

    if (mysqli_query($conn, $query_insert)) {
        header("location: home.php");
        exit();
    } else {
        echo "Errore nell'inserimento: " . mysqli_error($conn);
    }


    mysqli_close($conn);
?>
