const CLOUDINARY_URL = "https://api.cloudinary.com/v1_1/hcgh6liyq/video/upload";
const CLOUDINARY_UPLOAD_PRESET = "minh_upload";

const fileUpload = document.querySelector("#file-upload");
const audioRender = document.querySelector("#audio-render");

console.log(fileUpload);
console.log(audioRender);

let audioURL;

fileUpload.addEventListener("change", (e) => {
  const file = e.target.files[0];

  const formData = new FormData();
  formData.append("file", file);
  formData.append("upload_preset", CLOUDINARY_UPLOAD_PRESET);
  console.log(formData);

  axios({
    url: CLOUDINARY_URL,
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data",
    },
    data: formData,
  })
    .then((response) => {
      audioURL = response.data["secure_url"];
      audioRender.src = audioURL;
    })
    .catch((err) => {
      console.log(err);
    });
});
