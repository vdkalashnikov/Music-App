<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? $pageTitle : 'Music App'; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="/assets/css/register.css" />
</head>

<body>
  <div class="login_form_container">
    <div class="login_form">
      <h2>Login</h2>

      <?php $validation = \Config\Services::validation(); ?>
      <form action="<?= route_to('user.save'); ?>" method="POST">
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
          <input type="text" placeholder="Name" class="input_text" autocomplete="off" name="name" value="<?= set_value('name'); ?>">
        </div>
        <?php if ($validation->getError('name')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('name'); ?>
          </div>
        <?php endif; ?>

        <div class="input_group">
          <i class="fa fa-user"></i>
          <input type="email" placeholder="Email Addres" class="input_text" autocomplete="off" name="email" value="<?= set_value('email'); ?>">
        </div>
        <?php if ($validation->getError('email')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('email'); ?>
          </div>
        <?php endif; ?>

        <div class="input_group">
          <i class="fa fa-user"></i>
          <input type="text" placeholder="Username" class="input_text" autocomplete="off" name="username" value="<?= set_value('username'); ?>">
        </div>
        <?php if ($validation->getError('username')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('username'); ?>
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

        <div class="input_group">
          <i class="fa fa-unlock-alt"></i>
          <input type="password" placeholder="Password" class="input_text" autocomplete="off" name="confirm_password" value="<?= set_value('confirm_password'); ?>">
        </div>
        <?php if ($validation->getError('confirm_password')) : ?>
          <div class="d-block text-danger" style="margin-bottom:15px;">
            <?= $validation->getError('confirm_password'); ?>
          </div>
        <?php endif; ?>

        <div class="button_group" id="login_button">
          <button type="submit" value="Register">Submit</button>
        </div>
        <div class="footer">
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