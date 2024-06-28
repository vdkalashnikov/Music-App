<p align="center">Dear
    <?= $email_data['user']->name; ?>
</p>
<hr>
<p>
    Kami telah menerima permintaan untuk mereset password Music App dengan akun yang terhubung <i>
        <?= $email_data['user']->email;?></i> . Kamu bisa mereset password dengan menekan tombol di bawah:
    <br><br>
    <a href="<?= $email_data['actionLink']; ?>"><button style="padding: 10px; border-radius:5px; background-color:rgb(32, 157, 13); color:white; border:none; cursor:pointer; text-decoration:none;">Reset Password</button></a>
    <br><br>
    NB: Permintaan reset password ini berlaku selama 1 jam.
    <br><br>
    Jika kamu tidak meminta untuk mereset password, tolong abaikan email ini.
</p>