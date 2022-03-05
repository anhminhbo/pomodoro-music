<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <form class="register">
            <p class="lbl">Register</p>
            <div class="input_group">
                <input type="name" placeholder="Name" required>
            </div>
            <div class="input_group">
                <input type="username" placeholder="Username" required>
            </div>
            <div class="input_group">
                <input type="password" placeholder="New password" required>
            </div>
            <div class="input_group">
                <input type="con_password" placeholder="Confirm password" required>
            </div>
            <button class="btn">Register</button>
            <p class="direct_text">Already have an account? <a class="direct_btn" href="login.php">Login here!</a></p>
        </form>
    </div>
</body>
</html>