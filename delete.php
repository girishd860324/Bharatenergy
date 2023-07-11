<?php
// Establish database connection
require_once 'conn22.php';

// Check if the user ID is provided via GET parameter
if (isset($_GET["Id"])) {
    $Id = $_GET["Id"];

    // Delete the user from the database
    $sql = "DELETE FROM cru WHERE Id = '$Id'";

    if ($mysqli->query($sql) === TRUE) {
        // Redirect back to the user page
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting user: " . $mysqli->error;
    }
}

$mysqli->close();
?>
