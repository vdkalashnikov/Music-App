<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/listmusic.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="/assets/js/script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/icon" href="/assets/img/musiclogoo.png" />
    <title><?= isset($pageTitle) ? $pageTitle : 'Lagu'; ?></title>
    <link rel="stylesheet" type="text/css" href="/sweetalert2/src/sweetalert2.min.css" />
</head>

<body style="background-color: rgb(21, 21, 21);">
    <?php include('inc/navlist.php') ?>
    <div>
        <?= $this->renderSection('content'); ?>
    </div>
    <script src="/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <?= $this->renderSection('scripts'); ?>
</body>

</html>