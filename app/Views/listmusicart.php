<?= $this->extend('/layout/listmusic_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= base_url('assets/img/' . $artis['artimg']); ?>" alt="<?= $artis['name']; ?>">
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
                            <a href="<?= route_to('user.lagu', $l['artis_id'], $l['id']); ?>" class="play-song">
                                <img src="<?= base_url('image/' . $l['image']); ?>" alt="<?= $l['name']; ?>" style="width: 50px;">
                            </a>
                        </td>
                        <td>
                            <a href="<?= route_to('user.lagu', $l['artis_id'], $l['id']); ?>" class="play-song">
                                <?= $l['name']; ?>
                            </a>
                        </td>

                        <td>
                            <a href="<?= route_to('user.lagu', $l['artis_id'], $l['id']); ?>" class="play-song">
                                <?= $l['durasi']; ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const logoutLink = document.getElementById('logout');

        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari sesi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = logoutLink.href;
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>