<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "user_db";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a flag for success
$login_success = false;

// Check if the request is for user login
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare and execute SQL statement for verifying user credentials
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $login_success = true;
        } else {
            // Invalid password
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        // No user found with that username
        echo "<script>alert('No user found with that username.');</script>";
    }

    $stmt->close();
}

// Close connection
$conn->close();

if ($login_success) {
    // Set a JavaScript variable for showing the modal
    echo "<script>window.onload = function() { showLoginSuccessModal(); }</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 20%; /* Could be more or less, depending on screen size */
            
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        p{
            text-align: center;
        }
        .modal-button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 4px;
           margin-left: 120px;
        }
    </style>
</head>
<body>

<!-- The Modal -->
<div id="loginSuccessModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Login Successful!</p>
        <button id="redirectButton" class="modal-button">Proceed</button>
    </div>
</div>

<script>
function showLoginSuccessModal() {
    var modal = document.getElementById("loginSuccessModal");
    var closeBtn = document.getElementsByClassName("close")[0];
    var redirectBtn = document.getElementById("redirectButton");

    modal.style.display = "block";
    
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    redirectBtn.onclick = function() {
        window.location.href = 'product.html'; // Redirect to product.html when the button is clicked
    }
}
</script>

</body>
</html>
