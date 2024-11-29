<div class="carousel">
    <?php foreach ($items as $a) : ?>
        <div class="card">
            <div class="<?= $type == 'artis' ? 'cardpicture' : 'cardpicture2'; ?>">
                <a href="<?= route_to($route, $a['id']) ?>">
                    <img src="<?= base_url("$store/" . $a['image']); ?>">
                </a>
            </div>
            <div class="nameart"><?= $a['name']; ?></div>
            <?php if ($type == 'album') : ?>
            <div class="nameart"><?= $a['name_artis']; ?></div>
            <?php endif ?>
        </div>
    <?php endforeach; ?>
</div>