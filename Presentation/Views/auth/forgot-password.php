<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow mt-5">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Recuperar Contrasena</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">Ingresa el correo de tu cuenta. Si existe, te enviaremos un enlace para restablecer tu contrasena.</p>
                <form action="?route=auth.forgot.send" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo Electronico</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-dark">Enviar Enlace</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center bg-light py-3">
                <a href="?route=auth.login" class="text-decoration-none text-muted small">Volver al login</a>
            </div>
        </div>
    </div>
</div>