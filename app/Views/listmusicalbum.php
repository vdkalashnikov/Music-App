<?= $this->extend('/layout/listmusicalbum_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= base_url('img_album/' . $album['gambar_album']); ?>" alt="<?= $album['nama_album']; ?>">
            </div>
        </div>
        <div class="column2">
            <div class="incolumn2">
                <h2 id="albumname"><?= $album['nama_album']; ?></h2>
                <h2><?= $album['nama']; ?></h2>
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
            <tbody>
            <?php foreach ($lagu as $index => $l) : ?>
                <tr  data-index="<?= $index; ?>">
                    <th scope="row">1</th>
                    <td><img src="<?= base_url('image/' . $l['gambar']); ?>" alt="<?= $l['nama_lagu']; ?>" style="width: 50px;">
                </td>
                    <td>
                    <?= $l['nama_lagu']; ?>
                    </td>
                    <td>
                    <?= $l['durasi']; ?>
                    </td>
                </tr>
            </tbody>
            <?php endforeach ?>
        </table>
    </div>
</section>


<?= $this->endSection(); ?>