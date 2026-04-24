<?php
// Common/DependencyInjection.php

class DependencyInjection {
    private static ?PDO $pdo = null;

    public static function boot(): void {
        ClassLoader::register();
    }

    public static function getConnection(): Connection {
        // En desarollo local -> localhost, crud_usuarios, root, string vacio
        return new Connection('localhost', 'crud_usuarios', 'root', '');
    }

    public static function getPdo(): PDO {
        if (self::$pdo === null) {
            self::$pdo = self::getConnection()->createPdo();
        }
        return self::$pdo;
    }

    public static function getUserRepository(): UserRepositoryMySQL {
        return new UserRepositoryMySQL(
            self::getPdo(),
            new UserPersistenceMapper()
        );
    }

    public static function getCreateUserUseCase(): CreateUserUseCase {
        $repo = self::getUserRepository();
        return new CreateUserService($repo, $repo, self::getMailer());
    }

    public static function getLoginUseCase(): LoginUseCase {
        return new LoginService(self::getUserRepository());
    }

    public static function getUpdateUserUseCase(): UpdateUserUseCase {
        $repo = self::getUserRepository();
        return new UpdateUserService($repo, $repo, $repo);
    }

    public static function getGetUserByIdUseCase(): GetUserByIdUseCase {
        return new GetUserByIdService(self::getUserRepository());
    }

    public static function getGetAllUsersUseCase(): GetAllUsersUseCase {
        return new GetAllUsersService(self::getUserRepository());
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase {
        $repo = self::getUserRepository();
        return new DeleteUserService($repo, $repo);
    }

    public static function getUserWebMapper(): UserWebMapper {
        return new UserWebMapper();
    }

    public static function getUserController(): UserController {
        return new UserController(
            self::getCreateUserUseCase(),
            self::getUpdateUserUseCase(),
            self::getGetUserByIdUseCase(),
            self::getGetAllUsersUseCase(),
            self::getDeleteUserUseCase(),
            self::getUserWebMapper()
        );
    }

    public static function getAuthController(): AuthController {
        return new AuthController(
            self::getLoginUseCase(),
            self::getVerifyEmailUseCase(),
            self::getMailer()
        );
    }
    
    public static function getHomeController(): HomeController {
        return new HomeController();
    }

    public static function getMailer(): SmtpMailer {
        $gmailUser = getenv('SMTP_GMAIL_USER') ?: 'zazadprod@gmail.com';
        $gmailPass = getenv('SMTP_GMAIL_APP_PASSWORD') ?: 'izjlbjxknpexsrfw';
        $config = new MailerConfig($gmailUser, $gmailPass);
        return new SmtpMailer($config);
    }

    public static function getVerifyEmailUseCase(): VerifyEmailUseCase {
        return new VerifyEmailService(self::getUserRepository());
    }
}
