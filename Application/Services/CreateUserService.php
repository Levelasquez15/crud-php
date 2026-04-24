<?php
// Application/Services/CreateUserService.php

class CreateUserService implements CreateUserUseCase {
    private SaveUserPort $saveUserPort;
    private GetUserByEmailPort $getUserByEmailPort;
    private SmtpMailer $mailer;

    public function __construct(SaveUserPort $saveUserPort, GetUserByEmailPort $getUserByEmailPort, SmtpMailer $mailer) {
        $this->saveUserPort = $saveUserPort;
        $this->getUserByEmailPort = $getUserByEmailPort;
        $this->mailer = $mailer;
    }

    public function execute(CreateUserCommand $cmd): UserModel {
        $email = new UserEmail($cmd->email());
        
        $existingUser = $this->getUserByEmailPort->getByEmail($email);
        if ($existingUser !== null) {
            throw UserAlreadyExistsException::becauseEmailAlreadyExists($email->value());
        }

        $userModel = UserApplicationMapper::fromCreateCommandToModel($cmd);
        
        // Generar token de verificación
        $verificationToken = bin2hex(random_bytes(32));
        
        // Guardar usuario con token
        $savedUser = $this->saveUserPort->save($userModel, $verificationToken);
        
        // Enviar email de verificación
        $verificationUrl = "http://localhost:8000/?route=auth.verify&token=" . urlencode($verificationToken);
        
        $emailTemplate = $this->renderEmailTemplate('verify-email', [
            'userName' => $userModel->name()->value(),
            'verificationUrl' => $verificationUrl
        ]);
        
        $this->mailer->send(
            $userModel->email()->value(),
            'Verifica tu correo electrónico',
            $emailTemplate
        );
        
        return $savedUser;
    }

    private function renderEmailTemplate(string $template, array $data): string {
        $viewFile = dirname(__DIR__, 2) . '/Presentation/Views/emails/' . $template . '.php';
        
        if (!file_exists($viewFile)) {
            throw new RuntimeException('Email template not found: ' . $template);
        }
        
        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        return ob_get_clean();
    }
}
