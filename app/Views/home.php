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
  <?php foreach ($spotifyTracksOne as $trackOne) : ?>
    <div class="card">
      <div class="cardpicture2">
        <a href="<?= route_to('user.spotifyAlbum', $trackOne['album']['id']) ?>">
          <img src="<?= $trackOne['album']['images'][0]['url']; ?>">
        </a>
      </div>
      <div class="namealbum"><?= $trackOne['album']['name']; ?></div>
      <div class="nameart"><?= $trackOne['artists'][0]['name']; ?></div>
    </div>
  <?php endforeach; ?>
</div>
<br>
<div class="artitle">
  <p>Spotify Tracks</p>
</div>
<div class="carousel">
  <?php foreach ($spotifyTracksTwo as $trackTwo) : ?>
    <div class="card">
      <div class="cardpicture2">
        <a href="<?= route_to('user.spotifyAlbum', $trackTwo['album']['id']) ?>">
          <img src="<?= $trackTwo['album']['images'][0]['url']; ?>">
        </a>
      </div>
      <div class="namealbum"><?= $trackTwo['album']['name']; ?></div>
      <div class="nameart"><?= $trackTwo['artists'][0]['name']; ?></div>
    </div>
  <?php endforeach; ?>
</div>

<br>

<div class="artitle">
  <p>Spotify Artists</p>
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
      <div class="namealbum"><?= $artist['genres'][0] ?? 'Unknown'; ?></div>
    </div>
  <?php endforeach; ?>
</div>

<br>

<div class="artitle">
  <p>Spotify Playlists</p>
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
    
</script>
<?= $this->endSection(); ?>
