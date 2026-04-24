<?php
// Application/Services/UpdateUserService.php

class UpdateUserService implements UpdateUserUseCase {
    private GetUserByIdPort $getUserByIdPort;
    private GetUserByEmailPort $getUserByEmailPort;
    private UpdateUserPort $updateUserPort;

    public function __construct(
        GetUserByIdPort $getUserByIdPort,
        GetUserByEmailPort $getUserByEmailPort,
        UpdateUserPort $updateUserPort
    ) {
        $this->getUserByIdPort = $getUserByIdPort;
        $this->getUserByEmailPort = $getUserByEmailPort;
        $this->updateUserPort = $updateUserPort;
    }

    public function execute(UpdateUserCommand $cmd): UserModel {
        $userId = new UserId($cmd->id());
        $currentUser = $this->getUserByIdPort->getById($userId);

        if ($currentUser === null) {
            throw UserNotFoundException::becauseIdWasNotFound($cmd->id());
        }

        $newEmail = new UserEmail($cmd->email());
        if (!$currentUser->email()->equals($newEmail)) {
            $existing = $this->getUserByEmailPort->getByEmail($newEmail);
            if ($existing !== null) {
                throw UserAlreadyExistsException::becauseEmailAlreadyExists($cmd->email());
            }
        }

        $password = $cmd->plainPassword() !== '' 
            ? UserPassword::fromPlainText($cmd->plainPassword()) 
            : clone $currentUser->password(); // Reutiliza si esta vacia

        $updatedUser = new UserModel(
            $userId,
            new UserName($cmd->name()),
            $newEmail,
            $password,
            $cmd->role(),
            $cmd->status()
        );

        return $this->updateUserPort->update($updatedUser);
    }
}
