<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.editProfileTitle') ?></h1>

    <form action="/profile/edit" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="name"><?= lang('App.name') ?></label>
        <input type="text" id="name" name="name" value="<?= old('name', esc($usuario['name'], 'attr')) ?>" required>

        <label for="email"><?= lang('App.email') ?></label>
        <input type="email" id="email" name="email" value="<?= old('email', esc($usuario['email'], 'attr')) ?>" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.save') ?></button>
            <a href="/profile" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
