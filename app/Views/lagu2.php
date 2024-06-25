<?= $this->extend('/layout/lagu2_layout'); ?>
<?= $this->section('content'); ?>

<div class="player">
    <div class="wrapper">
    <a id="back" href="<?= route_to('user.search'); ?>"><i class="bi bi-music-note-list"></i></a>
        <div class="details">
            <!-- Menampilkan jumlah lagu dalam antrian -->
            <div class="now-playing">PLAYING 1 OF <?= count($laguList); ?></div>
            <div class="track-art" style="background-image: url('<?= isset($currentLagu['gambar']) ? base_url('image/' . $currentLagu['gambar']) : base_url('image/default.jpg'); ?>');"></div>
            <div class="track-name"><?= isset($currentLagu['nama_lagu']) ? $currentLagu['nama_lagu'] : 'Tidak ada lagu ditemukan'; ?></div>
            <div class="track-artist"><?= isset($currentLagu['nama_artis']) ? $currentLagu['nama_artis'] : 'Artis tidak diketahui'; ?></div>
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
                    <i class="fas fa-random fa-2x" title="acak"></i>
                </div>
                <div class="prev-track" onclick="prevTrack()">
                    <i class="fa fa-step-backward fa-2x"></i>
                </div>
                <div class="playpause-track" onclick="playpauseTrack()">
                    <i class="fa fa-play-circle fa-4x"></i>
                </div>
                <div class="next-track" onclick="nextTrack()">
                    <i class="fa fa-step-forward fa-2x"></i>
                </div>
                <div class="repeat-track" onclick="repeatTrack()">
                    <i class="fa fa-repeat fa-2x" title="ulang"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let musicList = <?= json_encode(array_map(function ($lagu) {
        return [
            'img' => base_url('image/' . (isset($lagu['gambar']) ? $lagu['gambar'] : 'default.jpg')),
            'name' => isset($lagu['nama_lagu']) ? $lagu['nama_lagu'] : 'Tidak ada judul',
            'artist' => isset($lagu['nama']) ? $lagu['nama'] : 'Artis tidak diketahui',
            'music' => base_url('song/' . (isset($lagu['file_lagu']) ? $lagu['file_lagu'] : 'default.mp3')),
        ];
    }, $laguList)); ?>;

    let currentTrackIndex = <?= $currentLagu ? array_search($currentLagu, $laguList) : 0; ?>;
</script>

<?= $this->endSection(); ?>
