<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Recuperada</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { text-align: center; color: #333; margin-bottom: 30px; }
        .button { display: inline-block; padding: 12px 30px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; margin: 20px 0; }
        .footer { text-align: center; color: #999; font-size: 12px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Recuperación de Contraseña</h1>
        </div>
        
        <p>Hola,</p>
        
        <p>Hemos recibido una solicitud para recuperar tu contraseña. Si no fuiste tú, ignora este correo.</p>
        
        <p>Para recuperar tu contraseña, haz clic en el siguiente enlace (válido por 24 horas):</p>
        
        <center>
            <a href="<?= htmlspecialchars($resetUrl) ?>" class="button">
                🔐 Recuperar Contraseña
            </a>
        </center>
        
        <p style="color: #666; font-size: 14px;">
            Si no funciona el botón, copia y pega esta URL:<br>
            <code><?= htmlspecialchars($resetUrl) ?></code>
        </p>
        
        <div class="footer">
            <p>&copy; 2026 CRUD Hexagonal. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
