<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? $pageTitle : 'Music App'; ?></title>
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/musiclogoo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"/>
  <link rel="stylesheet" href="/assets/css/reset.css" />

  <style>
    .password-container {
      position: relative;
    }

    .password-container input[type="password"],
    .password-container input[type="text"] {
      padding-right: 30px;
    }

    .password-container .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      display: none;
      color: white;
    }

    .password-container.show .toggle-password {
      display: block;
    }
  </style>
</head>

<body>
  

  <div class="card">
        <div class="card2">
        <?php $validation = \Config\Services::validation(); ?>
          <form class="form" action="<?= route_to('reset-password-handler', $token); ?>" method="POST">
          <?= csrf_field() ?>
          <p id="heading">Reset Password</p>
          <?php if (!empty(session()->getFlashdata('success'))) : ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <?php if (!empty(session()->getFlashdata('fail'))) : ?>
          <div class="alert alert-danger">
            <?= session()->getFlashdata('fail'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
          <div class="field password-container">
          <svg viewBox="0 0 16 16" fill="currentColor" height="16" width="16" xmlns="http://www.w3.org/2000/svg" class="input-icon">
          <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
          </svg>
            <input type="password" class="input-field" placeholder="New Password..." name="new_password" autocomplete="off" value="<?= set_value('new_password'); ?>" oninput="toggleIconVisibility(this)">
            <i class="bi bi-eye toggle-password" onclick="togglePasswordVisibility(this)"></i>
          </div>

          <?php if ($validation->getError('new_password')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('new_password'); ?>
          </div>
        <?php endif; ?>

          <div class="field password-container">
          <svg viewBox="0 0 16 16" fill="currentColor" height="16" width="16" xmlns="http://www.w3.org/2000/svg" class="input-icon">
          <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
          </svg>
            <input type="password" class="input-field" placeholder="Confirm New Password..." name="confirm_new_password" value="<?= set_value('confirm_new_password'); ?>" oninput="toggleIconVisibility(this)">
            <i class="bi bi-eye toggle-password" onclick="togglePasswordVisibility(this)"></i>
          </div>

          <?php if ($validation->getError('confirm_new_password')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('confirm_new_password'); ?>
          </div>
        <?php endif; ?>

          <button type="submit" class="button3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
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

    function togglePasswordVisibility(icon) {
      var passwordField = icon.previousElementSibling;
      var passwordFieldType = passwordField.getAttribute("type");
      if (passwordFieldType === "password") {
        passwordField.setAttribute("type", "text");
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        passwordField.setAttribute("type", "password");
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }

    function toggleIconVisibility(input) {
      var passwordContainer = input.parentElement;
      if (input.value) {
        passwordContainer.classList.add('show');
      } else {
        passwordContainer.classList.remove('show');
      }
    }
  </script>
</body>

</html>