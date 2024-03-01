<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are set in $_POST
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Sanitize input to prevent SQL injection
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Database connection
        $host = "localhost";
        $dbusername = "root";
        $dbpass = "";
        $dbnum = "auth";
        $conn = new mysqli($host, $dbusername, $dbpass, $dbnum);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute query
        $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";
        $result = $conn->query($query);
        
        // Check if query executed successfully
        if ($result) {
            // Check if exactly one row is returned
            if ($result->num_rows == 1) {
                // Redirect user to note.php upon successful login
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: success.html");
                exit();
            } else {
                // Handle incorrect username or password
                echo "Incorrect username or password.";
            }
        } else {
            // Handle query execution error
            echo "Error: " . $conn->error;
        }
        
        // Close connection
        $conn->close();
    } else {
        // Handle missing username or password
        echo "Username or password is missing.";
    }
}
?>
