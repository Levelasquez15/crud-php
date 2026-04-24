<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detalle de Usuario</h4>
                <span class="badge bg-<?= $user->getStatus() === 'active' ? 'success' : 'secondary' ?>">
                    <?= htmlspecialchars($user->getStatus()) ?>
                </span>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">ID</dt>
                    <dd class="col-sm-8"><code class="text-dark"><?= htmlspecialchars($user->getId()) ?></code></dd>

                    <dt class="col-sm-4 mt-3">Nombre</dt>
                    <dd class="col-sm-8 mt-3 text-uppercase fw-bold"><?= htmlspecialchars($user->getName()) ?></dd>

                    <dt class="col-sm-4 mt-3">Email</dt>
                    <dd class="col-sm-8 mt-3"><a href="mailto:<?= htmlspecialchars($user->getEmail()) ?>"><?= htmlspecialchars($user->getEmail()) ?></a></dd>

                    <dt class="col-sm-4 mt-3">Rol</dt>
                    <dd class="col-sm-8 mt-3">
                        <span class="badge bg-<?= $user->getRole() === 'ADMIN' ? 'danger' : 'info' ?>">
                            <?= htmlspecialchars($user->getRole()) ?>
                        </span>
                    </dd>
                </dl>
            </div>
            <div class="card-footer bg-light d-flex justify-content-between">
                <a href="?route=users.index" class="btn btn-secondary">Volver</a>
                <div>
                    <a href="?route=users.edit&id=<?= urlencode($user->getId()) ?>" class="btn btn-warning">Editar</a>
                </div>
            </div>
        </div>
    </div>
</div>
