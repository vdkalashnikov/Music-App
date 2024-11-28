<?= $this->extend('/layout/profile_layout'); ?>
<?= $this->section('content'); ?>

<section class="section1">
    <div class="cont1">
        <div class="isi">
            <img src="<?= get_user()->picture == null ? '/imagepro/user/default_avatar.png' : '/imagepro/user/' . get_user()->picture ?>" class="avatar-photo" alt="">
        </div>
        <a href="javascript:;" onclick="event.preventDefault();document.getElementById('user_profile_file').click();"><i class="bi bi-pencil"></i></a>
        <input type="file" name="user_profile_file" id="user_profile_file" class="d-none" style="opacity: 0;">
    </div>
    <div class="cont2">

        <b>
            <p class="user-fullname">
                <?= get_user()->name; ?>
            </p>
        </b>

        <p class="user-name">
            <?= get_user()->username; ?>
        </p>
        <p class="user-email">
            <?= get_user()->email; ?> 
        </p>
        <p class="user-bio">
            <?= get_user()->bio; ?>
        </p>
    </div>
</section>

<section class="section2">
    <div class="insect">
        <header>
            <h2>Ubah Profil</h2>
        </header>
        <?php $validation = \Config\Services::validation(); ?>
        <form action="<?= route_to('user.profile.update'); ?>" method="POST" id="personal_details_form">
            <?= csrf_field(); ?>
            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('fail'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Nama</label>
                <input type="text" class="form-control" id="exampleInputName1" placeholder="Name..." name="name" value="<?= old('name', get_user()->name); ?>">
            </div>
            <?php if ($validation->getError('name')) : ?>
                <div class="d-block text-danger" style="margin-top:-10px;margin-bottom:15px;">
                    <?= $validation->getError('name'); ?>
                </div>
            <?php endif; ?>

            <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">Username</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username..." name="username" value="<?= old('username', get_user()->username); ?>">
            </div>
            <?php if ($validation->getError('username')) : ?>
                <div class="d-block text-danger" style="margin-top:-10px;margin-bottom:15px;">
                    <?= $validation->getError('username'); ?>
                </div>
            <?php endif; ?>

            <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputUsername1" placeholder="Email..." name="email" value="<?= old('email', get_user()->email); ?>">
            </div>
            <?php if ($validation->getError('email')) : ?>
                <div class="d-block text-danger" style="margin-top:-10px;margin-bottom:15px;">
                    <?= $validation->getError('email'); ?>
                </div>
            <?php endif; ?>

            <div class="mb-2">
                <label for="exampleFormControlTextarea1" class="form-label">Bio</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Bio..." rows="3" name="bio"><?= old('bio', get_user()->bio); ?></textarea>
            </div>
            <?php if ($validation->getError('bio')) : ?>
                <div class="d-block text-danger" style="margin-top:-10px;margin-bottom:15px;">
                    <?= $validation->getError('bio'); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
    <div class="insect">
        <header>
            <h2>Ubah Password</h2>
        </header>

        <form action="<?= route_to('user.change.password'); ?>" method="POST" id="change_password_form">
            <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="ci_csrf_data">
            <?= csrf_field(); ?>

            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Password Sebelumnya</label>
                <input type="password" class="form-control" id="exampleInputpassword" placeholder="Password Sebelumnya..." name="current_password">
                <span class="text-danger error-text current_password_error"></span>
            </div>

            <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="exampleInputUserpassword" placeholder="Password Baru..." name="new_password">
                <span class="text-danger error-text new_password_error"></span>
            </div>

            <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="exampleInputUserpassword" placeholder="Konfirmasi Password Baru..." name="confirm_new_password">
                <span class="text-danger error-text confirm_new_password_error"></span>
            </div>

            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </form>
    </div>

</section>

<?= $this->endSection(); ?>

<script>
    $(document).ready(function() {
        $('.close').on('click', function() {
            $(this).parent().fadeOut();
        });
    });
</script>

<?= $this->section('scripts'); ?>
<script>
    $('#user_profile_file').ijaboCropTool({
        preview: '.avatar-photo',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        processUrl: '<?= route_to('user.update.picture'); ?>',
        withCSRF: ['<?= csrf_token() ?>', '<?= csrf_hash() ?>'],
        onSuccess: function(message, element, status) {
            if (status == 1) {
                toastr.success(message);
            } else {
                toastr.error(message);
            }
            // alert(message);
        },
        onError: function(message, element, status) {
            alert(message);
        }
    });

    $('#change_password_form').on('submit', function(e) {
        e.preventDefault();

        var csrfName = $('.ci_csrf_data').attr('name');
        var csrfHash = $('.ci_csrf_data').val();
        var form = this;
        var formData = new FormData(form);
        formData.append(csrfName, csrfHash);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                $('.ci_csrf_data').val(response.token);

                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $(form)[0].reset();
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', (event) => {
        const logoutLink = document.getElementById('logout');

        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari sesi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = logoutLink.href;
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>