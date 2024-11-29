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
                            <a href="<?= route_to($route, $l['artis_id'], $l['id']); ?>" class="play-song">
                                <img src="<?= base_url('image/' . $l['image']); ?>" alt="<?= $l['name']; ?>" style="width: 50px;">
                            </a>
                        </td>
                        <td>
                            <a href="<?= route_to($route, $l['artis_id'], $l['id']); ?>" class="play-song">
                                <?= $l['name']; ?>
                            </a>
                        </td>

                        <td>
                            <a href="<?= route_to($route, $l['artis_id'], $l['id']); ?>" class="play-song">
                                <?= $l['durasi']; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>