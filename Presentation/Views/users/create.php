<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Crear usuario</h5>
            </div>
            <div class="card-body p-4">
                <form action="?route=users.store" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nombre completo</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correo electronico</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contrasena</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                            <div class="form-text">Minimo 8 caracteres.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rol</label>
                            <select name="role" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($roleOptions as $role): ?>
                                    <option value="<?= htmlspecialchars($role) ?>" <?= ($old['role'] ?? '') === $role ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($role) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-dark">Guardar usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>