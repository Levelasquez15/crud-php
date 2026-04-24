<?php
// Application/Services/VerifyEmailService.php

class VerifyEmailService implements VerifyEmailUseCase {
    private VerifyEmailPort $repository;

    public function __construct(VerifyEmailPort $repository) {
        $this->repository = $repository;
    }

    public function execute(VerifyEmailCommand $command): UserModel {
        $user = $this->repository->findByToken($command->getToken());
        
        if ($user === null) {
            throw InvalidUserIdException::invalid('El token de verificación es inválido o ha expirado.');
        }

        $this->repository->markAsVerified($user->id()->value());
        
        return $user;
    }
}
