<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/extra-assets/ijaboCropTool/ijaboCropTool.min.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>
<body>
<?php include('inc/navprof.php') ?>
    <div>
        <?= $this->renderSection('content'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

</body>

<script src="/extra-assets/ijaboCropTool/ijaboCropTool.min.js"></script>
<script src="/extra-assets/ijaboCropTool/jquery-1.7.1.min.js"></script>

<?= $this->renderSection('scripts'); ?>
</html>