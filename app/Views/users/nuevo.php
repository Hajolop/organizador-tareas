<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1>New User</h1>
    <p><a href="/users" class="enlace">&lt;&lt; back to index</a></p>

    <form action="/users/new" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= old('name') ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= old('email') ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="password_repeat">Repeat password</label>
        <input type="password" id="password_repeat" name="password_repeat" required>

        <div class="botones">
            <button type="submit" class="boton-verde">Save</button>
            <a href="/users" class="boton-rojo">Cancel</a>
        </div>
    </form>
<?= $this->endSection() ?>
