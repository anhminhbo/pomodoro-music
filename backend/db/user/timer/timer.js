const selectedMode = document.querySelector("#selectMode");

const startBtn = document.querySelector("#startBtn");

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

// handle if user haven't login yet
if (!userid) {
  document.location.href = "../login/login.html";
}

const userid = cookieObj.userid;

// Make post request to fetch previous timer mode

const formDataFetchTimer = new FormData();
formDataFetchTimer.append("userid", userid);

axios({
  url: "getTimer.php",
  method: "POST",
  headers: {
    "Content-Type": "multipart/form-data",
  },
  data: formDataFetchTimer,
})
  .then((response) => {
    if (response.data.message === "Timer exists") {
      console.log(response.data);
      console.log("Handle passing previous timer mode value to UI");

      //   Example to set UI mode display
      if (
        response.data.timerData.work == 25 &&
        response.data.timerData.break == 5
      ) {
        selectedMode.value = "25/5";
      } else if (
        response.data.timerData.work == 50 &&
        response.data.timerData.break == 10
      ) {
        selectedMode.value = "50/10";
      } else {
        selectedMode.value = "custom";
      }
    }
  })
  .catch((err) => {
    console.log(err);
  });

// selectedMode.onchange = (e) => {
//   console.log(selectedMode.value);
// };

startBtn.onclick = () => {
  const formDataUpdateTimer = new FormData();
  // Here we pass work and break minutes from UI to update in DB
  formDataUpdateTimer.append("work", "50");
  formDataUpdateTimer.append("break", "10");
  formDataUpdateTimer.append("userid", userid);

  axios({
    url: "updateTimer.php",
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data",
    },
    data: formDataUpdateTimer,
  })
    .then((response) => {
      if (response.data.message === "Create user successfully") {
        document.location.href = "../login/login.html";
      } else {
        console.log(response.data);
      }
    })
    .catch((err) => {
      console.log(err);
    });
};
