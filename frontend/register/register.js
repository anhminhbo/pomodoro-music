// Register logic handler
const form = document.querySelector("form");
const username = document.querySelector("#username");
const password = document.querySelector("#password");
const con_password = document.querySelector("#con_password");
const message = document.querySelector("#message");
const message_icon = document.querySelector("#message_icon");

function redirect() {
  document.location.href = "../login/login.php";
}

document.querySelector(".btn").onclick = function (e) {
  e.preventDefault();

  if (username.value.match(/^[a-zA-Z0-9]+$/)) {
    if (password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/)) {
      if (password.value != con_password.value) {
        message.textContent = "Password is not matching. Please input again.";
        message.style.color = "red";
        message_icon.style.color = "red";
        password.value = "";
        con_password.value = "";
      } else {
        message_icon.style.display = "none";
        message.textContent = "Processing...";
        message.style.color = "rgba(128, 128, 128, 0.589)";

        const formData = new FormData();

        formData.append("username", username.value);
        formData.append("password", password.value);

        axios({
          url: "../../backend/db/user/register/register.php",
          method: "POST",
          headers: {
            "Content-Type": "multipart/form-data",
          },
          data: formData,
        })
          .then((response) => {
            if (response.data.message === "Create user successfully") {
              message_icon.className = "bx bxs-check-circle";
              message_icon.style.display = "inline";
              message_icon.style.color = "green";
              message.textContent = "All right. You are being redirected...";
              message.style.color = "green";
              message.style.display = "none";
              message_icon.style.display = "none";
              setTimeout(redirect, 2000);
            } else {
              message_icon.style.display = "inline";
              message_icon.style.color = "red";
              message.textContent =
                "Username duplicated. Please choose another username.";
              message.style.color = "red";
            }
          })
          .catch((err) => {
            message_icon.style.display = "inline";
            message_icon.style.color = "red";
            message.textContent =
              "Something wrong happened. Please try again later.";
            message.style.color = "red";
            console.log(err);
          });
      }
    } else {
      message.textContent =
        "Password is not validated. Please choose another password.";
      message.style.color = "red";
      message_icon.style.color = "red";
      password.value = "";
      con_password.value = "";
    }
  } else {
    message.textContent =
      "Username is not validated. Please choose another username.";
    message.style.color = "red";
    message_icon.style.color = "red";
    password.value = "";
    con_password.value = "";
  }
};
