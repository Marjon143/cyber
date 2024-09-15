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

// Check if the request is to insert a new user
if (isset($_POST['firstName']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Prepare and execute SQL statement for inserting a new user
    $stmt = $conn->prepare("INSERT INTO users (firstName, middleName, lastName, username, email, password, birthday, address, contactNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $firstName, $middleName, $lastName, $username, $email, $password, $birthday, $address, $contactNumber);

    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];

    if ($stmt->execute()) {
       
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    /* Modal Background */
                    .modal {
                        display: none; /* Hidden by default */
                        position: fixed; /* Stay in place */
                        z-index: 1000; /* Sit on top */
                        left: 0;
                        top: 0;
                        width: 100%; /* Full width */
                        height: 100%; /* Full height */
                        overflow: auto; /* Enable scroll if needed */
                        background-color: rgb(0,0,0); /* Fallback color */
                        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                    }

                    /* Modal Content */
                    .modal-content {
                        background-color: #fefefe;
                        margin: 15% auto; /* 15% from the top and centered */
                        padding: 20px;
                        border: 1px solid #888;
                        width: 80%; /* Could be more or less, depending on screen size */
                        max-width: 500px;
                        border-radius: 8px;
                    }

                    /* The Close Button */
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

                    /* Confirm Button */
                    #confirmButton {
                        background-color: #5cb85c;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 4px;
                        font-size: 16px;
                        cursor: pointer;
                    }

                    #confirmButton:hover {
                        background-color: #4cae4c;
                    }
                </style>
              </head>
              <body>
                <div id='confirmationModal' class='modal'>
                    <div class='modal-content'>
                        <span class='close'>&times;</span>
                        <p>New record created successfully. Proceeding to login page...</p>
                        <button id='confirmButton'>OK</button>
                    </div>
                </div>
                <script>
                    // Get modal element
                    var modal = document.getElementById('confirmationModal');
                    
                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName('close')[0];
                    
                    // Get the confirm button
                    var confirmButton = document.getElementById('confirmButton');
                    
                    // Show the modal
                    modal.style.display = 'block';
                    
                    // When the user clicks on <span> (x), close the modal
                    span.onclick = function() {
                        modal.style.display = 'none';
                        window.location.href = 'login.html'; // Redirect to login page
                    };
                    
                    // When the user clicks on the confirm button, proceed to login page
                    confirmButton.onclick = function() {
                        modal.style.display = 'none';
                        window.location.href = 'login.html'; // Redirect to login page
                    };
                    
                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = 'none';
                            window.location.href = 'login.html'; // Redirect to login page
                        }
                    };
                </script>
              </body>
              </html>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


$conn->close();
?>
