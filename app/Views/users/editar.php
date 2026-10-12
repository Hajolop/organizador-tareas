<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1>Edit user</h1>
    <p><a href="/users/<?= $usuario['id'] ?>" class="enlace">&lt;&lt; back</a></p>

    <form action="/users/<?= $usuario['id'] ?>/edit" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= old('name', esc($usuario['name'], 'attr')) ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= old('email', esc($usuario['email'], 'attr')) ?>" required>

        <label for="password">Password (déjalo vacío para no cambiarla)</label>
        <input type="password" id="password" name="password">

        <label for="password_repeat">Repeat password</label>
        <input type="password" id="password_repeat" name="password_repeat">

        <label class="casilla">
            <input type="checkbox" name="active" value="1" <?= $usuario['active'] ? 'checked' : '' ?>>
            Active
        </label>

        <label class="casilla">
            <input type="checkbox" name="administrator" value="1" <?= $usuario['administrator'] ? 'checked' : '' ?>>
            Administrator
        </label>

        <div class="botones">
            <button type="submit" class="boton-verde">Save</button>
            <a href="/users/<?= $usuario['id'] ?>" class="boton-rojo">Cancel</a>
        </div>
    </form>
<?= $this->endSection() ?>
