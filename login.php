<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $nomeDB = 'progettoinfo';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $nomeDB);

    // Check connection
    if (!$conn) {
        die("Errore nella connessione a MySql: " . mysqli_connect_error());
    }

    session_start();

    $name = $_POST['userlogin'];
    $pw = $_POST['passlogin'];

    // Using prepared statements to prevent SQL injection
    $query = "	SELECT username, password 
				FROM account 
				WHERE username=?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Check if user exists
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $username, $hashed_password);
            mysqli_stmt_fetch($stmt);

            // Verify password
            if (SHA1($pw) == $hashed_password) {
                $_SESSION["username"] = $username;
                header("location: home.php");
                exit(); // Ensure script stops here after redirect
            } else {
                echo "Utente e/o password errati";
                echo "password inserita: ".$pw;
                echo "password db: ".SHA1($hashed_password);
            }
        } else {
            echo "Utente e/o password errati";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Errore nella query: " . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
