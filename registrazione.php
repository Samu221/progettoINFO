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

    $name = $_POST['user'];
    $pw = $_POST['pass'];
	$mail = $_POST['email']; 

    // Utilizzo di funzione di hashing sicura (bcrypt) per la password
    $pw_hashed = SHA1($pw);

    $query_check = "SELECT username FROM account WHERE username='$name'";
    $result_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "Username già esistente";
    } else {
        $query_insert = "INSERT INTO account (email, username, password) VALUES ('$mail', '$name', '$pw_hashed')";

        if (mysqli_query($conn, $query_insert)) {
            $_SESSION["username"] = $username;
            header("location: home.php");
            exit();
        } else {
            echo "Errore nella registrazione: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
?>
