<?= $this->extend('/layout/listmusicalbum_layout'); ?>
<?= $this->section('content'); ?>

<section>
    <div class="contain">
        <div class="column1">
            <div class="incolumn1">
                <img src="<?= base_url('img_album/' . $album['image']); ?>" alt="<?= $album['name']; ?>">
            </div>
        </div>
        <div class="column2">
            <div class="incolumn2">
                <h2 id="albumname"><?= $album['name']; ?></h2>
                <div class="isiincolumn2">
                    <a href="<?= route_to('user.artis', $artis['id']); ?>"><img src="<?= base_url('image/' . $artis['image']); ?>" alt="<?= $artis['name']; ?>"></a>
                    <h2><?= $album['name']; ?> . <?= $jumlahLagu; ?> Lagu, <?= $totalDuration; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <?= view('components/table/tableListMusic', ['lagu' => $lagu, 'subject' => $album, 'route' => 'user.lagu.album']); ?>
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