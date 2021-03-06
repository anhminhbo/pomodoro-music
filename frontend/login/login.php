<?php
    session_start();
    $username = '';
    $password = '';
    if (isset($_SESSION["successReg"])){
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];
        session_destroy();
    }
?>
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
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form class="login">
            <p class="lbl">Login</p>
            <div class="input_group">
                <input type="username" id="username" placeholder="Username" required value=<?php echo $username;?>>
            </div>
            <div class="input_group">
                <input type="password" id="password" placeholder="Password" required value=<?php echo $password;?>>
            </div>
            <div id="message_box">
                <i id="message_icon" class='bx bxs-error-circle' style="display: inline;"></i> 
                <div id="message" style="display: inline;">Username or password incorrect. Please input again.</div>
            </div> 
            <button class="btn">Login</button>
            <p class="direct_text">
                Don't have an account? 
                <a class="direct_btn" href="../register/register.php">Register Now.</a>
            </p>
        </form>
    </div>
    <section>
        <footer id="footer">COPYRIGHT © 2022 MKKA - RMIT UNIVERSITY</footer>
    </section>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="login.js"></script>
</body>
</html>