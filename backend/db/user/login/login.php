<?php
// For register page 
// Connect to db
	session_start();
    require_once '../../connection.php';

	$respJson = [
		"error" => 'no error',
		"message" => 'default'
	];
// Check if username , pw exist in post request
	if (isset($_POST['username']) && isset($_POST['password'])) {

		// Query to db to see if username and password exist

		$username = $_POST['username'];
		$password = $_POST['password'];
        $hashPassword = md5($password);
		
		// Prepare query statement
		$querySelect = "SELECT * FROM `heroku_6ce1a7fbfb7f295`.users 
		WHERE username = '$username' AND password = '$hashPassword'";

		// Execute query
		$resultSelect = mysqli_query($conn,$querySelect);

		// Check if username and password are both correct
		if (mysqli_num_rows($resultSelect) == 0) {
            //close db connection when finished
			mysqli_close($conn);

			$respJson["message"] = 'Login failed.';
			$respJson["error"] = 'Username or password incorrect.';

			echo json_encode($respJson);
			exit();
		}
    
        // Convert mysqli-result into assoc array
		$row = mysqli_fetch_assoc($resultSelect);

        // Proceed to homepage
        // Set session
		$_SESSION["loggedIn"] = true;
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		$_SESSION["userID"] = $row['id']; 

        mysqli_close($conn);

		$respJson["message"] = 'Login successfully';
		echo json_encode($respJson);
	}
	
?>