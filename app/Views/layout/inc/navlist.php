<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="bi bi-music-note-beamed"></i></a>
    <a class="navbar-brand" href="#">
      <div class="name">Music Player</div>
    </a>
    <button class="navbar-toggler"  id="toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"  id="togle"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= route_to('user.home'); ?>"><i class="bi bi-house"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= route_to('user.search'); ?>"><i class="bi bi-search"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= route_to('user.profile'); ?>"><i class="bi bi-person"></i></i></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="logout" href="<?= route_to('user.logout'); ?>"><i class="bi bi-gear"></i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>