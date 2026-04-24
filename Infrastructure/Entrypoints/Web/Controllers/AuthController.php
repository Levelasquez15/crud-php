<?php
// Infrastructure/Entrypoints/Web/Controllers/AuthController.php

class AuthController {
    private LoginUseCase $loginUseCase;
    private VerifyEmailUseCase $verifyEmailUseCase;
    private SmtpMailer $mailer;

    public function __construct(
        LoginUseCase $loginUseCase,
        VerifyEmailUseCase $verifyEmailUseCase = null,
        SmtpMailer $mailer = null
    ) {
        $this->loginUseCase       = $loginUseCase;
        $this->verifyEmailUseCase = $verifyEmailUseCase;
        $this->mailer             = $mailer;
    }

    public function showLogin(): void {}

    public function authenticate(LoginWebRequest $request): UserResponse {
        $command = new LoginCommand($request->getEmail(), $request->getPassword());
        $user = $this->loginUseCase->execute($command);
        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->role(),
            $user->status()
        );
    }

    public function logout(): void {}

    public function showForgotPassword(): void {}

    public function processForgotPassword(string $email): void {
        if (empty($email)) return;

        try {
            $repo = DependencyInjection::getUserRepository();
            $user = $repo->getByEmail(new UserEmail($email));
        } catch (Throwable $e) {
            return;
        }

        if ($user === null) return;

        $token = bin2hex(random_bytes(32));
        $repo->savePasswordResetToken($email, $token);

        $scheme   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $baseUrl  = $scheme . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
        $resetUrl = rtrim($baseUrl, '/') . '/index.php?route=auth.reset&token=' . urlencode($token);

        $userName = $user->name()->value();
        ob_start();
        include __DIR__ . '/../../../../../Presentation/Views/emails/forgot-password.php';
        $htmlBody = ob_get_clean();

        $this->mailer->send($email, 'Recuperación de Contraseña - CRUD Hexagonal', $htmlBody);
    }

    public function showResetPassword(): void {}

    public function processResetPassword(string $token, string $newPassword): void {
        if (empty($token) || empty($newPassword)) {
            throw new RuntimeException('Token o contraseña inválidos.');
        }

        $repo = DependencyInjection::getUserRepository();
        $row  = $repo->findByPasswordResetToken($token);

        if ($row === null) {
            throw new RuntimeException('El enlace de recuperación es inválido o ha expirado.');
        }

        if (strlen($newPassword) < 8) {
            throw new RuntimeException('La contraseña debe tener al menos 8 caracteres.');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $repo->updatePasswordAndClearToken($row['id'], $hashedPassword);
    }

    public function verifyEmail(): UserResponse {
        if ($this->verifyEmailUseCase === null) {
            throw new RuntimeException('Email verification is not configured');
        }
        $token = $_GET['token'] ?? '';
        if (empty($token)) {
            throw InvalidUserIdException::invalid('Token de verificación ausente.');
        }
        $command = new VerifyEmailCommand($token);
        $user    = $this->verifyEmailUseCase->execute($command);
        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->role(),
            $user->status()
        );
    }
}