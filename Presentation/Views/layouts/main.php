<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'App PHP') ?></title>
    <!-- Bootstrap CSS for quick styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="?route=home">Hexagonal PHP CRUD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?route=home">Inicio</a>
                </li>
                <?php if (isset($_SESSION['auth']['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?route=users.index">Usuarios</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['auth']['id'])): ?>
                    <li class="nav-item">
                        <span class="nav-text text-white me-3 mt-2 d-inline-block">Hola, <?= htmlspecialchars($_SESSION['auth']['name']) ?> (<?= htmlspecialchars($_SESSION['auth']['role']) ?>)</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="?route=auth.logout">Cerrar Sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?route=auth.login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php require_once $viewFile; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
