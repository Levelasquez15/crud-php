<div class="card shadow-sm">
    <div class="card-body text-center py-5">
        <h1 class="display-4">Bienvenido a la Arquitectura Hexagonal y DDD</h1>
        <p class="lead text-muted mt-3">Esta aplicación demuestra el uso de Clean Architecture y PHP Puro de manera integral.</p>
        <?php if (!isset($_SESSION['auth']['id'])): ?>
            <a href="?route=auth.login" class="btn btn-primary mt-4">Iniciar Sesión</a>
        <?php else: ?>
            <a href="?route=users.index" class="btn btn-primary mt-4">Gestionar Usuarios</a>
        <?php endif; ?>
    </div>
</div>
