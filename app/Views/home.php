<?= $this->extend('/layout/pages_layout'); ?>
<?= $this->section('content'); ?>

<div class="message">
  <h2 id="greeting"></h2>
</div>
<div class="swal" data-swal="<?= session('success'); ?>"></div>
<hr>
<div class="artitle">
  <p>Artis Terpopuler</p>
</div>
<?= view('components/homeCarousel', ['items' => $artis, 'route' => 'user.artis', 'store' => 'image', 'type' => 'artis']) ?>

<br>
<div class="artitle">
  <p>Album Terpopuler</p>
</div>
<?= view('components/homeCarousel', ['items' => $album, 'route' => 'user.album', 'store' => 'img_album', 'type' => 'album']) ?>

<br>



<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const swalElement = document.querySelector('.swal');
    const swalData = swalElement.dataset.swal;

    if (swalData) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: swalData,
            showConfirmButton: false,
            timer: 1900
        });
    }

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
