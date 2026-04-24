<?php
// Application/Services/DeleteUserService.php

class DeleteUserService implements DeleteUserUseCase {
    private GetUserByIdPort $getUserByIdPort;
    private DeleteUserPort $deleteUserPort;

    public function __construct(GetUserByIdPort $getUserByIdPort, DeleteUserPort $deleteUserPort) {
        $this->getUserByIdPort = $getUserByIdPort;
        $this->deleteUserPort = $deleteUserPort;
    }

    public function execute(DeleteUserCommand $cmd): void {
        $userId = new UserId($cmd->id());
        $user = $this->getUserByIdPort->getById($userId);

        if ($user === null) {
            throw UserNotFoundException::becauseIdWasNotFound($cmd->id());
        }

        $this->deleteUserPort->delete($userId);
    }
}
