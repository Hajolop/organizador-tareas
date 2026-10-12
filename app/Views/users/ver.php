<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1>User</h1>
    <p><a href="/users" class="enlace">&lt;&lt; back to index</a></p>

    <dl class="detalle">
        <dt>Name</dt>
        <dd><?= esc($usuario['name']) ?></dd>
        <dt>Email</dt>
        <dd><?= esc($usuario['email']) ?></dd>
        <dt>Active</dt>
        <dd><?= $usuario['active'] ? 'Yes' : 'No' ?></dd>
        <dt>Administrator</dt>
        <dd><?= $usuario['administrator'] ? 'Yes' : 'No' ?></dd>
        <dt>Created at</dt>
        <dd><?= esc($usuario['created_at']) ?></dd>
        <dt>Updated at</dt>
        <dd><?= esc($usuario['updated_at']) ?></dd>
    </dl>

    <div class="botones">
        <a href="/users/<?= $usuario['id'] ?>/edit" class="boton-verde">Edit</a>
        <form action="/users/<?= $usuario['id'] ?>/delete" method="post" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
            <?= csrf_field() ?>
            <button type="submit" class="boton-rojo">Delete</button>
        </form>
    </div>
<?= $this->endSection() ?>
