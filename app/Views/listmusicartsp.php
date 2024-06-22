<?= $this->extend('/layout/listmusic_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= $artis['images'][0]['url'] ?? base_url('assets/img/default_artist.png'); ?>" alt="<?= $artis['name']; ?>">
            </div>
        </div>
        <div class="column2">
            <div class="incolumn2">
                <h2><?= $artis['name']; ?></h2>
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
                <?php foreach ($lagu as $index => $l) : ?>
                    <tr data-index="<?= $index; ?>">
                        <th scope="row"><?= $index + 1; ?></th>
                        <td>
                            <a href="<?= route_to('user.lagu', $artis['id'], $l['id']); ?>" class="play-song">
                                <img src="<?= $l['album']['images'][0]['url'] ?? base_url('assets/img/default_track.png'); ?>" alt="<?= $l['name']; ?>" style="width: 50px;">
                            </a>
                        </td>
                        <td>
                            <a href="<?= route_to('user.lagu', $artis['id'], $l['id']); ?>" class="play-song">
                                <?= $l['name']; ?>
                            </a>
                        </td>

                        <td>
                            <a href="<?= route_to('user.lagu', $artis['id'], $l['id']); ?>" class="play-song">
                                <?= gmdate("i:s", $l['duration_ms'] / 1000); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?= $this->endSection(); ?>
