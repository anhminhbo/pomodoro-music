const submitBtn = document.querySelector('input[type="submit"]');

const username = document.querySelector("#username");
const password = document.querySelector("#password");

submitBtn.addEventListener("click", (e) => {
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
      console.log(response.data.error);
    })
    .catch((err) => {
      console.log(err);
    });
});
