<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu Email</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { text-align: center; color: #333; margin-bottom: 30px; }
        .button { display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 20px 0; }
        .footer { text-align: center; color: #999; font-size: 12px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenido/a a CRUD Hexagonal</h1>
            <p>Hemos recibido tu solicitud de registro. Por favor verifica tu correo electrónico.</p>
        </div>
        
        <p>Hola <strong><?= htmlspecialchars($userName) ?></strong>,</p>
        
        <p>Para activar tu cuenta, haz clic en el siguiente enlace:</p>
        
        <center>
            <a href="<?= htmlspecialchars($verificationUrl) ?>" class="button">
                ✓ Verificar mi Correo Electrónico
            </a>
        </center>
        
        <p style="color: #666; font-size: 14px;">
            Si no funciona el botón anterior, copia y pega esta URL en tu navegador:<br>
            <code><?= htmlspecialchars($verificationUrl) ?></code>
        </p>
        
        <p style="color: #999; font-size: 12px;">
            Este enlace expirará en 24 horas. Si no solicitaste este correo, ignóralo.
        </p>
        
        <div class="footer">
            <p>&copy; 2026 CRUD Hexagonal. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
