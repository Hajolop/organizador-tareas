<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.editUserTitle') ?></h1>
    <p><a href="/users/<?= $usuario['id'] ?>" class="enlace"><?= lang('App.back') ?></a></p>

    <form action="/users/<?= $usuario['id'] ?>/edit" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="name"><?= lang('App.name') ?></label>
        <input type="text" id="name" name="name" value="<?= old('name', esc($usuario['name'], 'attr')) ?>" required>

        <label for="email"><?= lang('App.email') ?></label>
        <input type="email" id="email" name="email" value="<?= old('email', esc($usuario['email'], 'attr')) ?>" required>

        <label for="password"><?= lang('App.passwordKeep') ?></label>
        <input type="password" id="password" name="password">

        <label for="password_repeat"><?= lang('App.repeatPassword') ?></label>
        <input type="password" id="password_repeat" name="password_repeat">

        <label class="casilla">
            <input type="checkbox" name="active" value="1" <?= $usuario['active'] ? 'checked' : '' ?>>
            <?= lang('App.active') ?>
        </label>

        <label class="casilla">
            <input type="checkbox" name="administrator" value="1" <?= $usuario['administrator'] ? 'checked' : '' ?>>
            <?= lang('App.administrator') ?>
        </label>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= lang('App.save') ?></button>
            <a href="/users/<?= $usuario['id'] ?>" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
