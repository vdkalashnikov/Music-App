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
    
    <?= view('components/table/tableListMusic', ['lagu' => $lagu, 'subject' => $artis, 'route' => 'user.lagu']); ?>

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