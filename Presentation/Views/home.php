<div class="card shadow-sm">
    <div class="card-body text-center py-5 px-4">
        <h1 class="display-5 fw-bold">CRUD con Arquitectura Hexagonal</h1>
        <p class="lead text-muted mt-3 mb-4">
            Aplicacion desarrollada en PHP puro sin frameworks, aplicando Arquitectura Hexagonal (Puertos y Adaptadores), separacion de capas y buenas practicas de diseno de software.
        </p>
        <?php if (!isset($_SESSION['auth']['id'])): ?>
            <a href="?route=auth.login" class="btn btn-primary px-4">Iniciar Sesion</a>
            <a href="?route=users.create" class="btn btn-outline-secondary px-4 ms-2">Registrarme</a>
        <?php else: ?>
            <a href="?route=users.index" class="btn btn-primary px-4">Gestionar Usuarios</a>
        <?php endif; ?>
    </div>
</div>