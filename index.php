<html>
  <head>
    <meta charset="utf-8">
    <title>Cloudinary Tutorial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="./home.css">
  </head>
  <body>
    <div class="card">
      <img src="http://fillmurray.com/g/300/300" id="img-preview" />
      <form method="post" action="test.php" enctype='multipart/form-data' >
      <label class="file-upload-container" for="file-upload">
        <input id="file-upload" type="file" style="display:none;" name="file">
        Select your music
      </label>
      <input  type="text" name = 'text'>
      <input id="submitBtn"  type="submit" onsubmit='return onFormSubmit(this);'>
</form>

<script>
    function onFormSubmit(form) {
        console.log(form);
        // // save in cookies
        // document.cookie = "my_form=" + jsonData;
 
        // // redirect to form's action
        // window.location.href = form.getAttribute("action");
 
        // prevent form from submitting
        return false;
    }
</script>



      <audio id= "audio-render" controls autoplay>
  <source type="audio/mpeg" />
  Your browser does not support the audio element.
</audio>
    </div>
    <!-- Scripts -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- <script src="./app.js"></script> -->
  </body>
</html>