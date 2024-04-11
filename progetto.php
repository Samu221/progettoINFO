
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="progetto.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="home.php" class="link">
                <img src="immagini/logo.png" alt="Logo" class="logo">
            </a>
            <h1 class="h1"> DIYhub </h1>
        </div>
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
// Connect to the database
$conn = new mysqli("localhost", "root", "", "progettoinfo");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['codice'])) {
    $project_code=$_GET["codice"];
}

$sql = "SELECT CODICE, titolo, ambito, descrizione, num_like, username_creatore, procedimento
FROM progetto 
WHERE progetto.codice = $project_code";

$sql_img = "SELECT immagine.immagine
FROM progetto, immagine
WHERE progetto.codice = immagine.codice_progetto AND immagine.codice_progetto=$project_code";

$result = mysqli_query($conn, $sql);
$result_img = mysqli_query($conn, $sql_img);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "<h2 class='titolo'>" . $row["titolo"] . "</h2>";
        echo "<div class='project_container'>";
        echo "  <div class='container info'>";
        echo "      <div class='container ambito'>";
        echo "          <p>Creato da: " . $row["username_creatore"] . "</p>";
        echo "          <p>Ambito: " . $row["ambito"] . "</p>";
        echo "      </div>";
        echo "      <div class='container likes'>";
        echo "          <img class='like-icon' src='heart_gray.png' onclick='like(this)' alt='Like'>";
        echo "          <span class='like-count'>" . $row["num_like"] . "</span>";
        echo "      </div>";
        echo "      <div class='container descrizione'>";
        echo "          <p>Descrizione: " . $row["descrizione"] . "</p>";
        echo "      </div>";
        echo "      <div class='container procedimento'>";
        echo "          <p>Procedimento: " . $row["procedimento"] . "</p>";
        echo "      </div>";
        echo "  </div>";
        echo "</div>";
    }
}
else{
    echo "progetto non trovato";
}

if (mysqli_num_rows($result_img) > 0) {
    while($row = mysqli_fetch_assoc($result_img)) {
        echo "<img class='immagine' src='data:image/jpeg;base64," . base64_encode($row["immagine"]) . "' alt='Immagine del progetto'>";

    }
}
else{
    echo "immagini non trovate";
}

// Close the database connection
mysqli_close($conn);
?>


</body>
</html>