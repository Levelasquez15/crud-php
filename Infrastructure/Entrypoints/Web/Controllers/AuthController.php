<?php
// Infrastructure/Entrypoints/Web/Controllers/AuthController.php

class AuthController {
    private LoginUseCase $loginUseCase;
    private VerifyEmailUseCase $verifyEmailUseCase;

    public function __construct(LoginUseCase $loginUseCase, VerifyEmailUseCase $verifyEmailUseCase = null) {
        $this->loginUseCase = $loginUseCase;
        $this->verifyEmailUseCase = $verifyEmailUseCase;
    }

    public function showLogin(): void {
        // handled in index.php
    }

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

    public function logout(): void {
        // handled directly in index.php
    }

    public function showForgotPassword(): void {
        // handled in index
    }

    public function processForgotPassword(string $email): void {
        // Se implementara el envio de correo aca proximamente
        // La guia indica que devuelva exito siempre.
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
        $user = $this->verifyEmailUseCase->execute($command);
        
        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->role(),
            $user->status()
        );
    }
}
