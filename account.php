<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="progetto.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Account</title>
</head>
<body>
    <header style="top: 0; width: 100%; border-bottom: 1px solid black;">
        <h1>Gestione Account</h1>
        <a href="account.php" class="account-link">
            <img src="immagini/account.png" alt="Icona Account" style="width: 40px;">
        </a>
        <a href="/percorso-del-tuo-account" class="salvati-link">
            <img src="immagini/salvati.png" alt="Icona Salvati" style="width: 35px;">
        </a>
        <a href="inserimento.html" class="aggiungi-link">
            <img src="immagini/aggiungi.png" alt="Icona Aggiungi" style="width: 34px;">
        </a>
    </header>
    <?php
    session_start();
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "progettoinfo");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $user=$_SESSION['username'];
    $sql="  SELECT username, email
            FROM account
            WHERE username='$user'"; 

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<p>Username: " . $row["username"] . "</p>";
            echo "<p>Email: " . $row["email"] . "</p>";      
        }
    }

    ?>
</body>
</html>
