<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.resetTitle') ?></h1>

    <form action="/reset/<?= esc($token, 'attr') ?>" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="password"><?= lang('App.password') ?></label>
        <input type="password" id="password" name="password" required>

        <label for="password_repeat"><?= lang('App.repeatPassword') ?></label>
        <input type="password" id="password_repeat" name="password_repeat" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.resetButton') ?></button>
        </div>
    </form>
<?= $this->endSection() ?>
