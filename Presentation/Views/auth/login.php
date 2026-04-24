<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Iniciar Sesión</h4>
            </div>
            <div class="card-body">
                <form action="?route=auth.authenticate" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                 </form>
            </div>
            <div class="card-footer text-center">
                <a href="?route=auth.forgot" class="text-decoration-none">¿Olvidaste tu contraseña?</a><br>
                <a href="?route=users.create" class="text-decoration-none">Soy Nuevo, Quiero Crear una Cuenta</a>
            </div>
        </div>
    </div>
</div>
