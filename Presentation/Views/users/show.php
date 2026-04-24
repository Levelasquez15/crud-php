<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detalle de usuario</h5>
                <span class="badge bg-<?= $user->getStatus() === 'active' ? 'success' : 'secondary' ?>">
                    <?= $user->getStatus() === 'active' ? 'Activo' : 'Inactivo' ?>
                </span>
            </div>
            <div class="card-body p-4">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted small text-uppercase">ID</dt>
                    <dd class="col-sm-8"><code class="text-dark small"><?= htmlspecialchars($user->getId()) ?></code></dd>

                    <dt class="col-sm-4 text-muted small text-uppercase mt-3">Nombre</dt>
                    <dd class="col-sm-8 mt-3 fw-bold"><?= htmlspecialchars($user->getName()) ?></dd>

                    <dt class="col-sm-4 text-muted small text-uppercase mt-3">Email</dt>
                    <dd class="col-sm-8 mt-3"><a href="mailto:<?= htmlspecialchars($user->getEmail()) ?>"><?= htmlspecialchars($user->getEmail()) ?></a></dd>

                    <dt class="col-sm-4 text-muted small text-uppercase mt-3">Rol</dt>
                    <dd class="col-sm-8 mt-3">
                        <span class="badge bg-<?= $user->getRole() === 'ADMIN' ? 'danger' : 'primary' ?>">
                            <?= htmlspecialchars($user->getRole()) ?>
                        </span>
                    </dd>
                </dl>
            </div>
            <div class="card-footer bg-light d-flex justify-content-between py-3">
                <a href="?route=users.index" class="btn btn-outline-secondary btn-sm">Volver</a>
                <a href="?route=users.edit&id=<?= urlencode($user->getId()) ?>" class="btn btn-dark btn-sm">Editar</a>
            </div>
        </div>
    </div>
</div>