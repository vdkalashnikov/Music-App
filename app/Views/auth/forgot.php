<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? $pageTitle : 'Music App'; ?></title>
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/musiclogoo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="/assets/css/forgot.css" />
</head>

<body>

  <div class="card">
        <div class="card2">
        <?php $validation = \Config\Services::validation(); ?>
          <form class="form" action="<?= route_to('user.send_password_reset_link'); ?>" method="POST">
          <?= csrf_field() ?>
          <p id="heading">Forgot Pasword</p>
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
          <div class="alert alert-success" id="berhasil">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('fail'))) : ?>
          <div class="alert alert-danger" id="gagal">
            <?= session()->getFlashdata('fail'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
          <div class="field">
          <svg viewBox="0 0 16 16" fill="currentColor" height="16" width="16" xmlns="http://www.w3.org/2000/svg" class="input-icon">
          <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"></path>
          </svg>
            <input type="text" class="input-field" placeholder="Email" name="email" autocomplete="off" value="<?= set_value('email'); ?>">
          </div>

          <?php if ($validation->getError('email')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('email'); ?>
          </div>
        <?php endif; ?>

          <!-- <button type="submit" value="Login" class="button3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Log In&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> -->
          <div class="btn">
          <button class="button1" type="submit">Submit</button>
          <button class="button2"><a id="bt2" href="<?= route_to('user.login.form'); ?>">Login</a></button>
          </div>
        </form>
      </div>
    </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.close').on('click', function() {
        $(this).parent().fadeOut();
      });
    });

    function aleert(){
      document.getElementById("berhasil").style.color = "green";
      document.getElementById("gagal").style.color = "red";
    }

    aleert()
  </script>
</body>

</html>