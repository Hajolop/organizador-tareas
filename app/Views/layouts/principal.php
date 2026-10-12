<!DOCTYPE html>
<html lang="<?= service('language')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= lang('App.appName') ?></title>
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body>
    <nav>
        <div>
            <a href="/"><?= lang('App.home') ?></a>
            <a href="/idioma/en">English</a>
            <a href="/idioma/es">Español</a>
        </div>
        <div>
            <?php if (session()->get('logueado')): ?>
                <span><?= lang('App.hello') ?>, <?= esc(session()->get('user_name')) ?></span>
                <a href="/profile"><?= lang('App.profile') ?></a>
                <?php if ((int) session()->get('administrator') === 1): ?>
                    <a href="/users"><?= lang('App.users') ?></a>
                <?php endif; ?>
                <a href="/tasks"><?= lang('App.tasks') ?></a>
                <a href="/logout"><?= lang('App.logout') ?></a>
            <?php else: ?>
                <a href="/registro"><?= lang('App.signup') ?></a>
                <a href="/login"><?= lang('App.login') ?></a>
            <?php endif; ?>
        </div>
    </nav>

    <main>
        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alerta alerta-ok"><?= esc(session()->getFlashdata('mensaje')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errores')): ?>
            <div class="alerta alerta-error">
                <ul>
                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('contenido') ?>
    </main>
</body>
</html>
