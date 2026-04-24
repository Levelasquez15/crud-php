<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Crear Nuevo Usuario</h4>
            </div>
            <div class="card-body">
                <form action="?route=users.store" method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                            <div class="form-text">Min 8 caracteres. Incluir mayúsculas, minúsculas, números y símbolos.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol</label>
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
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Usuario</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
