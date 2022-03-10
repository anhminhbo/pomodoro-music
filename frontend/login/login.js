// Login logic handler
const form = document.querySelector("form");
const username = document.querySelector("#username");
const password = document.querySelector("#password");

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
        console.log("Direct to content page");
      } else {
        console.log(response.data);
      }
    })
    .catch((err) => {
      console.log(err);
    });
});