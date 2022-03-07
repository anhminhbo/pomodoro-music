<?php
// For register page 
// Connect to db
    require_once '../connection.php';

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
		
		// prepare query statement
		$querySelect = "SELECT * FROM `heroku_6ce1a7fbfb7f295`.users 
		WHERE username = '$username' AND password = '$hashPassword'";

		// execute query
		$resultSelect = mysqli_query($conn,$querySelect);

		// check if username and password are both correct
		if (mysqli_num_rows($resultSelect) == 0) {
            //close db connection when finished
			mysqli_close($conn);

			$respJson["message"] = 'Login failed';
			$respJson["error"] = 'Username or Password incorrect';

			echo json_encode($respJson);
			exit();
		}
    
        //  convert mysqli-result into assoc array
		$row = mysqli_fetch_assoc($resultSelect);

        // Proceed to homepage
        // set cookie for old user to login again within 7 days
		setcookie("username", $username,time()+60*60*24*7); 
		setcookie("password", $password,time()+60*60*24*7); 
		setcookie("userid", $row['id'],time()+60*60*24*7); 

        mysqli_close($conn);

		$respJson["message"] = 'Login successfully';
		echo json_encode($respJson);
	}
	
?>