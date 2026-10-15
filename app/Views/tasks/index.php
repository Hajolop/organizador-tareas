<?= $this->extend('layouts/principal') ?>

<?= $this->section('contenido') ?>
    <h1><?= lang('App.tasksTitle') ?></h1>

    <p><a href="/tasks/new" class="boton-verde"><?= lang('App.newTask') ?></a></p>

    <form action="/tasks" method="get" class="busqueda">
        <label for="q"><?= lang('App.search') ?></label>
        <input type="text" id="q" name="q" value="<?= esc($busqueda, 'attr') ?>" autocomplete="off">
        <button type="submit" class="boton-verde"><?= lang('App.search') ?></button>
    </form>

    <div id="resultado">
        <?php if (empty($tareas)): ?>
            <p><?= lang('App.noTasks') ?></p>
        <?php else: ?>
            <ul class="lista-tareas">
                <?php foreach ($tareas as $tarea): ?>
                    <li><a href="/tasks/<?= $tarea['id'] ?>"><?= esc($tarea['description']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php
            $actual = $pager->getCurrentPage();
            $total  = $pager->getPageCount();
            $extra  = $busqueda !== '' ? '&amp;q=' . urlencode($busqueda) : '';
        ?>
        <div class="botones">
            <?php if ($actual > 1): ?>
                <a href="/tasks?page=<?= $actual - 1 ?><?= $extra ?>" class="boton-verde"><?= lang('App.newer') ?></a>
            <?php else: ?>
                <span class="boton-verde boton-apagado"><?= lang('App.newer') ?></span>
            <?php endif; ?>

            <?php if ($actual < $total): ?>
                <a href="/tasks?page=<?= $actual + 1 ?><?= $extra ?>" class="boton-verde"><?= lang('App.older') ?></a>
            <?php else: ?>
                <span class="boton-verde boton-apagado"><?= lang('App.older') ?></span>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const campo = document.getElementById('q');
        let espera;

        campo.addEventListener('input', () => {
            clearTimeout(espera);

            espera = setTimeout(async () => {
                const respuesta = await fetch('/tasks?q=' + encodeURIComponent(campo.value));
                const pagina = new DOMParser().parseFromString(await respuesta.text(), 'text/html');
                const nuevo = pagina.getElementById('resultado');

                if (nuevo) {
                    document.getElementById('resultado').innerHTML = nuevo.innerHTML;
                } else {
                    location.reload();
                }
            }, 300);
        });
    </script>
<?= $this->endSection() ?>
