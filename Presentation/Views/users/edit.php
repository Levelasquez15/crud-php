<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Editar usuario</h5>
            </div>
            <div class="card-body p-4">
                <form action="?route=users.update" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre completo</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? $user->getName()) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo electronico</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? $user->getEmail()) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Contrasena <span class="text-muted fw-normal">(dejar en blanco para mantener la actual)</span></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rol</label>
                            <select name="role" class="form-select" required>
                                <?php foreach ($roleOptions as $role): ?>
                                    <option value="<?= htmlspecialchars($role) ?>" <?= ($old['role'] ?? $user->getRole()) === $role ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estado</label>
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
                        <a href="?route=users.index" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-dark">Actualizar usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>