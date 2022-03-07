<?php
// For register page 
// Connect to db
    require_once '../../connection.php';

	$respJson = [
		"error" => 'no error',
		"message" => 'default'
	];

	// Check if username , pw exist in post request
	if (isset($_POST['username']) && isset($_POST['password'])) {

		// Query to db to see if username exist

		$username = $_POST['username'];
		$password = $_POST['password'];
        $hashPassword = md5($password);
		
		// prepare query statement
		$querySelect = "SELECT * FROM `heroku_6ce1a7fbfb7f295`.users 
		WHERE username = '$username'";

		// execute query
		$resultSelect = mysqli_query($conn,$querySelect);

		// $row = mysqli_fetch_assoc($resultQuery);

		// check if there is username duplicated
		if (mysqli_num_rows($resultSelect) > 0) {
			//close db connection when finished
			mysqli_close($conn);
			$respJson["message"] = 'Create user failed';
			$respJson["error"] = 'Username duplicated';
			echo json_encode($respJson);
			exit();
		}
		// Insert new user to db
		// Prepare query
		$queryInsert = "INSERT INTO `heroku_6ce1a7fbfb7f295`.users
		(username, password) values( '$username', '$hashPassword')";

		$resultInsert = mysqli_query($conn,$queryInsert);

		if (!$resultInsert) {
			$respJson["message"] = 'Create user failed';
			$respJson["error"] = "".mysqli_error($conn);
			mysqli_close($conn);
			echo json_encode($respJson);
			exit();
		}

		mysqli_close($conn);

		// set cookie for new user to login after register within 6 hours
		setcookie("username", $username,time()+60*60*6,'/'); 
		setcookie("password", $password,time()+60*60*6,'/'); 

		$respJson["message"] = 'Create user successfully';
		echo json_encode($respJson);
	}
	
?>