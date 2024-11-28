<div class="carousel">
  <?php foreach ($items as $ab) : ?>
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