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
                <div class="isiincolumn2">
                    <img src="<?= base_url('image/' . $album['picture']); ?>" alt="<?= $album['nama']; ?>">
                    <h2><?= $album['nama']; ?> . <?= $jumlahLagu; ?> Lagu, <?= $totalDuration; ?></h2>
                </div>
                
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
    <tr data-index="<?= $index; ?>">
        <th scope="row"><?= $index + 1; ?></th>
        <td>
            <a href="<?= route_to('user.lagu.album', $album['id_album'], $l['id']); ?>">
                <img src="<?= base_url('image/' . $l['gambar']); ?>" alt="<?= $l['nama_lagu']; ?>" style="width: 50px;">
            </a>
        </td>
        <td>
            <a href="<?= route_to('user.lagu.album', $album['id_album'], $l['id']); ?>">
            <?= $l['nama_lagu']; ?>
            </a>
        </td>
        <td>
            <a href="<?= route_to('user.lagu.album', $album['id_album'], $l['id']); ?>">
            <?= $l['durasi']; ?>
            </a>
        </td>
    </tr>
<?php endforeach ?>
</tbody>
        </table>
    </div>
</section>


<?= $this->endSection(); ?>