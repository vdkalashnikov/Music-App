document.addEventListener('DOMContentLoaded', (event) => {
    let nowPlaying = document.querySelector('.now-playing');
    let trackArt = document.querySelector('.track-art');
    let trackName = document.querySelector('.track-name');
    let trackArtist = document.querySelector('.track-artist');
    let playpauseBtn = document.querySelector('.playpause-track');
    let nextBtn = document.querySelector('.next-track');
    let prevBtn = document.querySelector('.prev-track');
    let repeatBtn = document.querySelector('.repeat-track');
    let seekSlider = document.querySelector('.seek_slider');
    let volumeSlider = document.querySelector('.volume_slider');
    let currTime = document.querySelector('.current-time');
    let totalDuration = document.querySelector('.total-duration');
    let randomIcon = document.querySelector('.fa-random');
    let currTrack = document.createElement('audio');

    let trackIndex = currentTrackIndex;
    let isPlaying = false;
    let isRandom = false;
    let updateTimer;

    function loadTrack(trackIndex) {
        clearInterval(updateTimer);
        reset();

        currTrack.src = musicList[trackIndex].music;
        currTrack.load();

        trackArt.style.backgroundImage = "url(" + musicList[trackIndex].img + ")";
        trackName.textContent = musicList[trackIndex].name;
        trackArtist.textContent = musicList[trackIndex].artist;
        nowPlaying.textContent = "Playing music " + (trackIndex + 1) + " of " + musicList.length;

        updateTimer = setInterval(setUpdate, 1000);

        currTrack.addEventListener('ended', nextTrack);
    }

    function reset() {
        currTime.textContent = "00:00";
        totalDuration.textContent = "00:00";
        seekSlider.value = 0;
    }

    function randomTrack() {
        isRandom ? pauseRandom() : playRandom();
    }

    function playRandom() {
        isRandom = true;
        randomIcon.classList.add('randomActive');
        document.querySelector('.fa-random').style.color = "green";
    }

    function pauseRandom() {
        isRandom = false;
        randomIcon.classList.remove('randomActive');
        document.querySelector('.fa-random').style.color = "black";
    }

    function repeatTrack() {
        let currentIndex = trackIndex;
        loadTrack(currentIndex);
        playTrack();
    }

    function playpauseTrack() {
        isPlaying ? pauseTrack() : playTrack();
    }

    function playTrack() {
        currTrack.play();
        isPlaying = true;
        trackArt.classList.add('rotate');
        playpauseBtn.innerHTML = '<i class="fa fa-pause-circle fa-4x"></i>';
    }

    function pauseTrack() {
        currTrack.pause();
        isPlaying = false;
        trackArt.classList.remove('rotate');
        playpauseBtn.innerHTML = '<i class="fa fa-play-circle fa-4x"></i>';
    }

    function nextTrack() {
        if (trackIndex < musicList.length - 1 && isRandom === false) {
            trackIndex += 1;
        } else if (trackIndex < musicList.length - 1 && isRandom === true) {
            let randomIndex = Math.floor(Math.random() * musicList.length);
            trackIndex = randomIndex;
        } else {
            trackIndex = 0;
        }
        loadTrack(trackIndex);
        playTrack();
    }

    function prevTrack() {
        if (trackIndex > 0) {
            trackIndex -= 1;
        } else {
            trackIndex = musicList.length - 1;
        }
        loadTrack(trackIndex);
        playTrack();
    }

    function seekTo() {
        let seekTo = currTrack.duration * (seekSlider.value / 100);
        currTrack.currentTime = seekTo;
    }

    function setVolume() {
        currTrack.volume = volumeSlider.value / 100;
    }

    function setUpdate() {
        let seekPosition = 0;
        if (!isNaN(currTrack.duration)) {
            seekPosition = currTrack.currentTime * (100 / currTrack.duration);
            seekSlider.value = seekPosition;

            let currentMinutes = Math.floor(currTrack.currentTime / 60);
            let currentSeconds = Math.floor(currTrack.currentTime - currentMinutes * 60);
            let durationMinutes = Math.floor(currTrack.duration / 60);
            let durationSeconds = Math.floor(currTrack.duration - durationMinutes * 60);

            if (currentSeconds < 10) { currentSeconds = "0" + currentSeconds; }
            if (durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
            if (currentMinutes < 10) { currentMinutes = "0" + currentMinutes; }
            if (durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }

            currTime.textContent = currentMinutes + ":" + currentSeconds;
            totalDuration.textContent = durationMinutes + ":" + durationSeconds;
        }
    }

    playpauseBtn.addEventListener('click', playpauseTrack);
    nextBtn.addEventListener('click', nextTrack);
    prevBtn.addEventListener('click', prevTrack);
    seekSlider.addEventListener('change', seekTo);
    volumeSlider.addEventListener('change', setVolume);
    randomIcon.addEventListener('click', randomTrack);
    repeatBtn.addEventListener('click', repeatTrack);

    loadTrack(trackIndex);
});
