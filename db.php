<!DOCTYPE html>
<html>
<head>
<title>How to put PHP in HTML - Simple Example</title>
</head>
<body>
<?php
$servername = "us-cdbr-east-05.cleardb.net";
$username = "bbd2db5e7c59ce";
$password = "0e63ed34";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
echo "Hello from DB";

?>
</body>
</html>