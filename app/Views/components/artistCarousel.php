<div class="carousel">
    <?php foreach ($items as $a) : ?>
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