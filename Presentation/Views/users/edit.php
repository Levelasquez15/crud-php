<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Editar Usuario #<?= substr(htmlspecialchars($user->getId()), 0, 8) ?></h4>
            </div>
            <div class="card-body">
                <form action="?route=users.update" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? $user->getName()) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? $user->getEmail()) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Contraseña <span class="text-muted">(Dejar en blanco para mantener actual)</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
                            <select name="role" class="form-select" required>
                                <?php foreach ($roleOptions as $role): ?>
                                    <option value="<?= htmlspecialchars($role) ?>" <?= ($old['role'] ?? $user->getRole()) === $role ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select" required>
                                <?php foreach ($statusOptions as $status): ?>
                                    <option value="<?= htmlspecialchars($status) ?>" <?= ($old['status'] ?? $user->getStatus()) === $status ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($status) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="?route=users.index" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning">Actualizar Usuario</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
