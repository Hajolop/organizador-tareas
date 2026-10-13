<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.usersTitle') ?></h1>

    <p><a href="/users/new" class="boton-verde"><?= lang('App.newUser') ?></a></p>

    <div class="tabla-contenedor">
        <table class="tabla">
            <thead>
                <tr>
                    <th><?= lang('App.name') ?></th>
                    <th><?= lang('App.email') ?></th>
                    <th><?= lang('App.active') ?></th>
                    <th><?= lang('App.administrator') ?></th>
                    <th><?= lang('App.createdAt') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><a href="/users/<?= $u['id'] ?>"><?= esc($u['name']) ?></a></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= $u['active'] ? lang('App.yes') : lang('App.no') ?></td>
                        <td><?= $u['administrator'] ? lang('App.yes') : lang('App.no') ?></td>
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
            <a href="/users?page=<?= $actual - 1 ?>" class="boton-verde"><?= lang('App.newer') ?></a>
        <?php else: ?>
            <span class="boton-verde boton-apagado"><?= lang('App.newer') ?></span>
        <?php endif; ?>

        <?php if ($actual < $total): ?>
            <a href="/users?page=<?= $actual + 1 ?>" class="boton-verde"><?= lang('App.older') ?></a>
        <?php else: ?>
            <span class="boton-verde boton-apagado"><?= lang('App.older') ?></span>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>
