<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.deleteImage') ?></h1>

    <p class="centrado"><?= lang('App.areYouSure') ?></p>

    <form action="/profile/image/delete" method="post" class="formulario">
        <?= csrf_field() ?>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.save') ?></button>
            <a href="/profile" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
