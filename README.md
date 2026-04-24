# PHP CRUD - Arquitectura Hexagonal, DDD y CQRS

Este proyecto es una aplicación **CRUD** completa desarrollada en **PHP Puro** (sin frameworks como Laravel o Symfony), siguiendo estrictamente los principios de **Arquitectura Hexagonal (Puertos y Adaptadores)**, **Domain-Driven Design (DDD)** y **CQRS (Separación de Comandos y Consultas)**.

El objetivo del repositorio es mostrar cómo organizar una base de código robusta, mantenible y escalable aislando completamente la lógica de negocio (Dominio) de factores externos como la base de datos (MySQL), correo electrónico (SMTP) o el entorno web (HTML/HTTP).

## 🚀 Arquitectura del Proyecto

El código está estructurado de adentro hacia afuera (regla de dependencia):

1.  **Domain (Capa de Dominio):** El corazón de la aplicación. No depende de nada. Contiene nuestro Agregado (`UserModel`), Objetos de Valor inmutables y auto-validados (`UserPassword`), Enumeraciones (`UserRoleEnum`, `UserStatusEnum`) y Excepciones de negocio personalizadas.

2.  **Application (Capa de Aplicación):** Orquesta los flujos de negocio. Implementa **CQRS** (Comandos para mutaciones, Consultas para lectura). Define los **Puertos de Entrada** (Interfaces UseCase) y **Puertos de Salida** (Repository Interfaces).

3.  **Infrastructure (Capa de Infraestructura):** Implementa las conexiones con el "mundo exterior".
    *   **Adapters (Persistencia):** Repositorios concretos (`UserRepositoryMySQL`) usando PDO, Entidades de Persistencia y Mappers que blindan al Dominio de la estructura de las tablas.
    *   **Adapters (Mail):** Mailer SMTP para envío de correos de verificación y recuperación.
    *   **Entrypoints (Web):** Controladores (`UserController`, `AuthController`), Peticiones y Respuestas DTO, Rutas e inyección Web, quienes convierten las peticiones HTTP en Comandos/Consultas para el Dominio.

4.  **Presentation (Vistas):** Motor de plantillas simple en PHP (`View.php`) con **Bootstrap 5** para el maquetado (Layouts, Login, Tablas, Emails, Errores).

5.  **Common (Transversal):** Clases globales como `ClassLoader` (Autocarga tipo Composer), `DependencyInjection` (Contenedor DI / Factory global), `Flash` (mensajes de sesión), `Migration` (creación de tablas).

---

## ⚙️ Requisitos Previos

*   PHP 8.0 o superior.
*   Servidor MySQL (XAMPP, MAMP, Docker, etc.).
*   Ningún framework externo, todo está programado en vanilla PHP.
*   Una cuenta de Gmail (para envío de correos SMTP).

---

## 🛠️ Configuración de la Base de Datos

El sistema está configurado por defecto para buscar en `localhost` una base de datos llamada `crud_usuarios` utilizando el usuario `root` y una contraseña en blanco (típico de XAMPP).

### 1. Crear Base de Datos y Tabla

Abre tu gestor SQL (phpMyAdmin, DBeaver, MySQL CLI) y ejecuta:

```sql
CREATE DATABASE IF NOT EXISTS crud_usuarios CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_usuarios;

CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(36) PRIMARY KEY,       -- UUID generado por la aplicación
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,   -- Almacena hashes Bcrypt
    role VARCHAR(20) NOT NULL,        -- 'ADMIN' o 'USER'
    status VARCHAR(20) NOT NULL,      -- 'active' o 'inactive'
    email_verified_at DATETIME NULL,  -- Timestamp cuando se verifica el email
    email_verification_token VARCHAR(255) NULL UNIQUE, -- Token para verificación
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 2. Configurar Credenciales de Conexión

Si tu base de datos tiene usuario/contraseña distintos, modifica [Common/DependencyInjection.php](Common/DependencyInjection.php):

```php
// Common/DependencyInjection.php (Línea 12 aprox.)
public static function getConnection(): Connection {
    // Cambia 'localhost', 'crud_usuarios', 'root', '' por los de tu servidor
    return new Connection('localhost', 'crud_usuarios', 'root', '');
}
```

---

## 📧 Configuración de Correo Electrónico (SMTP Gmail)

La aplicación puede enviar correos de verificación de cuenta y recuperación de contraseña usando **Gmail SMTP**.

### 1. Obtener Token de Gmail

1.  Ve a [myaccount.google.com](https://myaccount.google.com)
2.  Selecciona **Seguridad** en el menú izquierdo
3.  Activa **Verificación en 2 pasos** (si no está activa)
4.  Selecciona **Contraseñas de aplicación** (aparece después de activar 2FA)
5.  Selecciona **Correo** y **Windows** (o tu SO)
6.  Google generará una contraseña de 16 caracteres
7.  Copia esa contraseña

### 2. Agregar Token a la Aplicación

Abre [Common/DependencyInjection.php](Common/DependencyInjection.php) y reemplaza el método `getMailer()`:

```php
public static function getMailer(): SmtpMailer {
    $config = new MailerConfig(
        'tu_email@gmail.com',           // Tu email de Gmail
        'abcd efgh ijkl mnop'           // La contraseña generada (sin espacios)
    );
    return new SmtpMailer($config);
}
```

---

## ▶️ Cómo ejecutar la aplicación

1.  Abre una terminal o consola de comandos.
2.  Navega hasta la **carpeta raíz** de este repositorio:
    ```bash
    cd C:\Users\pc\Documents\GitHub\Crud-php.hexagonal
    ```
3.  Inicia el servidor interno de PHP apuntando a la carpeta `public`:
    ```bash
    php -S localhost:8000 -t public
    ```
4.  Abre tu navegador y visita:
    👉 **http://localhost:8000/**

---

## 📁 Estructura de Carpetas

```
Crud-php.hexagonal/
├── Domain/                          # Capa de Dominio (sin dependencias externas)
│   ├── Exceptions/                  # Excepciones de negocio personalizadas
│   ├── Enums/                       # Enumeraciones (UserRole, UserStatus)
│   ├── ValueObjects/                # Objetos de Valor (UserId, UserPassword, UserEmail)
│   ├── Models/                      # Agregados (UserModel)
│   └── Events/                      # [Opcional] Eventos de dominio (DDD avanzado)
│
├── Application/                     # Capa de Aplicación (Orquestación)
│   ├── Ports/
│   │   ├── In/                      # Puertos de Entrada (UseCase Interfaces)
│   │   └── Out/                     # Puertos de Salida (Repository Interfaces)
│   └── Services/
│       ├── Dto/                     # Data Transfer Objects (Commands, Queries)
│       ├── Mappers/                 # Mappers (Conversión de DTOs a Modelos)
│       └── *.php                    # Servicios (Implementación de UseCases)
│
├── Infrastructure/                  # Capa de Infraestructura (Implementaciones concretas)
│   ├── Adapters/
│   │   ├── Persistence/
│   │   │   ├── MySQL/
│   │   │   │   ├── Config/          # Conexión, Migrations
│   │   │   │   ├── Repository/      # Implementación de Puertos Out
│   │   │   │   ├── Entity/          # Modelos de Persistencia
│   │   │   │   ├── Dto/             # DTOs de Persistencia
│   │   │   │   └── Mapper/          # Mapper (Model <-> Entity)
│   │   └── Mail/                    # Configuración de SMTP (MailerConfig, SmtpMailer)
│   └── Entrypoints/
│       └── Web/
│           ├── Controllers/         # Controladores HTTP
│           │   ├── Dto/             # DTOs de Request/Response
│           │   ├── Mapper/          # Mapper (HTTP <-> Commands/Queries)
│           │   └── Config/          # WebRoutes (Definición de rutas)
│           └── Presentation/        # Vistas (Flash, View)
│               └── Views/           # Plantillas HTML/Email
│
├── Presentation/                    # Capa de Presentación (Vistas y Templates)
│   └── Views/
│       ├── layouts/                 # Layout maestro (main.php)
│       ├── auth/                    # Plantillas de autenticación (login, forgot-password)
│       ├── users/                   # Plantillas de usuarios (list, create, edit, show)
│       ├── emails/                  # Plantillas de email (verify-email, forgot-password)
│       ├── errors/                  # Páginas de error (404, 500, 403)
│       └── home.php                 # Página de inicio
│
├── Common/                          # Código compartido (transversal)
│   ├── ClassLoader.php              # Autocargador personalizado
│   ├── DependencyInjection.php       # Contenedor DI / Factory Pattern
│   └── Flash.php                    # Gestor de mensajes de sesión
│
├── public/                          # Punto de entrada web (DocumentRoot)
│   ├── index.php                    # Router frontal único (Front Controller)
│   └── .htaccess                    # Configuración Apache
│
└── README.md                        # Este archivo
```

---

## 🛡️ Características de Seguridad

*   **Autenticación Protegida:** No puedes acceder sin estar autenticado. El proceso de registro requiere verificación de email.
*   **Verificación de Email:** Se envía un enlace de verificación al registro. El token expira en 24 horas.
*   **Passwords Seguros:** Hasheo con Bcrypt en el Objeto de Valor `UserPassword` del Dominio. La base de datos jamás almacena contraseñas planas.
*   **Ataque de Enumeración:** El proceso de "Login" y "Recuperar Contraseña" devuelve mensajes genéricos para no revelar qué emails existen en el sistema.
*   **Inyección de Dependencias:** Todo está desacoplado mediante Interfaces. El Factory resolverve las dependencias limpianamente.
*   **Inyección SQL:** Se usan **Prepared Statements** con PDO en todas las queries.
*   **XSS Protection:** Se usa `htmlspecialchars()` en todas las salidas HTML.

---

## 📚 Carpetas Especiales Explicadas

### `Domain/Events/`
Está vacía por defecto. Se utiliza para **Eventos de Dominio** en DDD avanzado. Los eventos capturan cosas que sucedieron en el negocio (Ej: `UserCreatedEvent`, `UserVerifiedEvent`). Son opcionales en esta implementación.

### `Presentation/Views/emails/`
Contiene plantillas HTML de correos electrónicos:
- `verify-email.php` - Correo con enlace de verificación de cuenta
- `forgot-password.php` - Correo para recuperar contraseña

Las plantillas se renderizan dinámicamente en `CreateUserService` antes de ser enviadas por SMTP.

### `Presentation/Views/errors/`
Contiene páginas de error personalizadas:
- `404.php` - Página no encontrada
- `500.php` - Error interno del servidor
- `403.php` - Acceso denegado

---

## 🔄 Flujo de una Petición HTTP (Ejemplo: Crear Usuario)

```
1. Usuario llena formulario y presiona "Crear" (POST)
   ↓
2. public/index.php detecta route="users.store"
   ↓
3. Carga Controller: UserController->store(CreateUserWebRequest)
   ↓
4. Controller mapea: CreateUserWebRequest → CreateUserCommand
   ↓
5. Controller invoca UseCase: CreateUserUseCase->execute(CreateUserCommand)
   ↓
6. CreateUserService (implementa el UseCase):
   - Valida email (no existe ya)
   - Mapea Command → UserModel (Dominio)
   - Genera token de verificación
   - Guarda usuario en BD via RepositoryInterface
   - Envía email con token
   ↓
7. Repository implementa SaveUserPort:
   - Mapea UserModel → UserEntity (BD)
   - Inserta en tabla MySQL
   ↓
8. Resultado retorna al Controller como UserResponse
   ↓
9. Controller guarda éxito en Flash y redirige a users.index
```

---

## ✨ Patrón Arquitectónico: Puertos y Adaptadores

La **Arquitectura Hexagonal** define dos tipos de puertos:

### **Puertos de Entrada (In)**
Son las interfaces que definen cómo el exterior puede llamar a la lógica del negocio.
```php
// Ejemplo: CreateUserUseCase
interface CreateUserUseCase {
    public function execute(CreateUserCommand $cmd): UserModel;
}
```

### **Puertos de Salida (Out)**
Son las interfaces que definen cómo el negocio puede persistir datos.
```php
// Ejemplo: SaveUserPort
interface SaveUserPort {
    public function save(UserModel $user): UserModel;
}
```

Los **Adapters** (Implementaciones concretas) conectan estos puertos con tecnologías específicas:
```php
// Adapter: CreateUserService implementa CreateUserUseCase (Puerto In)
class CreateUserService implements CreateUserUseCase { ... }

// Adapter: UserRepositoryMySQL implementa SaveUserPort (Puerto Out)
class UserRepositoryMySQL implements SaveUserPort { ... }
```

---

## 🧪 Testeabilidad

Gracias a la **Arquitectura Hexagonal**, es muy fácil crear **Tests Unitarios** reemplazando los adaptadores reales con "mocks":

```php
// En tests, reemplazas el repositorio real con un mock
class FakeUserRepository implements SaveUserPort {
    public function save(UserModel $user): UserModel {
        // Implementación fake para testing
    }
}

// Y testas el UseCase sin base de datos
$service = new CreateUserService(new FakeUserRepository());
$result = $service->execute($command);
```
