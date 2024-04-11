<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="progetto.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Account</title>
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
            echo "<h2 class='sottotitolo'>" . $row["username"] . "</h2>";
            echo "<p class='mail'>Email: " . $row["email"] . "</p>";      
        }
    }

    ?>
    <br>
    <div class="modifica"><a href="modifica_account">modifica profilo</a></div>
    <br>
    <div class="progetti">
        <h2>I Tuoi progetti</h2>
        <?php
            $sql = "SELECT CODICE, titolo, ambito, descrizione, num_like, username_creatore, procedimento
            FROM progetto
            WHERE username_creatore = '$user'";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // output the project information
            echo "<h2 class='titolo'>". $row["titolo"]. "</h2>";
            echo "<div class='project_container'>";
            echo "  <div class='container info'>";
            echo "      <div class='container ambito'>";
            echo "          <p>Creato da: ". $row["username_creatore"]. "</p>";
            echo "          <p>Ambito: ". $row["ambito"]. "</p>";
            echo "      </div>";
            echo "      <div class='container likes'>";
            echo "          <img class='like-icon' src='heart_gray.png' onclick='like(this)' alt='Like'>";
            echo "          <span class='like-count'>". $row["num_like"]. "</span>";
            echo "      </div>";
            echo "      <div class='container descrizione'>";
            echo "          <p>Descrizione: ". $row["descrizione"]. "</p>";
            echo "      </div>";
            echo "      <div class='container procedimento'>";
            echo "          <p>Procedimento: ". $row["procedimento"]. "</p>";
            echo "      </div>";
            echo "  </div>";
    
            // fetch the images for the project
            $sql_img = "SELECT immagine.immagine
                        FROM progetto, immagine
                        WHERE progetto.codice = immagine.codice_progetto AND immagine.codice_progetto=". $row["CODICE"];
    
            $result_img = mysqli_query($conn, $sql_img);
    
            if (mysqli_num_rows($result_img) > 0) {
                echo "<div class='container images'>";
                while($row_img = mysqli_fetch_assoc($result_img)) {
                    // output the project image
                    echo "<img class='immagine' src='data:image/jpeg;base64,". base64_encode($row_img["immagine"]). "' alt='Immagine del progetto'>";
                }
                echo "</div>";
            }
    
            echo "</div>";
        }
    }
            else{
                echo "progetto non trovato";
            }
            
            // close the prepared statement
            mysqli_stmt_close($stmt_img);
            
            // close the database connection
            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
