<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "progettoinfo");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query
$sql = "SELECT titolo, immagine, descrizione FROM progetto INNER JOIN immagine ON progetto.codice = immagine.codice_progetto WHERE progetto.codice = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $project_code);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store the project details
$project_details = [];

// Fetch the result and store the project details in the array
while ($row = $result->fetch_assoc()) {
    $project_details[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Details</title>
</head>
<body>

<?php
// Display the project details and images
if (!empty($project_details)) {
    echo "<h1>" . htmlspecialchars($project_details[0]["titolo"]) . "</h1>";
    echo "<p>" . htmlspecialchars($project_details[0]["descrizione"]) . "</p>";
    echo "<img src='data:image/jpeg;base64," . base64_encode($project_details[0]["immagine"]) . "' alt='Project Image' style='max-width:100%;height:auto;'/>";
} else {
    echo "No project found with the provided code.";
}
?>

</body>
</html>