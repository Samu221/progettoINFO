<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stile_home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

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

    <!-- Connect to the database -->
    <?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "progettoinfo";

    $conn = mysqli_connect($host, $user, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Execute the SQL query to retrieve all projects and related information
    $sql = "SELECT progetto.CODICE, progetto.titolo, progetto.ambito, progetto.descrizione, progetto.num_like, immagine.immagine, progetto.username_creatore
            FROM progetto
            INNER JOIN account ON progetto.username_creatore = account.username
            INNER JOIN immagine ON progetto.CODICE = immagine.codice_progetto
            GROUP BY progetto.CODICE
            ORDER BY progetto.CODICE DESC";

    $result = mysqli_query($conn, $sql);

    // Display each project and related information
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='project_container'>";
            echo "  <div class='container img'>";
            echo "      <img class='immagine' src='data:image/jpeg;base64," . base64_encode($row["immagine"]) . "' alt='Immagine del progetto'>";
            echo "  </div>";
            echo "  <div class='container info'>";
            echo "      <h2 class='titolo'>" . $row["titolo"] . "</h2>";
            echo "      <div class='container likes'>like da inserire"; 
            echo "      </div>";
            echo "      <div class='container ambito'>";
            echo "          <p>Creato da: " . $row["username_creatore"] . "</p>";
            echo "          <p>Ambito: " . $row["ambito"] . "</p>";
            echo "      </div>";
            echo "      <div class='container descrizione'>";
            echo "          <p>Descrizione: " . $row["descrizione"] . "</p>";
            echo "      </div>";
            echo "      <button id='myButton_".$row["CODICE"]."' data-codice='".$row["CODICE"]."'>Mostra altro</button>";
            echo "  </div>";
            echo "</div>";
        }
    } else {
        echo "Nessun progetto trovato.";
    }
    
    // Close the database connection
    mysqli_close($conn);
    ?>
    <!-- DA VEDERE IN PHP -->
    <script>
        
        //bottone mostra altro
        const buttons = document.querySelectorAll('button[id^="myButton_"]');

        buttons.forEach(function(button) {
        button.addEventListener("click", function() {
            const codice = this.dataset.codice; // Get the project code
            const url = "progetto.php?codice=" + codice; // Create the URL with the project code
            window.location.href = url; // Redirect to the URL
        });
        });
    </script>
</body>
</html>