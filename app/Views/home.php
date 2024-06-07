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
                <a href="/artis/<?= $a['id_artis'] ?>">
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
<p>Hot Hits Indonesia</p>
<div class="carousel">
  <div class="card">
    <img src="topind.jpg" class="w-100 p-3; h-100">
    <div class="album">50 Teratas - Indonesia</div>
    <div class="artist">Raim Laode,Mahalini,SZA,Miley Cyrus,dV4d</div>
  </div>
  <div class="card">
    <img src="topgl.jpg" class="w-100 p-3; h-100">
    <div class="album">50 Teratas - Global</div>
    <div class="artist">Taylor Swift,Drake,SZA,Miley Cyrus,Harry Styles,JISOO</div>
  </div>
  <div class="card">
    <img src="viralgl.jpg" class="w-100 p-3; h-100">
    <div class="album">Viral 50 - Global</div>
    <div class="artist">FIFTY FIFTY,Dilaw,Mc Larissa,LMV Music,Dendi Nata</div>
  </div>
  <div class="card">
    <img src="viralid.jpg" class="w-100 p-3; h-100">
    <div class="album">Viral 50 - Indonesia</div>
    <div class="artist">Aziz Hendra,FIFTY FIFTY,Dendi Nata,Waru Leaf</div>
  </div>
  <div class="card">
    <img src="menyesal.webp" class="w-100 p-3; h-100">
  </div>
</div>


<?= $this->endSection(); ?>