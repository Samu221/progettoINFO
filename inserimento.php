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

$nome_progetto = $_POST['titolo'];
$ambito_progetto = $_POST['ambito'];
$descrizione_progetto = $_POST['descrizione'];
$procedimento_progetto = $_POST['procedimento'];

$account = $_SESSION["username"];

$query_insert = "INSERT INTO progetto (titolo, ambito, descrizione, procedimento, num_like, username_creatore) VALUES (?, ?, ?, ?, 0, ?)";
$stmt = mysqli_prepare($conn, $query_insert);
mysqli_stmt_bind_param($stmt, "sssss", $nome_progetto, $ambito_progetto, $descrizione_progetto, $procedimento_progetto, $account);

if (mysqli_stmt_execute($stmt)) {
    $nuovo_id = mysqli_insert_id($conn);

    if (isset($_FILES['immagine'])) {
        $file_tmp = $_FILES['immagine']['tmp_name'];
        $file_type = $_FILES['immagine']['type'];

        // Verifica che il file sia un'immagine
        if ($file_type == "image/jpeg" || $file_type == "image/png" || $file_type == "image/gif") {
            // Apre il file come binario per leggerne i dati
            $immagine_binaria = file_get_contents($file_tmp);
            $query_insert_img = "INSERT INTO immagine (immagine, codice_progetto) VALUES (?, ?)";
            $stmt_img = mysqli_prepare($conn, $query_insert_img);
            mysqli_stmt_bind_param($stmt_img, "sb", $immagine_binaria, $nuovo_id);

            if (mysqli_stmt_execute($stmt_img)) {
                header("location: home.php");
                exit();
            } else {
                echo "Errore nell'inserimento dell'immagine: " . mysqli_stmt_error($stmt_img);
            }
        } else {
            echo "Si prega di caricare solo file immagine di tipo JPG, PNG o GIF.";
        }
    }
} else {
    echo "Errore nell'inserimento del progetto: " . mysqli_stmt_error($stmt);
}

mysqli_close($conn);
?>