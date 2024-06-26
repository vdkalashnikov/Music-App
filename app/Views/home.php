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
  <p>Album Dari Spotify</p>
</div>
<div class="carousel">
  <?php foreach ($spotifyAlbums as $album) : ?>
    <div class="card">
      <div class="cardpicture2">
        <a href="<?= route_to('user.spotifyAlbum', $album['id']) ?>">
          <img src="<?= $album['images'][0]['url']; ?>" alt="<?= $album['name']; ?>">
        </a>
      </div>
      <div class="namealbum"><?= $album['name']; ?></div>
      <div class="nameart"><?= $album['artists'][0]['name']; ?></div>
    </div>
  <?php endforeach; ?>
</div>

<br>

<div class="artitle">
  <p>Artis Dari Spotify</p>
</div>
<div class="carousel">
  <?php foreach ($spotifyArtists as $artist) : ?>
    <div class="card">
      <div class="cardpicture">
        <a href="<?= route_to('user.spotifyArtist', $artist['id']); ?>">
          <?php if (isset($artist['images'][0]['url'])): ?>
              <img src="<?= $artist['images'][0]['url']; ?>" alt="<?= $artist['name']; ?>">
          <?php endif; ?>
        </a>
      </div>
      <div class="namealbum"><?= $artist['name']; ?></div>
      <!-- <div class="namealbum"><?= $artist['genres'][0] ?? 'Unknown'; ?></div> -->
    </div>
  <?php endforeach; ?>
</div>

<br>

<div class="artitle">
  <p>Playlist Dari Spotify</p>
</div>
<div class="carousel">
  <?php foreach ($spotifyPlaylists as $playlist) : ?>
    <div class="card">
      <div class="cardpicture">
        <a href="<?= route_to('user.spotifyPlaylist', $playlist['id']); ?>">
          <img src="<?= $playlist['images'][0]['url']; ?>" alt="<?= $playlist['name']; ?>">
        </a>
      </div>
      <div class="namealbum"><?= $playlist['name']; ?></div>
      <div class="namealbum"><?= $playlist['owner']['display_name']; ?></div>
    </div>
  <?php endforeach; ?>
</div>

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
