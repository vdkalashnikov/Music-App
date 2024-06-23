<?= $this->extend('/layout/lagu_layout'); ?>
<?= $this->section('content'); ?>

<div class="player">
    <div class="wrapper">
    <?php if ($isArtistPage) : ?>
            <a id="back" href="<?= route_to('user.spotifyArtist', $track['artists'][0]['id']); ?>"><i class="bi bi-music-note-list"></i></a>
        <?php elseif ($isAlbumPage) : ?>
            <a id="back" href="<?= route_to('user.spotifyAlbum', $track['album']['id']); ?>"><i class="bi bi-music-note-list"></i></a>
        <?php elseif ($isPlaylistPage && isset($playlistId)) : ?>
            <a id="back" href="<?= route_to('user.spotifyPlaylist', $playlistId); ?>"><i class="bi bi-music-note-list"></i></a>
        <?php else : ?>
            <p>Tidak dapat menentukan asal halaman.</p>
        <?php endif; ?>
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
