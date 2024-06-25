<p>Dear
    <?= $mail_data['user']->name; ?>
</p>

<p>
    Password mu pada web Music App telah berhasil diubah, ini adalah kredensial baru login mu:
    <br><br>
    <b>Login ID:
        <?= $mail_data['user']->username; ?> or
        <?= $mail_data['user']->email; ?>
    </b>
    <br>
    <b>Password:
        <?= $mail_data['new_password']; ?>
    </b>
</p>
<br><br>
Dimohon untuk menjaga akun anda, username dan password anda jangan pernah diberitahukan kepada orang lain.
<p>
    Music App
</p>