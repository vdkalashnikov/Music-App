<?= $this->extend('/layout/lagu_layout'); ?>
<?= $this->section('content'); ?>

<div class="player">
    <div class="wrapper">
        <a id="back" href="<?= route_to($type == 'artis' ? 'user.artis' : 'user.album', $subject['id']); ?>"><i class="bi bi-music-note-list"></i></a>
        <div class="details">
            <div class="now-playing">PLAYING x OF y</div>
            <div class="track-art" style="background-image: url('<?= base_url('image/' . $currentLagu['image']); ?>');"></div>
            <div class="track-name"><?= $currentLagu['name']; ?></div>
            <div class="track-artist"><?= $currentLagu['name_artis']; ?></div>
        </div>
        <div class="triple">
            <div class="slider_container">
                <div class="current-time">00:00</div>
                <input type="range" min="1" max="100" value="0" class="seek_slider" onchange="seekTo()">
                <div class="total-duration">00:00</div>
            </div>

            <div class="slider_container">
                <i class="fa fa-volume-down"></i>
                <input type="range" min="1" max="100" value="99" class="volume_slider" onchange="setVolume()">
                <i class="fa fa-volume-up"></i>
            </div>

            <div class="buttons">
                <div class="random-track" onclick="randomTrack()">
                    <i class="fa fa-random" title="random"></i>
                </div>
                <div class="prev-track" onclick="prevTrack()">
                    <i class="fa fa-step-backward"></i>
                </div>
                <div class="playpause-track" onclick="playpauseTrack()">
                    <i class="fa fa-play-circle"></i>
                </div>
                <div class="next-track" onclick="nextTrack()">
                    <i class="fa fa-step-forward"></i>
                </div>
                <div class="repeat-track" onclick="repeatTrack()">
                    <i class="fa fa-repeat" title="repeat"></i>
                </div>
            </div>
        </div>
        <!-- <div id="wave">
            <span class="stroke"></span>
            <span class="stroke"></span>
            <span class="stroke"></span>
            <span class="stroke"></span>
            <span class="stroke"></span>
            <span class="stroke"></span>
        </div> -->
    </div>
</div>

<script>
    let musicList = <?= json_encode(array_map(function ($lagu) {
                        return [
                            'img' => base_url('image/' . $lagu['image']),
                            'name' => $lagu['name'],
                            'artist' => $lagu['name_artis'],
                            'music' => base_url('song/' . $lagu['file']),
                        ];
                    }, $laguList)); ?>;

    let currentTrackIndex = <?= array_search($currentLagu, $laguList); ?>;
</script>

<?= $this->endSection(); ?>