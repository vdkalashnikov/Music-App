<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/sweetalert2/src/sweetalert2.min.css" />
    <link rel="stylesheet" href="/assets/css/home.css">
    <script src="/assets/js/home.js" defer></script>
    <script src="script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <title><?= isset($pageTitle) ? $pageTitle : 'Lagu'; ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/musiclogoo.png" />
</head>

<body>
    <?php include('inc/nav.php') ?>
    <div>
        <?= $this->renderSection('content'); ?>
    </div>
    <script src="/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <?= $this->renderSection('scripts'); ?>
</body>

</html>