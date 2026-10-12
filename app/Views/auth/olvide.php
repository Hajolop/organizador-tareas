<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.forgotTitle') ?></h1>

    <form action="/forgot" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="email"><?= lang('App.email') ?></label>
        <input type="email" id="email" name="email" value="<?= old('email') ?>" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.send') ?></button>
            <a href="/login" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
