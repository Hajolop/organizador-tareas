<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1>Users</h1>

    <p><a href="/users/new" class="boton-verde">New user</a></p>

    <div class="tabla-contenedor">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Active</th>
                    <th>Administrator</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><a href="/users/<?= $u['id'] ?>"><?= esc($u['name']) ?></a></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= $u['active'] ? 'Sí' : 'No' ?></td>
                        <td><?= $u['administrator'] ? 'Sí' : 'No' ?></td>
                        <td><?= esc($u['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
        $actual = $pager->getCurrentPage();
        $total  = $pager->getPageCount();
    ?>
    <div class="botones">
        <?php if ($actual > 1): ?>
            <a href="/users?page=<?= $actual - 1 ?>" class="boton-verde">Newer</a>
        <?php else: ?>
            <span class="boton-verde boton-apagado">Newer</span>
        <?php endif; ?>

        <?php if ($actual < $total): ?>
            <a href="/users?page=<?= $actual + 1 ?>" class="boton-verde">Older</a>
        <?php else: ?>
            <span class="boton-verde boton-apagado">Older</span>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
