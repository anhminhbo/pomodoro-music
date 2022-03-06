
<?php
// For register page 
// Connect to db
    require_once '../connection.php';

	$respJson = [
		"error" => 'no error',
		"message" => 'default'
	];
// Check if username , pw exist
	if (isset($_POST['username']) && isset($_POST['password'])) {

		// Query to db to see if username exist

		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// prepare query statement
		$query = "SELECT * FROM `heroku_6ce1a7fbfb7f295`.users 
		WHERE username = '".$username."'";

		// execute query
		$resultQuery = mysqli_query($conn,$query);

		// check if there is username duplicated
		if ($resultQuery) {
			//close db connection when finished
			mysqli_close($conn);
			$respJson["message"] = 'Create user failed';
			$respJson["error"] = 'Username duplicated';
			echo json_encode($respJson);
			exit();
		} 
		
		// Prepare query
		$stmt = $conn->prepare("INSERT INTO `heroku_6ce1a7fbfb7f295`.users 
		(username, password) values( ?, ?)");

		// Bind user input to query value
		$stmt->bind_param("ss", $username, $password);
		$execval = $stmt->execute();
		$stmt->close();
		$conn->close();

		if (!$execval) {
			$respJson["message"] = 'Create user failed';
			echo json_encode($respJson);
			exit();
		}

		$respJson["message"] = 'Create user successfully';
		echo json_encode($respJson);
	}
?>