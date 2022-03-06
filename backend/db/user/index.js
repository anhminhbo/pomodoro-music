// const submitBtn = document.querySelector('input[type="submit"]');

const form = document.querySelector("form");

const username = document.querySelector("#username");
const password = document.querySelector("#password");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData();
  formData.append("username", username.value);
  formData.append("password", password.value);

  axios({
    url: "createNewUser.php",
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data",
    },
    data: formData,
  })
    .then((response) => {
      console.log(response.data);
    })
    .catch((err) => {
      console.log(err);
    });
});
