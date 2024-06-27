<?= $this->extend('/layout/listmusicalbum_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= $album['images'][0]['url']; ?>" alt="<?= $album['name']; ?>">
            </div>
        </div>
        <div class="column2">
            <div class="incolumn2">
                <h2 id="albumname"><?= $album['name']; ?></h2>
                <div class="isiincolumn2">
                    <img src="<?= $album['images'][0]['url']; ?>" alt="<?= $album['artists'][0]['name']; ?>">
                    <h2><?= $album['artists'][0]['name']; ?> . <?= $jumlahLagu; ?> Lagu, <?= $totalDuration; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="contain2">
        <table class="table table-dark table-borderless">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Lagu</th>
                    <th scope="col">Durasi</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lagu as $index => $track) : ?>
                    <tr data-index="<?= $index; ?>">
                        <th scope="row"><?= $index + 1; ?></th>
                        <td><?= $track['name']; ?></td>
                        <td><?= gmdate("i:s", $track['duration_ms'] / 1000); ?></td>
                        <td><a href="<?= route_to('user.spotifyTrack', $track['id']); ?>">Play</a></td>
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
