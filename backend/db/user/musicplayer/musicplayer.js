// Một số bài hát có thể bị lỗi do liên kết bị hỏng. Vui lòng thay thế liên kết khác để có thể phát
// Some songs may be faulty due to broken links. Please replace another link so that it can be played

const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const PlAYER_STORAGE_KEY = "F8_PLAYER";

const player = $(".player");
const cd = $(".cd");
const heading = $("header h2");
const cdThumb = $(".cd-thumb");
const audio = $("#audio");
const playBtn = $(".btn-toggle-play");
const progress = $("#progress");
const prevBtn = $(".btn-prev");
const nextBtn = $(".btn-next");
const randomBtn = $(".btn-random");
const repeatBtn = $(".btn-repeat");
const playlist = $(".playlist");

// For upload and delete to Cloudinary and db, we need user id
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

const userid = cookieObj.userid;

// handle if user haven't login yet
if (!userid) {
  document.location.href = "../login/login.html";
}

const app = {
  currentIndex: 0,
  isPlaying: false,
  isRandom: false,
  isRepeat: false,
  config: {},
  // (1/2) Uncomment the line below to use localStorage
  // config: JSON.parse(localStorage.getItem(PlAYER_STORAGE_KEY)) || {},
  songs: [],
  setConfig: function (key, value) {
    this.config[key] = value;
    // (2/2) Uncomment the line below to use localStorage
    // localStorage.setItem(PlAYER_STORAGE_KEY, JSON.stringify(this.config));
  },
  fetchPreviousSong: function () {
    // Make post request to fetch previous playlist

    const formDataFetchPlaylist = new FormData();
    formDataFetchPlaylist.append("userid", userid);

    axios({
      url: "playlistGet.php",
      method: "POST",
      headers: {
        "Content-Type": "multipart/form-data",
      },
      data: formDataFetchPlaylist,
    })
      .then((response) => {
        if (response.data.message === "Playlist exists") {
          this.songs = response.data.playlist;
          console.log(this.songs);
          // Render playlist
          this.render();
          // Tải thông tin bài hát đầu tiên vào UI khi chạy ứng dụng
          // Load the first song information into the UI when running the app
          this.loadCurrentSong();
        } else {
          console.log(response.data);
        }
      })
      .catch((err) => {
        console.log(err);
      });
  },
  render: function () {
    const htmls = this.songs.map((song, index) => {
      return `
                        <div class="song ${
                          index === this.currentIndex ? "active" : ""
                        }" data-index="${index}">
                            <div class="body">
                                <h3 class="title">${song.title}</h3>
                                <p class="author">${song.singer}</p>
                            </div>
                            <div class="option">
                                <i class="fas fa-ellipsis-h"></i>
                            </div>
                        </div>
                    `;
    });
    playlist.innerHTML = htmls.join("");
  },
  defineProperties: function () {
    Object.defineProperty(this, "currentSong", {
      get: function () {
        return this.songs[this.currentIndex];
      },
    });
  },
  handleEvents: function () {
    const _this = this;

    // Xử lý phóng to / thu nhỏ CD
    // Handles CD enlargement / reduction
    document.onscroll = function () {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;
    };

    // Xử lý khi click play
    // Handle when click play
    playBtn.onclick = function () {
      if (_this.isPlaying) {
        audio.pause();
      } else {
        audio.play();
      }
    };

    // Khi song được play
    // When the song is played
    audio.onplay = function () {
      _this.isPlaying = true;
      player.classList.add("playing");
    };

    // Khi song bị pause
    // When the song is pause
    audio.onpause = function () {
      _this.isPlaying = false;
      player.classList.remove("playing");
    };

    // Khi tiến độ bài hát thay đổi
    // When the song progress changes
    audio.ontimeupdate = function () {
      if (audio.duration) {
        const progressPercent = Math.floor(
          (audio.currentTime / audio.duration) * 100
        );
        progress.value = progressPercent;
      }
    };

    // Xử lý khi tua song
    // Handling when seek
    progress.onchange = function (e) {
      const seekTime = (audio.duration / 100) * e.target.value;
      audio.currentTime = seekTime;
    };

    // Khi next song
    // When next song
    nextBtn.onclick = function () {
      if (_this.isRandom) {
        _this.playRandomSong();
      } else {
        _this.nextSong();
      }
      audio.play();
      _this.render();
      _this.scrollToActiveSong();
    };

    // Khi prev song
    // When prev song
    prevBtn.onclick = function () {
      if (_this.isRandom) {
        _this.playRandomSong();
      } else {
        _this.prevSong();
      }
      audio.play();
      _this.render();
      _this.scrollToActiveSong();
    };

    // Xử lý bật / tắt random song
    // Handling on / off random song
    randomBtn.onclick = function (e) {
      _this.isRandom = !_this.isRandom;
      _this.setConfig("isRandom", _this.isRandom);
      randomBtn.classList.toggle("active", _this.isRandom);
    };

    // Xử lý lặp lại một song
    // Single-parallel repeat processing
    repeatBtn.onclick = function (e) {
      _this.isRepeat = !_this.isRepeat;
      _this.setConfig("isRepeat", _this.isRepeat);
      repeatBtn.classList.toggle("active", _this.isRepeat);
    };

    // Xử lý next song khi audio ended
    // Handle next song when audio ended
    audio.onended = function () {
      if (_this.isRepeat) {
        audio.play();
      } else {
        nextBtn.click();
      }
    };

    // Lắng nghe hành vi click vào playlist
    // Listen to playlist clicks
    playlist.onclick = function (e) {
      const songNode = e.target.closest(".song:not(.active)");

      if (songNode || e.target.closest(".option")) {
        // Xử lý khi click vào song
        // Handle when clicking on the song
        if (songNode && !e.target.closest(".option")) {
          _this.currentIndex = Number(songNode.dataset.index);
          _this.loadCurrentSong();
          _this.render();
          audio.play();
        }

        // Xử lý khi click vào song option (Delete option)
        // Handle when clicking on the song option
        if (e.target.closest(".option") && songNode) {
          const formDataDeletePlaylist = new FormData();
          formDataDeletePlaylist.append("userid", userid);
          formDataDeletePlaylist.append(
            "deletePublic",
            _this.songs[Number(songNode.dataset.index)].deletePublic
          );
          formDataDeletePlaylist.append(
            "songid",
            _this.songs[Number(songNode.dataset.index)].id
          );

          axios({
            url: "songDelete.php",
            method: "POST",
            headers: {
              "Content-Type": "multipart/form-data",
            },
            data: formDataDeletePlaylist,
          })
            .then((response) => {
              if (response.data.message === "Delete song successfully") {
                songNode.remove();
                const deletedSong = _this.songs.splice(
                  Number(songNode.dataset.index),
                  1
                );
                console.log(deletedSong);
                console.log(_this.songs);
              } else {
                console.log(response.data);
              }
            })
            .catch((err) => {
              console.log(err);
            });
          songNode.remove();
        }
      }
    };
  },
  scrollToActiveSong: function () {
    setTimeout(() => {
      $(".song.active").scrollIntoView({
        behavior: "smooth",
        block: "nearest",
      });
    }, 300);
  },
  loadCurrentSong: function () {
    heading.textContent = this.currentSong.title;
    audio.src = this.currentSong.path;
  },
  loadConfig: function () {
    this.isRandom = this.config.isRandom;
    this.isRepeat = this.config.isRepeat;
  },
  nextSong: function () {
    this.currentIndex++;
    if (this.currentIndex >= this.songs.length) {
      this.currentIndex = 0;
    }
    this.loadCurrentSong();
  },
  prevSong: function () {
    this.currentIndex--;
    if (this.currentIndex < 0) {
      this.currentIndex = this.songs.length - 1;
    }
    this.loadCurrentSong();
  },
  playRandomSong: function () {
    let newIndex;
    do {
      newIndex = Math.floor(Math.random() * this.songs.length);
    } while (newIndex === this.currentIndex);

    this.currentIndex = newIndex;
    this.loadCurrentSong();
  },
  start: function () {
    // // Gán cấu hình từ config vào ứng dụng
    // // Assign configuration from config to application
    // this.loadConfig();

    this.fetchPreviousSong();

    // Định nghĩa các thuộc tính cho object
    // Defines properties for the object
    this.defineProperties();

    // Lắng nghe / xử lý các sự kiện (DOM events)
    // Listening / handling events (DOM events)
    this.handleEvents();

    // Hiển thị trạng thái ban đầu của button repeat & random
    // Display the initial state of the repeat & random button
    randomBtn.classList.toggle("active", this.isRandom);
    repeatBtn.classList.toggle("active", this.isRepeat);
  },
};

app.start();

const form = $("#song-form");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  // remember to handle input validation
  const songFile = document.querySelector("#song-upload").files[0];
  const songTitle = document.querySelector("#song-title").value;
  const songSinger = document.querySelector("#song-singer").value;

  const formData = new FormData();
  formData.append("songUpload", songFile);
  formData.append("songTitle", songTitle);
  formData.append("songSinger", songSinger);
  formData.append("userid", userid);

  axios({
    url: "songUpload.php",
    method: "POST",
    headers: {
      "Content-Type": "multipart/form-data",
    },
    data: formData,
  })
    .then((response) => {
      if (response.data.message === "Upload song successfully") {
        console.log(response.data);
        app.songs.push(response.data.uploadedSongData);
        app.render();
      } else console.log(response.data);
    })
    .catch((err) => {
      console.log(err);
    });
});
