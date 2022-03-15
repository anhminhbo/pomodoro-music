// Login logic handler
const form = document.querySelector("form");
const username = document.querySelector("#username");
const password = document.querySelector("#password");
const message_box = document.querySelector("#message_box");
const message_icon = document.querySelector("#message_icon");
const message = document.querySelector("#message");


// Get cookie obj from browser
const cookieObj = document.cookie
  .split(";")
  .map((cookie) => cookie.split("="))
  .reduce(
    (accumulator, [key, value]) => ({
      ...accumulator,
      [key.trim()]: decodeURIComponent(value),
    }),
    {}
  );

// Handle username and password value if cookie exists
username.value = cookieObj.username ? cookieObj.username : "";
password.value = cookieObj.password ? cookieObj.password : "";

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData();
  formData.append("username", username.value);
  formData.append("password", password.value);

  axios({
    url: "../../backend/db/user/login/login.php",
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data",
    },
    data: formData,
  })
    .then((response) => {
      if (response.data.message === "Login successfully") {
        message_box.style.display = "block";
        message.textContent = "All right. Redirecting to content page..."
        message_icon.className = "bx bxs-check-circle"
        message_box.style.color = "green"
        console.log("Direct to content page");
        message.style.display = "none";
        message_icon.style.display = "none";
        document.location.href = "../../backend/db/user/musicplayer/musicplayer.html"
      } 
      else {
        message_box.style.display = "block";
        message.textContent = "Username or password incorrect. Please input again."
        message_icon.className = "bx bxs-error-circle"
        message_box.style.color = "red"
        console.log(response.data);
      }
    })
    .catch((err) => {
      console.log(err);
    });
});