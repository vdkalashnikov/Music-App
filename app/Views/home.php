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
<div class="carousel">
    <?php foreach ($artis as $a) : ?>
        <div class="card">
            <div class="cardpicture">
                <a href="<?= route_to('user.artis', $a['id_artis']) ?>">
                    <img src="<?= base_url('image/' . $a['picture']); ?>">
                </a>
            </div>
            <div class="nameart"><?= $a['nama']; ?></div>
        </div>
    <?php endforeach; ?>
</div>

<br>
<div class="artitle">
  <p>Album Terpopuler</p>
</div>
<div class="carousel">
  <?php foreach ($album as $ab) : ?>
    <div class="card">
      <div class="cardpicture2">
        <a href="<?= route_to('user.album', $ab['id_album']) ?>">
          <img src="<?= base_url('img_album/' . $ab['gambar_album']); ?>">
        </a>
      </div>
      <div class="namealbum"><?= $ab['nama_album']; ?></div>
      <div class="nameart"><?= $ab['nama']; ?></div>
    </div>
  <?php endforeach; ?>
</div>

<br>
<div class="artitle">
  <p>Spotify Tracks</p>
</div>
<div class="carousel">
  <?php foreach ($spotifyTracks as $track) : ?>
    <div class="card">
      <div class="cardpicture2">
        <a href="<?= $track['external_urls']['spotify'] ?>" target="_blank">
          <img src="<?= $track['album']['images'][0]['url']; ?>">
        </a>
      </div>
      <div class="namealbum"><?= $track['name']; ?></div>
      <div class="nameart"><?= $track['artists'][0]['name']; ?></div>
    </div>
  <?php endforeach; ?>
</div>
<br>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
    const swalElement = document.querySelector('.swal'); // Mengambil elemen dengan kelas '.swal'
    const swalData = swalElement.dataset.swal; // Mengambil data dari atribut data HTML 'data-swal'

    if (swalData) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: swalData,
            showConfirmButton: false,
            timer: 1900
        });
    }
    
</script>
<?= $this->endSection(); ?>
