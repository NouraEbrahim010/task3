<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'auth';

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['user_id'];

// Fetch user's notes from database
$sql = "SELECT * FROM notes WHERE user_id='$userID'";
$result = $conn->query($sql);

// Add new note
if (isset($_POST['submit_note'])) {

    $content = $_POST['content'];

    // Insert note into database
    $sql = "INSERT INTO notes (user_id, content) VALUES ('$userID', '$content')";
    if ($conn->query($sql) === TRUE) {
        header("Location: notes.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete note
if (isset($_GET['delete_note'])) {
    $noteID = $_GET['delete_note'];

    // Delete note from database
    $sql = "DELETE FROM notes WHERE id='$noteID' AND username='$userID'";
    if ($conn->query($sql) === TRUE) {
        header("Location: notes.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}  
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row['content'] . "</p>";
            echo "<a href='notes.php?delete_note=" . $row['id'] . "'>Delete Note</a><br><br>";
        }
    } else {
        echo "No notes found.";
    }
   
// Close connection
$conn->close();
?>
