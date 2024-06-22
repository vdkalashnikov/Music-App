<?= $this->extend('/layout/lagu_layout'); ?>
<?= $this->section('content'); ?>

<div class="player">
    <div class="wrapper">
        <div class="details">
            <div class="now-playing">PLAYING</div>
            <div class="track-art" style="background-image: url('<?= $track['album']['images'][0]['url']; ?>');"></div>
            <div class="track-name"><?= $track['name']; ?></div>
            <div class="track-artist"><?= $track['artists'][0]['name']; ?></div>
        </div>

        <div class="buttons">
            <a href="<?= $track['external_urls']['spotify']; ?>" target="_blank">Play on Spotify</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
