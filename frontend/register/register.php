<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="register.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap"
      rel="stylesheet"
    />
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <title>Register</title>
  </head>
  <body>
    <div class="container">
      <form class="register">
        <p class="lbl">Register</p>
        <div class="input_group">
          <input type="username" id="username" placeholder="Username" required/>
        </div>
        <div class="input_group">
          <input type="password" id="password" placeholder="New password"/>
        </div>
        <div class="input_group">
          <input type="password" id="con_password" placeholder="Confirm password"/>
        </div>
        <div id="message_box">
          <i id="message_icon" class='bx bxs-error-circle' style="display: inline;"></i> 
          <div id="message" style="display: inline;">Use a username contains only letters and numbers (do not use special characters). Use a password between 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter.</div>
        </div>
        <button class="btn" type="submit">Register</button>
        <p class="direct_text">
          Already have an account?
          <a class="direct_btn" href="../login/login.php">Login here!</a>
        </p>
      </form>
    </div>
    <section>
      <footer id="footer">COPYRIGHT © 2022 MKKA - RMIT UNIVERSITY</footer>
    </section>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="register.js"></script>
  </body>
</html>
