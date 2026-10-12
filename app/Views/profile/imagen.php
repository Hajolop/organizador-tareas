<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.editImageTitle') ?></h1>

    <form action="/profile/image" method="post" enctype="multipart/form-data" class="formulario">
        <?= csrf_field() ?>

        <label for="imagen"><?= lang('App.chooseImage') ?></label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.save') ?></button>
            <a href="/profile" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
