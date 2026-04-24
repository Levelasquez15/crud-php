-- Agregar columnas de verificación de email a la tabla existente
ALTER TABLE users 
ADD COLUMN email_verified_at DATETIME NULL,
ADD COLUMN email_verification_token VARCHAR(255) NULL UNIQUE;
