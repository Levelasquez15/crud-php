<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow mt-5">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Iniciar Sesion</h5>
            </div>
            <div class="card-body p-4">
                <form action="?route=auth.authenticate" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo Electronico</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contrasena</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark">Entrar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center bg-light py-3">
                <a href="?route=auth.forgot" class="text-decoration-none text-muted small">Olvide mi contrasena</a>
                <span class="text-muted small mx-2">|</span>
                <a href="?route=users.create" class="text-decoration-none text-muted small">Crear cuenta</a>
            </div>
        </div>
    </div>
</div>