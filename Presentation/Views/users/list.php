<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Usuarios registrados</h5>
    <a href="?route=users.create" class="btn btn-dark btn-sm">Crear usuario</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No hay usuarios registrados.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><code class="text-muted small" title="<?= htmlspecialchars($user->getId()) ?>"><?= substr(htmlspecialchars($user->getId()), 0, 8) ?>...</code></td>
                                <td class="fw-semibold"><?= htmlspecialchars($user->getName()) ?></td>
                                <td class="text-muted"><?= htmlspecialchars($user->getEmail()) ?></td>
                                <td>
                                    <span class="badge bg-<?= $user->getRole() === 'ADMIN' ? 'danger' : 'primary' ?>">
                                        <?= htmlspecialchars($user->getRole()) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $user->getStatus() === 'active' ? 'success' : 'secondary' ?>">
                                        <?= $user->getStatus() === 'active' ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?route=users.show&id=<?= urlencode($user->getId()) ?>" class="btn btn-sm btn-outline-dark">Ver</a>
                                    <a href="?route=users.edit&id=<?= urlencode($user->getId()) ?>" class="btn btn-sm btn-outline-warning">Editar</a>
                                    <form action="?route=users.delete" method="POST" class="d-inline" onsubmit="return confirm('Seguro que deseas eliminar este usuario?');">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>