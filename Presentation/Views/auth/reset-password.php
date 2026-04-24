<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">🔐 Nueva Contraseña</h4>
            </div>
            <div class="card-body">

                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <p class="text-muted small">Ingresa tu nueva contraseña. Mínimo 8 caracteres.</p>

                <form action="?route=auth.reset.save" method="POST">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control"
                               minlength="8" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" id="confirm_password" class="form-control"
                               minlength="8" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success">Guardar Nueva Contraseña</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="?route=auth.login" class="text-decoration-none">Volver al Login</a>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const pass    = document.querySelector('input[name="password"]').value;
    const confirm = document.getElementById('confirm_password').value;
    if (pass !== confirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden.');
    }
});
</script>