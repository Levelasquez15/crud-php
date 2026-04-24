<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow mt-5">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Nueva Contrasena</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">Ingresa tu nueva contrasena. Minimo 8 caracteres.</p>
                <form action="?route=auth.reset.save" method="POST">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nueva Contrasena</label>
                        <input type="password" name="password" class="form-control" minlength="8" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirmar Contrasena</label>
                        <input type="password" id="confirm_password" class="form-control" minlength="8" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark">Guardar Contrasena</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center bg-light py-3">
                <a href="?route=auth.login" class="text-decoration-none text-muted small">Volver al login</a>
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
        alert('Las contrasenas no coinciden.');
    }
});
</script>