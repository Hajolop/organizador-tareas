<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.editPasswordTitle') ?></h1>

    <form action="/profile/password" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="current_password"><?= lang('App.currentPassword') ?></label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password"><?= lang('App.newPassword') ?></label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="new_password_repeat"><?= lang('App.repeatNewPassword') ?></label>
        <input type="password" id="new_password_repeat" name="new_password_repeat" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.save') ?></button>
            <a href="/profile" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
