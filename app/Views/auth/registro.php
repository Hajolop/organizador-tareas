<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.signupTitle') ?></h1>

    <form action="/registro" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="name"><?= lang('App.name') ?></label>
        <input type="text" id="name" name="name" value="<?= old('name') ?>" required>

        <label for="email"><?= lang('App.email') ?></label>
        <input type="email" id="email" name="email" value="<?= old('email') ?>" required>

        <label for="password"><?= lang('App.password') ?></label>
        <input type="password" id="password" name="password" required>

        <label for="password_repeat"><?= lang('App.repeatPassword') ?></label>
        <input type="password" id="password_repeat" name="password_repeat" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.signup') ?></button>
            <a href="/" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
