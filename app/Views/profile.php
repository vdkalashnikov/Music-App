<?= $this->extend('/layout/profile_layout'); ?>
<?= $this->section('content'); ?>


<section class="section1">
    <div class="cont1">
        <div class="isi">
            <img src="<?= get_user()->picture == null ? '/imagepro/user/default_avatar.png' : '/imagepro/user' . get_user()->picture ?>" alt="">
        </div>
        <a href="javascript::" onclick="event.preventDefault();document.getElementById('user_profile_file').click();"><i class="bi bi-pencil"></i></a>
        <input type="file" name="user_profile_file" id="user_profile_file" class="d-none" style="opacity: 0;">
    </div>
    <div class="cont2">

        <b><p class="user-fullname">
            <?= get_user()->name; ?>
        </p></b>

        <p class="user-name">
            <?= get_user()->username; ?>
        </p>
        <p class="user-email">
            <?= get_user()->email; ?>
        </p>
    </div>
</section>

<section class="section2">
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
</section>

<?= $this->endSection(); ?>

<script>
    $(document).ready(function() {
        $('.close').on('click', function() {
            $(this).parent().fadeOut();
        });
    });
</script>


<!-- <script>
    $('#personal_details_from').on('submit', function(e){
        e.preventDefault();
        var form = this;
        var formdata = new FormData(form);

        $.ajax({
            url:$(form).attr('action'),
            method:$(form).attr('method'),
            data:formdata,
            processData:false,
            dataType:'json',
            contentType:'false',
            beforeSend:function(){
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success:function(response){
                if( $.isEmptyObject(response.error) ){
                    if( response.status == 1 ){
                        $('.user-name').each(function() {
                            $(this).html(response.user_info.name);
                        });
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    } 
                } else {
                    $.each(response.error, function(prefix, val){
                        $(form).find('span.'+prefix+'_error').text(val);
                    });
                }
            }
        });
    });
</script> -->