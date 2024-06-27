<?= $this->extend('/layout/listmusicalbum_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= $playlist['images'][0]['url'] ?? base_url('assets/img/default_playlist.png'); ?>" alt="<?= $playlist['name']; ?>">
            </div>
        </div>
        <div class="column2">
            <div class="incolumn2">
                <h2 id="albumname"><?= $playlist['name']; ?></h2>
                <div class="isiincolumn2">
                <img src="<?= $playlist['images'][0]['url']; ?>" alt="<?= $playlist['owner']['display_name']; ?>">
                    <h2><?= $playlist['owner']['display_name']; ?>. </h2>
                    <h2><?= $totalTracks; ?> Lagu,</h2>
                    <h2><?= $totalDuration; ?></h2>
                </div>
                <h2><?= isset($playlist['followers']['total']) ? number_format($playlist['followers']['total']) : ''; ?> Suka</h2>
                
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
                <?php foreach ($tracks as $index => $trackItem) :
                    $track = $trackItem['track'];
                ?>
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