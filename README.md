# CRUD con Arquitectura Hexagonal en PHP

Aplicacion CRUD desarrollada en **PHP puro** (sin frameworks como Laravel o Symfony), siguiendo los principios de **Arquitectura Hexagonal (Puertos y Adaptadores)** para mantener la logica de negocio completamente aislada de la infraestructura.

---

## Requisitos

- PHP 8.0 o superior
- MySQL (XAMPP, MAMP, Docker, etc.)
- Cuenta Gmail con contrasena de aplicacion (para envio de correos)

---

## Instalacion rapida

### 1. Crear la base de datos

Ejecuta esto en MySQL (phpMyAdmin, DBeaver o CLI):

```sql
CREATE DATABASE IF NOT EXISTS crud_usuarios CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_usuarios;

CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(36) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL,
    status VARCHAR(20) NOT NULL,
    email_verified_at DATETIME NULL,
    email_verification_token VARCHAR(255) NULL UNIQUE,
    password_reset_token VARCHAR(255) NULL,
    password_reset_expires_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 2. Configurar correo (Gmail SMTP)

Abre `Common/DependencyInjection.php` y edita el metodo `getMailer()`:

```php
public static function getMailer(): SmtpMailer {
    $config = new MailerConfig(
        'tu_email@gmail.com',
        'tu_contrasena_de_aplicacion'  // 16 caracteres generados por Google
    );
    return new SmtpMailer($config);
}
```

Para generar la contrasena de aplicacion en Gmail: Cuenta de Google > Seguridad > Verificacion en 2 pasos > Contrasenas de aplicacion.

### 3. Levantar el servidor

```bash
php -S localhost:8000 -t public
```

Abrir en el navegador: **http://localhost:8000**

---

## Estructura del proyecto
├── Domain/              # Logica de negocio pura (modelos, value objects, excepciones)
├── Application/         # Casos de uso, puertos de entrada y salida, DTOs
├── Infrastructure/      # Implementaciones concretas (MySQL, SMTP, controladores HTTP)
├── Presentation/        # Vistas HTML y plantillas de email
├── Common/              # ClassLoader, DependencyInjection, Flash
└── public/              # Punto de entrada (index.php)

---

## Capas de la arquitectura

**Domain** — No depende de nada externo. Contiene los modelos, value objects con validacion propia y excepciones de negocio.

**Application** — Define los casos de uso como interfaces (puertos de entrada) y los contratos con la infraestructura (puertos de salida). Implementa la logica de cada operacion.

**Infrastructure** — Conecta la aplicacion con el mundo real: repositorios MySQL con PDO, mailer SMTP, controladores HTTP que convierten requests en comandos.

**Presentation** — Vistas PHP con Bootstrap 5. Motor de plantillas simple sin dependencias externas.

---

## Funcionalidades

- Registro de usuarios con verificacion de email
- Login y cierre de sesion
- Recuperacion de contrasena por correo
- CRUD completo de usuarios (listar, ver, crear, editar, eliminar)
- Roles: ADMIN y MEMBER
- Proteccion de rutas por sesion
- Passwords con hash Bcrypt
- Prepared Statements en todas las consultas SQL
- Proteccion contra enumeracion de emails en login y recuperacion