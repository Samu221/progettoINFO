<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="progetto.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Projects</h1>

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
    $sql = "SELECT progetto.CODICE, progetto.titolo, progetto.ambito, progetto.descrizione, progetto.num_like, account.email AS creator_email, immagine.immagine, progetto.username_creatore
            FROM progetto
            INNER JOIN account ON progetto.username_creatore = account.username
            INNER JOIN immagine ON progetto.CODICE = immagine.codice_progetto
            ORDER BY progetto.CODICE DESC";

    $result = mysqli_query($conn, $sql);

    // Display each project and related information
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<h2 class='titolo' >" . $row["titolo"] . "</h2>";
            echo "<div class='project_container'>";
            echo "  <div class='container img'>";
            echo "      <img class='immagine' src='data:image/jpeg;base64," . base64_encode($row["immagine"]) . "' alt='Immagine del progetto'>";
            echo "  </div>";
            echo "  <div class='container info'>";
            echo "      <div class='container ambito'>";
            echo "          <p>Creato da: " . $row["creator_email"] . "</p>";
            echo "          <p>Ambito: " . $row["ambito"] . "</p>";
            echo "      </div>";
            echo "      <div class='container likes'>";
            echo "          <p>Numero di Mi Piace: " . $row["num_like"] . "</p>";
            echo "      </div>";
            echo "      <div class='container descrizione'>";
            echo "          <p>Descrizione: " . $row["descrizione"] . "</p>";
            echo "      </div>";
            echo "  </div>";
            echo "</div>";
        }
    } else {
        echo "Nessun progetto trovato.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>