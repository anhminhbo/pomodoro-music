<?php
    require_once __DIR__ . '/template/header.php';
    // Display register
    require_once __DIR__ . '/register/register.php';

    // Display login
    require_once __DIR__ . '/login/login.php';

    // Wait for 5s before redirect to Home
    /*echo "<script>
        setTimeout(()=>{
            document.location.href='".$__DIR__."/frontend/views/home.php';
        },5000)
    </script>";*/

    // // Redirect to home
    // echo "<script type='text/javascript'>document.location.href='".$__DIR__."/frontend/views/home.php';</script>";
    require_once __DIR__ . '/template/footer.php';
?>

