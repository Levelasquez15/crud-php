<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'CRUD Hexagonal') ?> | CRUD Hexagonal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .navbar-brand { font-weight: 700; letter-spacing: 0.5px; }
        .navbar { box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
        .card { border: none; border-radius: 12px; }
        .card-header { border-radius: 12px 12px 0 0 !important; font-weight: 600; }
        .btn { border-radius: 8px; }
        .alert { border-radius: 10px; border: none; }
        .table thead th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6c757d; }
        .badge { font-size: 0.75rem; padding: 5px 10px; border-radius: 6px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="?route=home">CRUD Hexagonal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                        <span class="nav-text text-white-50 me-3 mt-2 d-inline-block small">
                            <?= htmlspecialchars($_SESSION['auth']['name']) ?>
                            <span class="badge bg-secondary ms-1"><?= htmlspecialchars($_SESSION['auth']['role']) ?></span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="?route=auth.logout">Cerrar Sesion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?route=auth.login">Iniciar Sesion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php require_once $viewFile; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>