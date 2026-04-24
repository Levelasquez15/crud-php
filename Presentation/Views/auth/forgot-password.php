<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Recuperar Contraseña</h4>
            </div>
            <div class="card-body">
                <p class="text-muted small">Ingresa el correo asociado a tu cuenta. Si existe en nuestro sistema, te enviaremos instrucciones.</p>
                <form action="?route=auth.forgot.send" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-warning">Enviar Enlace</button>
                    </div>
                 </form>
            </div>
            <div class="card-footer text-center">
                <a href="?route=auth.login" class="text-decoration-none">Volver al Login</a>
            </div>
        </div>
    </div>
</div>
