<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? $pageTitle : 'Music App'; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="/assets/css/login.css" />
</head>

<body>
  <div class="login_form_container">
    <div class="login_form">
      <h2>Login</h2>

      <?php $validation = \Config\Services::validation(); ?>
      <form action="<?= route_to('user.login.handler'); ?>" method="POST">
        <?= csrf_field() ?>
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

        <div class="input_group">
          <i class="fa fa-user"></i>
          <input type="text" placeholder="Username" class="input_text" autocomplete="off" name="login_id" value="<?= set_value('login_id'); ?>">
        </div>
        <?php if ($validation->getError('login_id')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('login_id'); ?>
          </div>
        <?php endif; ?>

        <div class="input_group">
          <i class="fa fa-unlock-alt"></i>
          <input type="password" placeholder="Password" class="input_text" autocomplete="off" name="password" value="<?= set_value('password'); ?>">
        </div>
        <?php if ($validation->getError('password')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('password'); ?>
          </div>
        <?php endif; ?>

        <div class="button_group" id="login_button">
          <button type="submit" value="Login">Submit</button>
        </div>
        <div class="footer">
          <a>Forgot Password ?</a>
          <a>SignUp</a>
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
  </script>
</body>

</html>