<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.taskTitle') ?></h1>
    <p><a href="/tasks" class="enlace"><?= lang('App.backToIndex') ?></a></p>

    <dl class="detalle">
        <dt>ID</dt>
        <dd><?= $tarea['id'] ?></dd>
        <dt><?= lang('App.description') ?></dt>
        <dd><?= esc($tarea['description']) ?></dd>
        <dt><?= lang('App.createdAt') ?></dt>
        <dd><?= esc($tarea['created_at']) ?></dd>
        <dt><?= lang('App.updatedAt') ?></dt>
        <dd><?= esc($tarea['updated_at']) ?></dd>
    </dl>

    <div class="botones">
        <a href="/tasks/<?= $tarea['id'] ?>/edit" class="boton-verde"><?= lang('App.edit') ?></a>
        <form action="/tasks/<?= $tarea['id'] ?>/delete" method="post" onsubmit="return confirm('<?= esc(lang('App.confirmDeleteTask'), 'js') ?>');">
            <?= csrf_field() ?>
            <button type="submit" class="boton-rojo"><?= lang('App.delete') ?></button>
        </form>
    </div>
<?= $this->endSection() ?>
