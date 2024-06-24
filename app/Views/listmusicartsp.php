<?= $this->extend('/layout/listmusicalbum_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= $artist['images'][0]['url'] ?? base_url('assets/img/default_artist.png'); ?>" alt="<?= $artist['name']; ?>">
            </div>
        </div>
        <div class="column2">
            <div class="incolumn2">
                <h2><?= $artist['name']; ?></h2>
                <h2><?= $artist['genres'][0] ?? ''; ?></h2>
                <h2><?= isset($artist['followers']['total']) ? number_format($artist['followers']['total']) : ''; ?> Pengikut</h2>
            </div>
        </div>
    </div>

    <div class="contain2">
        <table class="table table-dark table-borderless">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Lagu</th>
                    <th scope="col">Durasi</th>
                </tr>
            </thead>
            <tbody id="song-table-body">
                <?php foreach ($tracks as $index => $track) : ?>
                    <tr>
                        <th scope="row"><?= $index + 1; ?></th>
                        <td>
                            <a href="<?= route_to('user.spotifyTrack', $track['id']); ?>" class="play-song">
                                <img src="<?= $track['album']['images'][0]['url']; ?>" alt="<?= $track['name']; ?>" style="width: 50px;">
                            </a>
                        </td>
                        <td>
                            <a href="<?= route_to('user.spotifyTrack', $track['id']); ?>" class="play-song">
                                <?= $track['name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?= route_to('user.spotifyTrack', $track['id']); ?>" class="play-song">
                                <?= gmdate("i:s", $track['duration_ms'] / 1000); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?= $this->endSection(); ?>
