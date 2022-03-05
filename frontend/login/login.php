<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form class="login">
            <p class="lbl">Login</p>
            <div class="input_group">
                <input type="username" placeholder="Username" required>
            </div>
            <div class="input_group">
                <input type="password" placeholder="Password" required>
            </div>
            <button class="btn">Login</button>
            <p class="direct_text">Don't have an account? <a class="direct_btn" href="register.php">Register Now.</a></p>
        </form>
    </div>
</body>
</html>