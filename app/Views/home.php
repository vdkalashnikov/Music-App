<?= $this->extend('/layout/pages_layout'); ?>
<?= $this->section('content'); ?>

<div class="message">
  <h2 id="greeting"></h2>
</div>
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
  <?php foreach ($artis as $a) : ?>
    <div class="card">
      <div class="cardpicture2">
        <a href="">
          <img src="<?= base_url('image/' . $a['picture']); ?>">
        </a>
      </div>
      <div class="nameart"><?= $a['nama']; ?></div>
    </div>
  <?php endforeach; ?>
</div>
<br>


<?= $this->endSection(); ?>