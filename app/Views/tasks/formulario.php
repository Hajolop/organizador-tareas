<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <?php $editando = $tarea !== null; ?>
    <h1><?= $editando ? lang('App.editTaskTitle') : lang('App.newTask') ?></h1>

    <form action="<?= $editando ? '/tasks/' . $tarea['id'] . '/edit' : '/tasks/new' ?>" method="post" class="formulario">
        <?= csrf_field() ?>

        <label for="description"><?= lang('App.description') ?></label>
        <input type="text" id="description" name="description" maxlength="255" value="<?= old('description', esc($editando ? $tarea['description'] : '', 'attr')) ?>" required>

        <div class="botones">
            <button type="submit" class="boton-verde"><?= $editando ? lang('App.save') : lang('App.send') ?></button>
            <a href="/tasks" class="boton-rojo"><?= lang('App.cancel') ?></a>
        </div>
    </form>
<?= $this->endSection() ?>
