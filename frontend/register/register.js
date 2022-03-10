// Register logic handler
const form = document.querySelector("form");
const username = document.querySelector("#username");
const password = document.querySelector("#password");
const con_password = document.querySelector("#con_password")

document.querySelector('.btn').onclick = function(){
    if (password.value != con_password.value){
        alert('Password is not matching. Please input again.')
        document.querySelector("#password").value = "";
        document.querySelector("#con_password").value = "";
    }
    else{
        form.addEventListener("submit", (e) => {
            e.preventDefault();
          
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
                  document.location.href = "../login/login.html";
                } else {
                  // handle when username duplicated
                  console.log(response.data);
                }
              })
              .catch((err) => {
                console.log(err);
              });
          });
    }
}
    
